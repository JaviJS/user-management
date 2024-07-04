import { describe, expect, it, vi } from "vitest";
import { mount } from "@vue/test-utils";
import vuetify from "../src/plugins/vuetify";
import ChangePasswordDialog from "../src/components/dialogs/ChangePasswordDialog.vue";

vi.mock("vuex");
vi.mock("vue-router");

describe("ChangePasswordDialog.vue", () => {
  it("formulario valido", async () => {
    const wrapper = mount(ChangePasswordDialog, {
      global: {
        plugins: [vuetify],
      },
    });

    // Abrimos el dialos
    wrapper.vm.dialog = true;
    await wrapper.vm.$nextTick();

    // Buscamos los inputs del formulario y les damos un valor que sea permitido por las reglas del formulario
    const actualPasswordField = wrapper.findComponent({
      ref: "actualPassword",
    });
    await actualPasswordField.setValue("mypassword123");

    const newPasswordField = wrapper.findComponent({ ref: "newPassword" });
    await newPasswordField.setValue("!Mypassword1234");

    const confirmPasswordField = wrapper.findComponent({
      ref: "newPasswordConfirmation",
    });
    await confirmPasswordField.setValue("!Mypassword1234");

    // Validamos el formulario y esperamos que retorne un true
    const isValid = await wrapper.vm.formChangePassword.validate();

    expect(isValid.valid).toBe(true);
  });

  it("new password y confirm password son diferentes", async () => {
    const wrapper = mount(ChangePasswordDialog, {
      global: {
        plugins: [vuetify],
      },
    });

    wrapper.vm.dialog = true;
    await wrapper.vm.$nextTick();

    // Buscamos los inputs del formulario y les damos un valor que no sea permitido por las reglas del formulario
    const actualPasswordField = wrapper.findComponent({
      ref: "actualPassword",
    });
    await actualPasswordField.setValue("mypassword123");

    const newPasswordField = wrapper.findComponent({ ref: "newPassword" });
    await newPasswordField.setValue("!Mypassword1234");

    const confirmPasswordField = wrapper.findComponent({
      ref: "newPasswordConfirmation",
    });
    await confirmPasswordField.setValue("!Mypassword12345");

    // Validamos el formulario y esperamos como respuesta un false
    const isValid = await wrapper.vm.formChangePassword.validate();

    expect(isValid.valid).toBe(false);
  });

  it("new password y actual password son iguales", async () => {
    const wrapper = mount(ChangePasswordDialog, {
      global: {
        plugins: [vuetify],
      },
    });

    wrapper.vm.dialog = true;
    await wrapper.vm.$nextTick();

    const actualPasswordField = wrapper.findComponent({
      ref: "actualPassword",
    });
    await actualPasswordField.setValue("mypassword123");

    const newPasswordField = wrapper.findComponent({ ref: "newPassword" });
    await newPasswordField.setValue("mypassword123");

    const confirmPasswordField = wrapper.findComponent({
      ref: "newPasswordConfirmation",
    });
    await confirmPasswordField.setValue("mypassword123");

    const isValid = await wrapper.vm.formChangePassword.validate();

    expect(isValid.valid).toBe(false);
  });

  it("new password no cumple con los requisitos", async () => {
    const wrapper = mount(ChangePasswordDialog, {
      global: {
        plugins: [vuetify],
      },
    });

    // Abrimos dialog
    wrapper.vm.dialog = true;
    await wrapper.vm.$nextTick();

    // Buscamos componente "actualPassword" y le damos un valor incorrecto
    const actualPasswordField = wrapper.findComponent({
      ref: "actualPassword",
    });
    await actualPasswordField.setValue("mypassword123");

    // Buscamos componente "newPassword" y le damos un valor incorrecto
    const newPasswordField = wrapper.findComponent({ ref: "newPassword" });
    await newPasswordField.setValue("mypassword1234");

    // Buscamos componente "newPasswordConfirmation" y le damos un valor incorrecto
    const confirmPasswordField = wrapper.findComponent({
      ref: "newPasswordConfirmation",
    });
    await confirmPasswordField.setValue("mypassword1234");

    // consultamos por la validación del formulario
    const isValid = await wrapper.vm.formChangePassword.validate();

    // Esperamos que el formulario sea falso
    expect(isValid.valid).toBe(false);
  });
});
