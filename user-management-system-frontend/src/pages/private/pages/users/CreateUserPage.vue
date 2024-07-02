<template>
  <div id="CreateUserPage" class="mt-10 custom-size-page">
    <v-row justify="center" class="mt-8">
      <v-col cols="12" md="12" sm="12" class="text-left">
        <v-card>
          <v-row>
            <v-col cols="12">
              <v-card-title class="custom-text pl-10 pr-10">
                Crear usuario
              </v-card-title>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>
    <v-row justify="center" class="mt-8">
      <v-col cols="12" md="12" sm="12">
        <v-card>
          <v-form @submit.prevent ref="formUser" class="pa-5">
            <v-row justify="center" class="mt-8">
              <v-col cols="12" sm="6">
                <v-text-field
                  v-model="user.name"
                  :rules="personRule('nombre')"
                  label="Nombre"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field
                  v-model="user.lastName"
                  :rules="personRule('apellido')"
                  label="Apellido"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row justify="center">
              <v-col cols="12" sm="6">
                <v-text-field
                  v-model="user.email"
                  :rules="emailRule('correo electrónico')"
                  label="Correo electrónico"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field
                  v-model="user.phone"
                  :rules="phoneRule('teléfono')"
                  label="Teléfono"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row justify="center">
              <v-col cols="12" sm="6">
                <v-text-field
                  v-model="user.password"
                  :rules="passwordRule('contraseña')"
                  label="Contraseña"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field
                  v-model="user.passwordConfirmation"
                  :rules="
                    passwordMatchRule('confirme contraseña', user.password)
                  "
                  label="Confirme contraseña"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row justify="center">
              <v-col cols="12" sm="6">
                <v-date-input
                  v-model="user.birthdayDate"
                  label="Fecha de nacimiento"
                  placeholder="Formato mm/dd/YYYY"
                  :rules="requiredDateRule('fecha de nacimiento')"
                ></v-date-input>
              </v-col>
              <v-col cols="12" sm="6">
                <v-file-input
                  ref="fileUpload"
                  id="fileInput"
                  v-model="user.photoUser"
                  accept="image/png, image/jpeg, image/jpg"
                  :rules="fileRule('foto de usuario')"
                  label="Foto de usuario"
                ></v-file-input>
              </v-col>
            </v-row>
            <v-row justify="center">
              <v-col cols="12" sm="6">
                <v-select
                  v-model="user.status"
                  :items="statusUser"
                  label="Estado"
                  :rules="formGroupRule2('estado')"
                ></v-select>
              </v-col>
              <v-col cols="12" sm="6">
                <v-select
                  v-model="user.role"
                  :items="rolesUser"
                  label="Rol"
                  :rules="formGroupRule2('rol')"
                ></v-select>
              </v-col>
            </v-row>
            <v-row justify="center">
              <v-col cols="12">
                <v-btn class="me-4" type="submit" @click="validateFormUser">
                  Guardar
                </v-btn>
                <v-btn @click="clearForm"> Limpiar </v-btn>
              </v-col>
            </v-row>
          </v-form>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>
<script setup>
import { validationForms } from "../../../../composables/validationForms.composables.js";
import userService from "./../../../../services/user.service";
import { ref, onMounted, getCurrentInstance } from "vue";
import { useToast } from "vue-toastification";

const { appContext } = getCurrentInstance();
const moment = appContext.config.globalProperties.$moment;

const {
  emailRule,
  formGroupRule2,
  personRule,
  requiredDateRule,
  passwordRule,
  passwordMatchRule,
  phoneRule,
  fileRule,
} = validationForms();

const toast = useToast();

const statusUser = ref([]);
const rolesUser = ref([]);
const formUser = ref(null);
const fileUpload = ref(null);
const user = ref({
  name: "",
  lastName: "",
  email: "",
  password: "",
  passwordConfirmation: "",
  phone: "",
  birthdayDate: null,
  role: "",
  status: "",
  photoUser: null,
});

onMounted(async () => {
  await loadStatusUser();
  await loadRolesUser();
});

const loadStatusUser = async () => {
  await userService
    .getStatus()
    .then((data) => {
      statusUser.value = data;
    })
    .catch((error) => {
      toast.error("Error al listar estados de usuario");
    });
};

const loadRolesUser = async () => {
  await userService
    .getRoles()
    .then((data) => {
      rolesUser.value = data;
    })
    .catch(() => {
      toast.error("Error al listar roles de usuario");
    });
};
const createUser = async (data) => {
  await userService
    .createUser(data)
    .then(() => {
      clearForm();
      toast.success("Usuario creado con éxito");
    })
    .catch(() => {
      toast.error("Error al crear usuario");
    });
};
const clearForm = () => {
  formUser.value.items.forEach((input) => {
    if (input.id !== "fileInput") {
      input.reset();
    }
  });
  user.value.photoUser = null;
  fileUpload.value = null;
  formUser.value.resetValidation();
};
const validateFormUser = () => {
  formUser.value.validate().then(({ valid: isValid }) => {
    if (isValid) {
      const formDataUser = new FormData();
      formDataUser.append("name", user.value.name);
      formDataUser.append("last_name", user.value.lastName);
      formDataUser.append("email", user.value.email);
      formDataUser.append("password", user.value.password);
      formDataUser.append(
        "password_confirmation",
        user.value.passwordConfirmation
      );
      formDataUser.append("phone", user.value.phone);
      formDataUser.append(
        "birthday_date",
        moment(user.value.birthdayDate).format("DD-MM-YYYY")
      );
      formDataUser.append("role", user.value.role);
      formDataUser.append("status", user.value.status);
      formDataUser.append("photo_user", user.value.photoUser);
      createUser(formDataUser);
    } else {
      // La validación falló
      toast.error("Formulario inválido");
    }
  });
};
</script>
<style scoped lang="scss"></style>
