import { describe, expect, it, vi } from "vitest";
import { mount } from "@vue/test-utils";
import LoginPage from "../src/pages/LoginPage.vue";
import vuetify from "../src/plugins/vuetify";

vi.mock("vuex");
vi.mock("vue-router");

describe("LoginPage.vue", () => {
  it("validar email mal formado", async () => {
    const wrapper = mount(LoginPage, {
      global: {
        plugins: [vuetify],
      },
    });
    // Buscamos los inputs para el formulario de login y le pasamos un correo mal formado
    await wrapper.find('input[type="text"]').setValue("testexample.com");
    await wrapper.find('input[type="password"]').setValue("mypassword123");

    // Validamos el formulario y esperamos como respuesta un false
    const isValid = await wrapper.vm.form.validate();

    expect(isValid.valid).toBe(false);
  });

  it("validar email bien formado", async () => {
    const wrapper = mount(LoginPage, {
      global: {
        plugins: [vuetify],
      },
    });
    // Buscamos los inputs para el formulario de login y le pasamos valores correctos
    await wrapper.find('input[type="text"]').setValue("test@example.com");
    await wrapper.find('input[type="password"]').setValue("mypassword123");

    // Validamos el formulario y esperamos como respuesta un true
    const isValid = await wrapper.vm.form.validate();

    expect(isValid.valid).toBe(true);
  });
});
