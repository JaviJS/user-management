import { createRouter, createWebHistory } from "vue-router";
import LoginPage from "../pages/LoginPage.vue";
import RegisterPage from "../pages/RegisterPage.vue";
import PrivatePage from "../pages/private/PrivatePage.vue";
import PrivateRoutes from "../pages/private/routes";
import Store from "../store/store";
const routes = [
  {
    path: "/",
    redirect: "/login",
    meta: {
      requiresAuth: false,
    },
  },
  {
    path: "/login",
    name: "Login",
    component: LoginPage,
    meta: {
      requiresAuth: false,
    },
  },
  {
    path: "/registro",
    name: "Register",
    component: RegisterPage,
    meta: {
      requiresAuth: false,
    },
  },
  {
    path: "/private",
    name: "Private",
    component: PrivatePage,
    redirect: { name: "Private.Users" },
    children: PrivateRoutes,
    meta: {
      requiresAuth: true,
    },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Guardian global antes de cada navegación
router.beforeEach((to, from, next) => {
  // Verifica si alguna de las rutas coincidentes requiere autenticación
  const authRequired = to.matched.some((m) => m.meta.requiresAuth);

  // Obtiene el usuario del estado del store
  const user = Store.state.user.user;

  // Si la ruta requiere autenticación
  if (authRequired) {
    // Si no hay un usuario autenticado, redirige a la página de login
    if (!user) {
      next({ name: "Login" });
    }
  } else {
    // Si la ruta no requiere autenticación

    // Si hay un usuario autenticado, redirige a la página privada
    if (user) {
      next({ name: "Private" });
    }
  }
  next();
  return true;
});
export default router;
