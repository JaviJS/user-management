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
          <form @submit.prevent ref="form" class="pa-5">
            <v-row justify="center" class="mt-8">
              <v-col cols="12" sm="6">
                <v-text-field label="Nombre"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field label="Apellido"></v-text-field>
              </v-col>
            </v-row>
            <v-row justify="center">
              <v-col cols="12" sm="6">
                <v-text-field label="Correo electrónico"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field label="Teléfono"></v-text-field>
              </v-col>
            </v-row>
            <v-row justify="center">
              <v-col cols="12" sm="6">
                <v-text-field label="Contraseña"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field label="Confirme contraseña"></v-text-field>
              </v-col>
            </v-row>
            <v-row justify="center">
              <v-col cols="12" sm="6">
                <v-date-input label="Fecha de nacimiento"></v-date-input>
              </v-col>
              <v-col cols="12" sm="6">
                <v-file-input label="Foto de usuario"></v-file-input>
              </v-col>
            </v-row>
            <v-row justify="center">
              <v-col cols="12" sm="6">
                <v-select :items="statusUser" label="Estado"></v-select>
              </v-col>
              <v-col cols="12" sm="6">
                <v-select :items="rolesUser" label="Rol"></v-select>
              </v-col>
            </v-row>
            <v-row justify="center">
              <v-col cols="12">
                <v-btn class="me-4" type="submit"> submit </v-btn>
                <v-btn @click="handleReset"> clear </v-btn>
              </v-col>
            </v-row>
          </form>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>
<script setup>
import userService from "./../../../../services/user.service";
import { ref, onMounted } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
const router = useRouter();
const store = useStore();
const statusUser = ref([]);
const rolesUser = ref([]);

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
      console.log("Error al listar estados de usuario");
      if (error?.response?.status === 401) {
        store.dispatch("user/CLEAR_USER");
        router.push("/login");
        console.log("No autorizado");
      }
    });
};

const loadRolesUser = async () => {
  await userService
    .getRoles()
    .then((data) => {
      rolesUser.value = data;
    })
    .catch((error) => {
      console.log("Error al listar roles de usuario");
      if (error?.response?.status === 401) {
        store.dispatch("user/CLEAR_USER");
        router.push("/login");
        console.log("No autorizado");
      }
    });
};
const goToUsers = () => {
  router.push("/private/usuarios");
};
</script>
<style scoped lang="scss"></style>
