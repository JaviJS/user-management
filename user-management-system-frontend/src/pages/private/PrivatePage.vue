<template>
  <v-responsive class="border rounded" max-height="100%">
    <v-app>
      <AppBarPrivate @status-drawer="statusDrawer" />
      <DrawerPrivate :items="items" :openDrawer="openDrawer" />
      <v-main class="bg-blue-grey-lighten-5">
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
const openDrawer = ref(true);
const statusDrawer = (value) => {
  openDrawer.value = value;
};
</script>
<style scoped></style>
