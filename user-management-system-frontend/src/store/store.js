import { createStore } from "vuex";
import VuexPersist from "vuex-persist";
import user from "./user.module";

const vuexLocalStorage = new VuexPersist({
  key: "STORAGE-KEY", // The key to store the state on in the storage provider.
  storage: window.localStorage, // or window.sessionStorage or localForage
});

const store = createStore({
  modules: {
    user,
  },
  state: {},
  mutations: {},
  actions: {},
  plugins: [vuexLocalStorage.plugin],
});
export default store;
