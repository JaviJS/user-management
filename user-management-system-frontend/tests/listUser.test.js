import { describe, expect, it, vi } from "vitest";
import { mount } from "@vue/test-utils";
import vuetify from "../src/plugins/vuetify";
import ListUsersPage from "../src/pages/private/pages/users/ListUsersPage.vue";

vi.mock("vuex");
vi.mock("vue-router");

global.ResizeObserver = class {
    observe() {}
    unobserve() {}
    disconnect() {}
};

describe("ListUsersPage.vue", () => {
    it("test", async () => {

        // Creamos un usuario y llenamos un array 100 veces con este usuario
        const user = {
            id: 1,
            name: "Juan Perez",
            email: "",
            phone: "999999999",
            birthdayDate: "1999-01-01",
            role: "admin",
            status: "Activo",
            createdAt: "2021-01-01 12:00:00",
            updatedAt: "2021-01-01 12:00:00",
            photoUser: "https://example.com/photo.jpg",
        };

        const users = [];

        // agrega a users 100 elementos
        for (let i = 0; i <= 100; i++) {
            users.push({ ...user, id: i });
        }

        const wrapper = mount(ListUsersPage, {
            global: {
                plugins: [vuetify],
            },
            setup() {
                return {
                    users,
                };
            },
        });

        await wrapper.vm.$nextTick();

        // Buscamos la tabla perteneciente al componente ListUsersPage y comparamos el tamaño del array y de la cantidad de items en la tabla
        const table = wrapper.findComponent({ name: "v-data-table" });

        expect(users.length).toEqual(table.vm.items.length);
    });
});
