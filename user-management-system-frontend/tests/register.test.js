import { describe, expect, it, vi } from "vitest";
import { mount } from "@vue/test-utils";
import RegisterPage from "../src/pages/RegisterPage.vue";
import vuetify from "../src/plugins/vuetify";

vi.mock("vuex");
vi.mock("vue-router");

describe("RegisterPage.vue", () => {
  it("validar formulario mal formado de registrar usuario", async () => {
    const wrapper = mount(RegisterPage, {
      global: {
        plugins: [vuetify],
      },
    });

    await wrapper.find("input#name").setValue("testexample.com");
    // await wrapper.find('input[type="password"]').setValue('mypassword123');
    await wrapper.find('button[type="submit"]').trigger("click");
    const isValid = await wrapper.vm.formUser.validate();

    expect(isValid.valid).toBe(false);
  });

  it("validar formulario bien formado", async () => {
    const wrapper = mount(RegisterPage, {
      global: {
        plugins: [vuetify],
      },
    });
    const file = new File([""], "test-image.jpg", { type: "image/jpeg" });
    const blob = new Blob([""], { type: "image/jpeg" });
    let img = new Blob([''], { type: 'image/jpeg' })
    img.name = 'test-image.jpg'

    console.log({ blob });
    await wrapper.find("input#name").setValue("prueba");
    await wrapper.find("input#lastName").setValue("prueba");
    await wrapper.find("input#email").setValue("prueba01@gmail.com");
    await wrapper.find("input#phone").setValue("999999999");
    await wrapper.find("input#password").setValue("Goala14*");
    await wrapper.find("input#passwordConfirmation").setValue("Goala14");
    await wrapper.find("input#birthdayDate").setValue("24-02-1997");
    await wrapper.find("input#fileInput").setValue(img);
    await wrapper.find("input#status").setValue("Activo");
    await wrapper.find("input#role").setValue("admin");

    await wrapper.vm.$nextTick();

    // Intentar enviar el formulario
    await wrapper.find('button[type="submit"]').trigger("click");

    const isValid = await wrapper.vm.form.validate();

    expect(isValid.valid).toBe(true);
  });
});
