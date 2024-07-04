export default [
  {
    path: "usuarios",
    name: "Private.Users",
    component: () => import("./pages/users/ListUsersPage.vue"),
  },
  {
    path: "crear-usuario",
    name: "Private.CreateUser",
    component: () => import("./pages/users/CreateUserPage.vue"),
  }
];
