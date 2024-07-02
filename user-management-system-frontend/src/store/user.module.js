import authService from "../services/auth.service";
import { useRouter } from "vue-router";
import router from "../routes/routes";
import { useToast } from "vue-toastification";

const toast = useToast();

const userStore = {
  namespaced: true,
  state: {
    isAuth: false,
    token: null,
    user: null,
  },
  getters: {
    GET_USER: (state) => state.user,
    GET_TOKEN: (state) => state.token,
    GET_IS_AUTH: (state) => state.isAuth,
    GET_ROLE_USER: (state) => state.user?.role,
    GET_PHOTO_USER: (state) =>
      state.user?.photo_user ? state.user?.photo_user : {},
  },
  mutations: {
    SET_USER(state, user) {
      state.user = user;
    },
    SET_TOKEN: (state, token) => {
      state.token = token;
    },
    SET_IS_AUTH: (state, data) => {
      state.isAuth = data;
    },
    CLEAR_USER(state) {
      state.user = null;
      state.token = null;
      state.isAuth = false;
    },
  },
  actions: {
    SET_USER({ commit }, user) {
      commit("SET_USER", user);
    },
    SET_TOKEN: ({ commit }, token) => {
      return commit("SET_TOKEN", token);
    },
    SET_IS_AUTH: ({ commit }, data) => {
      return commit("SET_IS_AUTH", data);
    },
    CLEAR_USER({ commit }) {
      commit("CLEAR_USER");
    },
    LOGIN: ({ commit }, data) => {
      authService.login(data).then(
        (user) => {
          commit("SET_USER", user.user);
          commit("SET_TOKEN", user.token);
          commit("SET_IS_AUTH", true);
          router.push("/private");
          toast.success("Inicio de sesión con éxito");
          return Promise.resolve(user);
        },
        (error) => {
          toast.error("Error al iniciar sesión");
          return Promise.reject(error);
        }
      );
    },
    LOGOUT: ({ commit, getters }) => {
      authService.logout(getters.GET_TOKEN).then(
        (data) => {
          commit("CLEAR_USER");
          router.push("/login");
          toast.success("Cierre de sesión con éxito");
          return Promise.resolve(data);
        },
        (error) => {
          commit("CLEAR_USER");
          router.push("/login");
          toast.error("Error al cerrar sesión");
          return Promise.reject(error);
        }
      );
    },
  },
};

export default userStore;
