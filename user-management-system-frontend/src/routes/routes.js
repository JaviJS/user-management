import { createRouter, createWebHistory } from "vue-router";
import LoginPage from "../pages/LoginPage.vue";
import RegisterPage from "../pages/RegisterPage.vue";
import PrivatePage from "../pages/private/PrivatePage.vue";
import PrivateRoutes from "../pages/private/routes";
import Store from "../store/store";
const routes = [
  {
    path: "/login",
    component: LoginPage,
    meta: {
      requiresAuth: false,
    },
  },
  {
    path: "/register",
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
router.beforeEach((to, from, next) => {
  const authRequired = to.matched.some((m) => m.meta.requiresAuth);
  const user = Store.state.user.user;
  if (authRequired) {
    if (!user) {
      next({ name: "Login" });
    } else {
      next();
    }
  }else{
    if(user){
      next({name: "Private"})
    }else{
      next()
    }
  }
  next();
  console.log("user", Store.state.user.user);
  return true;
});
export default router;
