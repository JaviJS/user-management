<template>
  <v-dialog v-model="dialog" max-width="800px">
    <template v-slot:activator="{ props }">
      <v-icon v-bind="props" class="me-2" size="small" @click="loadData()">
        mdi-lock
      </v-icon>
    </template>
    <v-card>
      <v-form @submit.prevent ref="formChangePassword" class="pa-5">
        <v-card-title>
          <span class="text-h5">Editar contraseña</span>
        </v-card-title>
        <v-card-subtitle>
          <span>Esta seguro de cambiar contraseña de usuario:</span>
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
        <v-card-text>
          <v-row justify="center">
            <v-col cols="12" sm="12">
              <v-text-field
                :append-icon="showPassword1 ? 'mdi-eye' : 'mdi-eye-off'"
                @click:append="showPassword1 = !showPassword1"
                :type="showPassword1 ? 'text' : 'password'"
                v-model="newPasswordUser.actualPassword"
                :rules="requiredRule('contraseña actual')"
                label="Contraseña actual"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row justify="center">
            <v-col cols="12" sm="12">
              <v-text-field
                :append-icon="showPassword2 ? 'mdi-eye' : 'mdi-eye-off'"
                @click:append="showPassword2 = !showPassword2"
                :type="showPassword2 ? 'text' : 'password'"
                v-model="newPasswordUser.newPassword"
                :rules="
                  newPasswordRule(
                    'contraseña nueva',
                    newPasswordUser.actualPassword
                  )
                "
                label="Nueva contraseña"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row justify="center">
            <v-col cols="12" sm="12">
              <v-text-field
                :append-icon="showPassword3 ? 'mdi-eye' : 'mdi-eye-off'"
                @click:append="showPassword3 = !showPassword3"
                :type="showPassword3 ? 'text' : 'password'"
                v-model="newPasswordUser.newPasswordConfirmation"
                :rules="
                  passwordMatchRule(
                    'confirme contraseña nueva',
                    newPasswordUser.newPassword
                  )
                "
                label="Confirme nueva contraseña"
              ></v-text-field>
            </v-col>
          </v-row>
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
            @click="saveNewPassword()"
          >
            Guardar
          </v-btn>
        </v-card-actions>
      </v-form>
    </v-card>
  </v-dialog>
</template>
<script setup>
import { ref, onMounted, getCurrentInstance } from "vue";
import userService from "./../../services/user.service";
import { validationForms } from "../../composables/validationForms.composables.js";
import ListUserInfo from "../lists/ListUserInfo.vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";

const { requiredRule, newPasswordRule, passwordMatchRule } = validationForms();

const store = useStore();
const router = useRouter();
const toast = useToast();

const props = defineProps(["userId"]);
const emit = defineEmits(["changeUser"]);

const dialog = ref(false);
const formChangePassword = ref(null);
const user = ref({
  name: "",
  email: "",
  photoUser: null,
});
const showPassword1 = ref(false);
const showPassword2 = ref(false);
const showPassword3 = ref(false);

const newPasswordUser = ref({
  actualPassword: "",
  newPassword: "",
  newPasswordConfirmation: "",
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
      toast.error("Error al cargar información de usuario.");
      if (error?.response?.status === 401) {
        store.dispatch("user/CLEAR_USER");
        router.push("/login");
        toast.error("No autorizado");
      }
    });
};

/** 
* Método para validar el formulario para ingresar una contraseña.
* Si formulario es válido, se ejecutara el método changePassword
* En caso de formulario inválido, se mostrara un mensaje
*/
const saveNewPassword = () => {
  formChangePassword.value.validate().then(async ({ valid: isValid }) => {
    if (isValid) {
      const newPass = {
        actual_password: newPasswordUser.value.actualPassword,
        new_password: newPasswordUser.value.newPassword,
        new_password_confirmation:
          newPasswordUser.value.newPasswordConfirmation,
      };
      await changePassword(newPass);
    } else {
      // La validación falló
      toast.error("Formulario inválido");
    }
  });
};

/**
 * Función asincrónica para cambiar la contraseña de un usuario.
 * Utiliza el token de autenticación obtenido del store.
 * Llama al servicio userService para enviar los datos de cambio de contraseña al servidor.
 * Maneja la respuesta exitosa mostrando un mensaje de éxito, emitiendo un evento "change-user" para actualizar la tabla de usuarios
 * Maneja los errores mostrando un mensaje de error en caso de fallo.
 * @param {object} data - Los datos necesarios para cambiar la contraseña del usuario.
 */
const changePassword = async (data) => {
  const token = store.getters["user/GET_TOKEN"];
  await userService
    .changePassword(data, props.userId, token)
    .then(() => {
      toast.success("contraseña modificada con éxito");
      emit("change-user");
      closeDialog();
    })
    .catch((error) => {
      toast.error("Error al modificar contraseña");
    });
};
/**
 * Método para limpiar el formulario
 */
const clearForm = async () => {
  formChangePassword.value.reset();
  formChangePassword.value.resetValidation();
};
const closeDialog = () => {
  dialog.value = false;
  clearForm();
};
</script>
<style scoped lang="scss"></style>
