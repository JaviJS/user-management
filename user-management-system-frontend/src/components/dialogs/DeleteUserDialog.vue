<template>
  <v-dialog v-model="dialog" max-width="800px">
    <template v-slot:activator="{ props }">
      <v-icon v-bind="props" size="small" @click="loadData()">
        mdi-delete
      </v-icon>
    </template>
    <v-card>
      <v-card-title>
        <span class="text-h5">Eliminar usuario</span>
      </v-card-title>
      <v-card-subtitle>
        <span>Esta seguro de eliminar a usuario:</span>
      </v-card-subtitle>
      <v-card-text>
        <v-container>
          <ListUserInfo
            :title="user.name"
            :subtitle="user.email"
            :img="user.photoUser"
            type="dark"
          />
        </v-container>
      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue-darken-1" variant="text" @click="closeDialog()">
          Cancelar
        </v-btn>
        <v-btn
          color="blue-darken-1"
          type="submit"
          variant="text"
          @click="deleteUser()"
        >
          Eliminar
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script setup>
import { ref, onMounted, watch, computed, getCurrentInstance } from "vue";
import userService from "./../../services/user.service";
import ListUserInfo from "../lists/ListUserInfo.vue";
import { useToast } from "vue-toastification";
import { useRouter } from "vue-router";
import { useStore } from "vuex";

const store = useStore();
const router = useRouter();
const toast = useToast();

const props = defineProps(["userId"]);
const emit = defineEmits(["changeUser"]);

const dialog = ref(false);
const user = ref({
  name: "",
  email: "",
  photoUser: null,
});

const loadData = async () => {
  await loadUser();
};

/** 
* Método para cargar información del usuario seleccionado
* Llama al servicio userService y realiza una consulta get para obtener la información del usuario
*/
const loadUser = async () => {
  const token = store.getters["user/GET_TOKEN"];
  await userService
    .getUser(props.userId, token)
    .then((data) => {
      user.value = {
        name: data.name + " " + data.last_name,
        email: data.email,
        photoUser: data.photo_user?.url,
      };
    })
    .catch((error) => {
      toast.error("Error al cargar información de usuario");
      if (error?.response?.status === 401) {
        store.dispatch("user/CLEAR_USER");
        router.push("/login");
        toast.error("No autorizado");
      }
    });
};

/**
 * Función asincrónica para eliminar un usuario.
 * Utiliza el token de autenticación obtenido del store.
 * Llama al servicio userService para eliminar al usuario del servidor.
 * Maneja la respuesta exitosa mostrando un mensaje de éxito, emitiendo un evento "change-user" para actualizar la tabla de usuarios
 * Maneja los errores mostrando un mensaje de error en caso de fallo.
 */
const deleteUser = async () => {
  const token = store.getters["user/GET_TOKEN"];
  const userSession = store.getters["user/GET_USER"];
  await userService
    .deleteUser(props.userId, token)
    .then(() => {
      toast.success("usuario eliminado con éxito");
      if (props.userId === userSession.id) {
        store.dispatch("user/CLEAR_USER");
        router.push("/login");
        toast.error("Usted ha sido eliminado");
      } else {
        emit("change-user");
        closeDialog();
      }
    })
    .catch((error) => {
      toast.error("Error al eliminar usuario");
      if (error?.response?.status === 401) {
        store.dispatch("user/CLEAR_USER");
        router.push("/login");
        toast.error("No autorizado");
      }
    });
};
const closeDialog = () => {
  dialog.value = false;
};
</script>
<style scoped lang="scss"></style>
