<template>
  <v-responsive class="border rounded" max-height="100%">
    <v-app>
      <AppBarPrivate @status-drawer="statusDrawer" />
      <DrawerPrivate :items="items" :rail="rail" />
      <v-main>
        <v-container>
          <router-view></router-view>
        </v-container>
      </v-main>
    </v-app>
  </v-responsive>
</template>
<script setup>
import { ref } from "vue";
import AppBarPrivate from "../../components/appBars/AppBarPrivate.vue";
import DrawerPrivate from "../../components/drawers/DrawerPrivate.vue";

const items = ref([
  {
    id: 1,
    icon: "mdi-account",
    title: "Listar usuarios",
    value: "account",
    to: "/private/usuarios",
  },
  {
    id: 2,
    icon: "mdi-account-plus",
    title: "Crear usuario",
    value: "account-plus",
    to: "/private/crear-usuario",
  },
]);
const rail = ref(true);
const statusDrawer = (value) => {
  rail.value = value;
};
</script>
<style scoped></style>
