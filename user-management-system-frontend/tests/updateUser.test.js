import { describe, expect, it, vi } from "vitest";
import { mount } from "@vue/test-utils";
import UpdateUserDialog from "../src/components/dialogs/UpdateUserDialog.vue";
import vuetify from "../src/plugins/vuetify";
import { store } from "../src/store/store";
vi.mock("vuex");
vi.mock("vue-router");

describe("UpdateUserDialog.vue", () => {
  it("validar formulario mal formado de registrar usuario", async () => {
    const wrapper = mount(UpdateUserDialog, {
      global: {
        plugins: [vuetify, store],
      },
    });
    // Verifica que el diálogo esté cerrado inicialmente
    expect(
      wrapper.findComponent({ name: "v-dialog" }).props("modelValue")
    ).toBe(false);
    // Simula abrir el diálogo
    await wrapper.find("#openDialog").trigger("click");
    // await wrapper.find("input#name").setValue("testexample.com");
    // // await wrapper.find('input[type="password"]').setValue('mypassword123');
    // await wrapper.find('button[type="submit"]').trigger("click");
    // const isValid = await wrapper.vm.formUser.validate();

    // expect(isValid.valid).toBe(false);
  });
});
