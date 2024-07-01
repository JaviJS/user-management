<template>
  <v-container
    class="bg-surface-variant container d-flex justify-center align-center"
  >
    <v-card class="card">
      <v-row class="pa-5">
        <v-col cols="12" sm="12">
          <v-row no-gutters>
            <v-col cols="12" sm="12" class="card__avatar">
              <v-img :width="180" cover src="../assets/icons/nina.png"></v-img>
            </v-col>
          </v-row>
          <v-row no-gutters>
            <v-col cols="12" sm="12">
              <div class="text-h5">Iniciar Sesión</div>
            </v-col>
          </v-row>
          <v-form @submit.prevent ref="form">
            <v-row no-gutters>
              <v-col cols="12" sm="12">
                <v-text-field
                  v-model="email"
                  :rules="emailRule('correo electrónico')"
                  label="Nombre"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row no-gutters>
              <v-col cols="12" sm="12">
                <v-text-field
                  v-model="password"
                  :rules="requiredRule('contraseña')"
                  label="Contraseña"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row no-gutters>
              <v-col cols="12" sm="12">
                <v-btn class="mt-2" type="submit" block @click="validateForm"
                  >Submit</v-btn
                >
              </v-col>
            </v-row>
          </v-form>
          {{ email }}
          {{ password }}
          <v-row no-gutters>
            <v-col cols="12" sm="12">
              <p class="card__register_label">
                ¿No tienes cuenta?
                <span @click="goToRegister()">Registrate aquí</span>
              </p>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </v-card>
  </v-container>
</template>
<script setup>
import { ref, watch, onMounted } from "vue";
import { validationForms } from "../composables/validationForms.composables.js";
import { useStore } from "vuex";

const form = ref(null);
const email = ref("");
const password = ref("");
const { emailRule, requiredRule } = validationForms();
const store = useStore();
const validateForm = () => {
  form.value.validate().then(({ valid: isValid }) => {
    if (isValid) {
      const data = {
        email: email.value,
        password: password.value,
      };
      store.dispatch("user/LOGIN", data);
    } else {
      // La validación falló
      console.log("Formulario inválido");
    }
  });
};
const goToRegister = () => {
  console.log("goToRegister");
};
onMounted(() => {
});
</script>
<style scoped lang="scss">
.container {
  max-width: 100% !important;
  width: 100%;
  height: 100vh;
  margin: 0px !important;
}
.card {
  border-radius: 60px;
  width: 600px;
  &__avatar {
    display: flex;
    justify-content: center;
  }
}
</style>
