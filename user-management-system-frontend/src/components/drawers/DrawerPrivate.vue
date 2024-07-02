<template>
  <v-navigation-drawer
    v-model="drawer"
    :rail="$vuetify.display.xs ? false : props.rail"
    :permanent="$vuetify.display.xs ? false : true"
  >
    <ListUserInfo :title="name" :subtitle="email" :img="photo_user" />
    <v-divider></v-divider>
    <v-list density="compact" nav>
      <v-list-item
        v-for="item in props.items"
        :key="item.id"
        :active="item.id === selectedItem"
        :prepend-icon="item.icon"
        :title="item.title"
        :value="item.value"
        @click="goToPage(item.to)"
      ></v-list-item>
    </v-list>
    <template v-slot:append>
      <v-list density="compact" nav>
        <v-list-item
          prepend-icon="mdi-logout"
          title="Cerrar Sesión"
          value="logout"
          @click="logout()"
        ></v-list-item>
      </v-list>
    </template>
  </v-navigation-drawer>
</template>
<script setup>
import { useRouter, useRoute } from "vue-router";
import ListUserInfo from "../lists/ListUserInfo.vue";
import { useStore } from "vuex";
import { ref, watch, onMounted } from "vue";

const props = defineProps(["rail", "items"]);
const store = useStore();
const name = store.getters["user/GET_USER"].name;
const email = store.getters["user/GET_USER"].email;
const photo_user = store.getters["user/GET_PHOTO_USER"].url;
const router = useRouter();
const route = useRoute();
const drawer = ref(true);
// const rail = ref(true);
const selectedItem = ref("");
console.log({ rail: props.rail });
onMounted(async () => {
  const currentRoute = props.items.find((x) => x.to === route.path);
  selectedItem.value = currentRoute?.id ?? null;
});

const goToPage = (to) => {
  if (route.path !== to) {
    router.push(to);
  }
};
const logout = () => {
  store.dispatch("user/LOGOUT");
}
watch(selectedItem, (newValue) => {
  if (typeof newValue === "undefined") {
    setTimeout(() => {
      selectedItem.value = 0;
    }, 500);
  }
});
// Watch route changes
watch(route, (newPath) => {
  const currentRoute = props.items.find((x) => x.to === newPath.path);
  selectedItem.value = currentRoute?.id ?? null;
});
watch(
  () => props.rail,
  (newValue) => {
    console.log(props.rail);
    // if (this.$vuetify.breakpoint.xsOnly) {
    drawer.value = newValue;
    console.log(drawer.value);
    // }
  }
);
</script>
<style scoped lang="scss"></style>
