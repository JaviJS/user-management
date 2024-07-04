<template>
  <v-navigation-drawer
    v-model="drawer"
    :rail="!$vuetify.display.xs && props.openDrawer"
    :permanent="!$vuetify.display.xs"
    :tempory="$vuetify.display.xs"
  >
    <ListUserInfo
      :title="name"
      :subtitle="email"
      :img="photo_user"
      type="dark"
    />
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
import { useDisplay } from "vuetify";
const router = useRouter();
const store = useStore();
const route = useRoute();
const display = useDisplay();

const props = defineProps(["openDrawer", "items"]);

const name = store.getters["user/GET_USER"].name;
const email = store.getters["user/GET_USER"].email;
const photo_user = store.getters["user/GET_PHOTO_USER"].url;

const drawer = ref(true);

const selectedItem = ref("");

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
};
watch(
  () => selectedItem.value,
  (newValue) => {
    if (typeof newValue === "undefined") {
      setTimeout(() => {
        selectedItem.value = 0;
      }, 500);
    }
  }
);
// Watch route changes
watch(route, (newPath) => {
  const currentRoute = props.items.find((x) => x.to === newPath.path);
  selectedItem.value = currentRoute?.id ?? null;
});
watch(
  () => props.openDrawer,
  (newValue) => {
    drawer.value = display.xs.value ? newValue : true;
  }
);
watch(() => display.xs.value, (newValue) => {
  drawer.value = newValue ? null : props.openDrawer;
});
</script>
<style scoped lang="scss"></style>
