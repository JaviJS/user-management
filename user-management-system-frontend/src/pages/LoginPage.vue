<template>
  <v-container
    class="bg-surface-variant container d-flex justify-center align-center"
  >
    <v-card class="card">
      <v-row class="pa-10">
        <v-col cols="12" sm="12">
          <v-row no-gutters class="mt-5 mb-5">
            <v-col cols="12" sm="12" class="d-flex justify-center">
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
                  :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                  @click:append="showPassword = !showPassword"
                  :type="showPassword ? 'text' : 'password'"
                  v-model="password"
                  :rules="requiredRule('contraseña')"
                  label="Contraseña"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row no-gutters>
              <v-col cols="12" sm="12">
                <v-btn color="primary" class="mt-2" type="submit" block @click="validateForm"
                  >Submit</v-btn
                >
              </v-col>
            </v-row>
          </v-form>
          <v-row no-gutters class="mt-5 mb-5">
            <v-col cols="12" sm="12" class="d-flex justify-center">
              <p>
                ¿No tienes cuenta?
                <span style="color: rgb(24, 103, 192);" @click="goToRegister()">Registrate aquí</span>
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
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";

const store = useStore();
const router = useRouter();
const toast = useToast();

const form = ref(null);
const email = ref("");
const password = ref("");
const showPassword = ref(false);

// Reglas de validación para el formulario
const { emailRule, requiredRule } = validationForms();

const isValidForm = ref(false);

const validateForm = () => {
  //Validamos el formulario
  form.value.validate().then(({ valid: isValid }) => {
    if (isValid) {
      const data = {
        email: email.value,
        password: password.value,
      };
      // Si el email es verdadero realizamos el metodo LOGIN que esta en el store de usuario
      store.dispatch("user/LOGIN", data);
      isValidForm.value = true;
    } else {
      toast.error("Formulario inválido");
      isValidForm.value = false;
    }
  });
};
const goToRegister = () => {
  router.push("/registro");
};
onMounted(() => {});
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
