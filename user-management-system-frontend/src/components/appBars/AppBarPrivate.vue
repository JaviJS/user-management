<template>
  <v-app-bar color="primary" :elevation="2">
    <template v-slot:prepend>
      <v-app-bar-nav-icon  @click="buttonClick()"></v-app-bar-nav-icon>
    </template>
    <v-app-bar-title>Sistema de gestión de usuarios</v-app-bar-title>
    <ListUserInfo :title="name" :subtitle="role" :img="photo_user" type="light"/>
  </v-app-bar>
</template>
<script setup>
import ListUserInfo from "../lists/ListUserInfo.vue";
import { useStore } from "vuex";
import { ref } from "vue";
const store = useStore();
const name = store.getters["user/GET_USER"].name;
const role = store.getters["user/GET_ROLE_USER"];
const photo_user = store.getters["user/GET_PHOTO_USER"].url;

const emit = defineEmits(['statusDrawer'])
const openDrawer = ref(true);
const buttonClick = () => {
  openDrawer.value = !openDrawer.value;
  emit('status-drawer', openDrawer.value)
}
</script>
<style scoped lang="scss"></style>
