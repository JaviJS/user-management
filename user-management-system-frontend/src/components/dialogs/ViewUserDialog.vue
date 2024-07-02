<template>
  <v-dialog v-model="dialog" max-width="800px">
    <template v-slot:activator="{ props }">
      <v-icon v-bind="props" size="small" @click="loadData()"> mdi-eye </v-icon>
    </template>
    <v-card>
      <v-card-title>
        <span class="text-h5">Ver usuario</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-row no-gutters class="mt-5">
            <v-col cols="12" sm="12" class="d-flex justify-center">
              <v-avatar size="180px">
                <v-img alt="Imagen usuario" :src="user.photoUser"></v-img>
              </v-avatar>
            </v-col>
          </v-row>
          <v-row no-gutters class="mt-5">
            <v-col cols="12" sm="6">
              <p>Nombre</p>
              <p>{{ user.name }} {{ user.lastName }}</p>
            </v-col>
            <v-col cols="12" sm="6" :class="$vuetify.display.xs ? 'mt-5' : ''">
              <p>Correo electrónico</p>
              <p>{{ user.email }}</p>
            </v-col>
          </v-row>
          <v-row no-gutters class="mt-5">
            <v-col cols="12" sm="6">
              <p>Teléfono</p>
              <p>{{ user.phone }}</p>
            </v-col>
            <v-col cols="12" sm="6" :class="$vuetify.display.xs ? 'mt-5' : ''">
              <p>Fecha de nacimiento</p>
              <p>{{ user.birthdayDate }}</p>
            </v-col>
          </v-row>
          <v-row no-gutters class="mt-5">
            <v-col cols="12" sm="6">
              <p>Rol</p>
              <p>{{ user.role }}</p>
            </v-col>
            <v-col cols="12" sm="6" :class="$vuetify.display.xs ? 'mt-5' : ''">
              <p>Estado</p>
              <p>{{ user.status }}</p>
            </v-col>
          </v-row>
          <v-row no-gutters class="mt-5">
            <v-col cols="12" sm="6">
              <p>Fecha de creación</p>
              <p>{{ user.createdAt }}</p>
            </v-col>
            <v-col cols="12" sm="6" :class="$vuetify.display.xs ? 'mt-5' : ''">
              <p>Fecha de modificación</p>
              <p>{{ user.updatedAt }}</p>
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue-darken-1" variant="text" @click="closeDialog()">
          Cerrar
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script setup>
import { ref, onMounted, watch, computed, getCurrentInstance } from "vue";
import userService from "./../../services/user.service";
import { useToast } from "vue-toastification";
import { useRouter } from "vue-router";
import { useStore } from "vuex";

const { appContext } = getCurrentInstance();
const moment = appContext.config.globalProperties.$moment;

const store = useStore();
const router = useRouter();
const toast = useToast();

const props = defineProps(["userId"]);

const dialog = ref(false);
const user = ref({
  name: "",
  lastName: "",
  email: "",
  phone: "",
  birthdayDate: null,
  role: "",
  status: "",
  photoUser: "",
  createdAt: null,
  updatedAt: null,
});

const loadData = async () => {
  await loadUser();
};

const loadUser = async () => {
  const token = store.getters["user/GET_TOKEN"];
  await userService
    .getUser(props.userId, token)
    .then((data) => {
      user.value = {
        name: data.name,
        lastName: data.last_name,
        email: data.email,
        phone: data.phone,
        birthdayDate: moment(new Date(data.birthday_date)).format("DD-MM-YYYY"),
        role: data.role,
        status: data.status,
        photoUser: data.photo_user?.url,
        createdAt: moment(new Date(data.created_at)).format(
          "DD-MM-YYYY HH:mm:ss"
        ),
        updatedAt: moment(new Date(data.updated_at)).format(
          "DD-MM-YYYY HH:mm:ss"
        ),
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

const closeDialog = () => {
  dialog.value = false;
};
</script>
<style scoped lang="scss"></style>
