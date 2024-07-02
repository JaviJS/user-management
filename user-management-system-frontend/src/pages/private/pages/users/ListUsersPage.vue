<template>
  <div id="ListUsersPage" class="mt-10 custom-size-page">
    <v-row justify="center" class="mt-8">
      <v-col cols="12" md="12" sm="12" class="text-left">
        <v-card>
          <v-row>
            <v-col cols="12">
              <v-card-title class="custom-text pl-10 pr-10">
                <v-btn density="default" @click="goToCreateUser()"
                  >+ Crear usuario</v-btn
                >
              </v-card-title>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12">
              <v-card-title class="custom-text pl-10 pr-10">
                Listar usuarios
                <v-spacer></v-spacer>
                <v-text-field
                  v-model="searchUser"
                  append-icon="mdi-magnify"
                  label="Buscar usuario"
                  single-line
                  hide-details
                  solo-inverted
                ></v-text-field>
              </v-card-title>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>
    <v-row justify="center" class="mt-8">
      <v-col cols="12" md="12" sm="12" class="text-left">
        <v-card>
          <v-row>
            <v-col cols="12">
              <v-data-table
                :headers="headersTable"
                :items="users"
                :search="searchUser"
                :loading="loadingTable"
                loading-text="Cargando... Porfavor esperar!"
                :custom-filter="customFilter"
                :footer-props="{
                  'items-per-page-options': [10, 50, 100],
                }"
                :items-per-page="50"
              >
                <template v-slot:[`item.photoUser`]="{ item }">
                  <v-avatar color="surface-variant"
                    ><v-img
                      v-if="item.photoUser"
                      alt="Imagen usuario"
                      :src="item.photoUser"
                    ></v-img
                  ></v-avatar>
                </template>
                <template v-slot:item.actions="{ item }">
                  <UpdateUserDialog
                    @change-user="changeUsers()"
                    :userId="item.id"
                  ></UpdateUserDialog>
                  <DeleteUserDialog
                    @change-user="changeUsers()"
                    :userId="item.id"
                  ></DeleteUserDialog>
                  <ChangePasswordDialog
                    @change-user="changeUsers()"
                    :userId="item.id"
                  ></ChangePasswordDialog>
                  <ViewUserDialog
                    :userId="item.id"
                  ></ViewUserDialog>
                </template>
                <template v-slot:no-data>
                  No hay usuarios
                </template>
              </v-data-table>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>
<script setup>
import ChangePasswordDialog from "../../../../components/dialogs/ChangePasswordDialog.vue";
import UpdateUserDialog from "../../../../components/dialogs/UpdateUserDialog.vue";
import DeleteUserDialog from "../../../../components/dialogs/DeleteUserDialog.vue";
import ViewUserDialog from "../../../../components/dialogs/ViewUserDialog.vue";
import userService from "./../../../../services/user.service";
import { ref, onMounted, getCurrentInstance } from "vue";
import { useToast } from "vue-toastification";
import { useRouter } from "vue-router";
import { useStore } from "vuex";

const { appContext } = getCurrentInstance();
const moment = appContext.config.globalProperties.$moment;

const router = useRouter();
const toast = useToast();
const store = useStore();

const users = ref([]);
const searchUser = ref("");
const loadingTable = ref(false);

const headersTable = [
  { title: "ID", key: "id", align: "center" },
  {
    title: "Identificación",
    align: "center",
    sortable: false,
    key: "photoUser",
  },
  {
    title: "Nombre",
    align: "center",
    sortable: false,
    key: "name",
  },
  { title: "Correo electrónico", key: "email", align: "center" },
  { title: "Teléfono", key: "phone", align: "center" },
  { title: "Fecha de nacimiento", key: "birthdayDate", align: "center" },
  { title: "Rol", key: "role", align: "center" },
  { title: "Estado", key: "status", align: "center" },
  { title: "Fecha de creación", key: "createdAt", align: "center" },
  { title: "Fecha de modificación", key: "updatedAt", align: "center" },
  { title: "Acciones", key: "actions", sortable: false },
];

onMounted(async () => {
  await loadUsers();
});

const loadUsers = async () => {
  const token = store.getters["user/GET_TOKEN"];
  loadingTable.value = true;
  await userService
    .getUsers(token)
    .then((data) => {
      users.value = data.map((x) => {
        return {
          id: x.id,
          name: x.name + " " + x.last_name,
          email: x.email,
          phone: x.phone,
          birthdayDate: moment(new Date(x.birthday_date)).format("DD-MM-YYYY"),
          role: x.role,
          status: x.status,
          createdAt: moment(new Date(x.created_at)).format(
            "DD-MM-YYYY HH:mm:ss"
          ),
          updatedAt: moment(new Date(x.updated_at)).format(
            "DD-MM-YYYY HH:mm:ss"
          ),
          photoUser: x.photo_user?.url,
        };
      });
    })
    .catch((error) => {
      toast.error("Error al listar usuarios.");
      if (error?.response?.status === 401) {
        store.dispatch("user/CLEAR_USER");
        router.push("/login");
        toast.error("No autorizado");
      }
    });
  loadingTable.value = false;
};
const changeUsers = async () => {
  await loadUsers();
};

const goToCreateUser = () => {
  router.push("/private/crear-usuario");
};
</script>
<style scoped lang="scss"></style>
