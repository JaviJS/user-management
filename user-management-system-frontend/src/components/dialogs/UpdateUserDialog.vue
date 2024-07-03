<template>
  <v-dialog id="modal" v-model="dialog" max-width="800px">
    <template v-slot:activator="{ props }">
      <v-icon id="openDialog" v-bind="props" class="me-2" size="small" @click="loadData()">
        mdi-pencil
      </v-icon>
    </template>
    <v-card>
      <v-form @submit.prevent ref="formUser" class="pa-5">
        <v-card-title>
          <span class="text-h5">Editar usuario</span>
        </v-card-title>
        <v-card-text>
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
                v-model="user.birthdayDate"
                type="date"
                label="Fecha de nacimiento"
                placeholder="mm-dd-YYYY"
                :rules="requiredDateRule('fecha de nacimiento')"
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="6">
              <v-file-input
                ref="fileUpload"
                id="fileInput"
                v-model="user.photoUser"
                accept="image/png, image/jpeg, image/jpg"
                label="Foto de usuario"
                :rules="fileNoRequiredRule()"
                @change="handleFileChange"
              >
                <template v-slot:prepend>
                  <v-avatar size="36px">
                    <v-img
                      alt="Avatar"
                      :src="isNewFile ? newPhotoURL : user.photoUserURL"
                    ></v-img>
                  </v-avatar>
                </template>
              </v-file-input>
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
            @click="saveUser"
          >
            Guardar
          </v-btn>
        </v-card-actions>
      </v-form>
    </v-card>
  </v-dialog>
</template>
<script setup>
import { ref, onMounted, watch, computed, getCurrentInstance } from "vue";
import userService from "./../../services/user.service";
import { validationForms } from "../../composables/validationForms.composables.js";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";

const { appContext } = getCurrentInstance();
const moment = appContext.config.globalProperties.$moment;

const {
  emailRule,
  formGroupRule2,
  personRule,
  requiredDateRule,
  phoneRule,
  fileNoRequiredRule,
} = validationForms();

const store = useStore();
const router = useRouter();
const toast = useToast();

const props = defineProps(["userId"]);
const emit = defineEmits(["changeUser"]);

const statusUser = ref([]);
const rolesUser = ref([]);
const dialog = ref(false);
const formUser = ref(null);
const fileUpload = ref(null);
const user = ref({
  name: "",
  lastName: "",
  email: "",
  phone: "",
  birthdayDate: null,
  role: "",
  status: "",
  photoUser: null,
  photoUserURL: null,
});
const newPhotoURL = ref("");

const isNewFile = computed(() => !!newPhotoURL.value);

watch(
  () => user.value.photoUser,
  (newVal) => {
    if (newVal === null) {
      newPhotoURL.value = ""; // Reinicia la URL de la nueva foto
    }
  }
);

const loadData = async () => {
  await loadUser();
  await loadStatusUser();
  await loadRolesUser();
};

const handleFileChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = (e) => {
      newPhotoURL.value = e.target.result;
    };
    reader.readAsDataURL(file);
  }
};

const loadStatusUser = async () => {
  await userService
    .getStatus()
    .then((data) => {
      statusUser.value = data;
    })
    .catch(() => {
      toast.error("Error al listar estados de usuario");
    });
};

const loadRolesUser = async () => {
  await userService
    .getRoles()
    .then((data) => {
      rolesUser.value = data;
    })
    .catch((error) => {
      toast.error("Error al listar roles de usuario");
    });
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
        birthdayDate: moment(data.birthday_date).format("YYYY-MM-DD"),
        role: data.role,
        status: data.status,
        photoUser: null,
        photoUserURL: data.photo_user?.url,
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

const saveUser = () => {
  formUser.value.validate().then(async ({ valid: isValid }) => {
    if (isValid) {
      const formDataUser = new FormData();
      formDataUser.append("name", user.value.name);
      formDataUser.append("last_name", user.value.lastName);
      formDataUser.append("email", user.value.email);
      formDataUser.append("phone", user.value.phone);
      formDataUser.append(
        "birthday_date",
        moment(user.value.birthdayDate).format("DD-MM-YYYY")
      );
      formDataUser.append("role", user.value.role);
      formDataUser.append("status", user.value.status);
      if (user.value.photoUser) {
        formDataUser.append("photo_user", user.value.photoUser);
      }
      await updateUser(formDataUser);
    } else {
      // La validación falló
      toast.error("Formulario inválido");
    }
  });
};

const updateUser = async (data) => {
  const token = store.getters["user/GET_TOKEN"];
  const userSession = store.getters["user/GET_USER"];
  await userService
    .editUser(data, props.userId, token)
    .then(() => {
      toast.success("Modificado con éxito");
      if (props.userId === userSession.id && user.value.status === "Inactivo") {
        store.dispatch("user/CLEAR_USER");
        router.push("/login");
        toast.error("Usted ha sido eliminado");
      } else {
        emit("change-user");
        closeDialog();
      }
    })
    .catch((error) => {
      toast.error("Error al crear usuario");
      if (error?.response?.status === 401) {
        store.dispatch("user/CLEAR_USER");
        router.push("/login");
        toast.error("No autorizado");
      }
    });
};

const clearForm = async () => {
  formUser.value.items.forEach((input) => {
    if (input.id !== "fileInput") {
      input.reset();
    }
  });
  user.value.photoUser = null;
  fileUpload.value = null;
  formUser.value.resetValidation();
  await loadUser();
};

const closeDialog = () => {
  dialog.value = false;
  clearForm();
};
</script>
<style scoped lang="scss"></style>
