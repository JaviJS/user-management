import { describe, expect, it, vi } from "vitest";
import { mount } from "@vue/test-utils";

import CreateUserPage from "../src/pages/private/pages/users/CreateUserPage.vue";
import vuetify from "../src/plugins/vuetify";

vi.mock("vuex");
vi.mock("vue-router");

describe("CreateUserPage.vue", () => {
  it("validar formulario bien formado", async () => {
    const wrapper = mount(CreateUserPage, {
      global: {
        plugins: [vuetify],
      },
    });

    // Creamos una imagen que mas adelante sera dada a un input de un formulario
    const file = new File(["dummy content"], "example.png", {
      type: "image/png",
    });

    // Obtenemos los inputs del formulario de CreateUserPage y les damos valores aceptados por las reglas de cada input
    await wrapper.findComponent({ ref: "name" }).setValue("prueba");
    await wrapper.findComponent({ ref: "lastName" }).setValue("prueba");
    await wrapper.findComponent({ ref: "password" }).setValue("Goala14*");
    await wrapper
      .findComponent({ ref: "passwordConfirmation" })
      .setValue("Goala14*");

    await wrapper
      .findComponent({ ref: "email" })
      .setValue("prueba01@gmail.com");

    await wrapper.findComponent({ ref: "phone" }).setValue("999999999");
    await wrapper.findComponent({ ref: "birthdayDate" }).setValue("1999-01-01");

    const selectStatus = wrapper.findComponent({ ref: "status" });
    await selectStatus.setValue("Activo");

    const selectRole = wrapper.findComponent({ ref: "role" });
    await selectRole.setValue("admin");

    const inputFile = wrapper.find("input#fileInput");

    const mockDataTransfer = {
      files: [file],
      items: [
        {
          kind: "file",
          type: file.type,
          getAsFile: () => file,
        },
      ],
    };

    Object.defineProperty(inputFile.element, "files", {
      value: mockDataTransfer.files,
      writable: false,
    });

    await inputFile.trigger("change");

    // Validamos el formulario y esperamos que nos entrege como respuesta un true
    const isValid = await wrapper.vm.formUser.validate();

    expect(isValid.valid).toBe(true);
  });

  it("validar formulario sin imagen", async () => {
    const wrapper = mount(CreateUserPage, {
      global: {
        plugins: [vuetify],
      },
    });

    const file = new File(["dummy content"], "example.png", {
      type: "image/png",
    });
    /**  Obtenemos los inputs del formulario de CreateUserPage y les damos valores aceptados por las reglas de cada input, excepto al
     * input de photoUser
     */
    await wrapper.findComponent({ ref: "name" }).setValue("prueba");

    await wrapper.findComponent({ ref: "lastName" }).setValue("prueba");
    await wrapper.findComponent({ ref: "password" }).setValue("Goala14*");
    await wrapper
      .findComponent({ ref: "passwordConfirmation" })
      .setValue("Goala14*");

    await wrapper
      .findComponent({ ref: "email" })
      .setValue("prueba01@gmail.com");
    await wrapper.findComponent({ ref: "phone" }).setValue("999999999");
    await wrapper.findComponent({ ref: "birthdayDate" }).setValue("1999-01-01");

    const selectStatus = wrapper.findComponent({ ref: "status" });
    await selectStatus.setValue("Activo");

    const selectRole = wrapper.findComponent({ ref: "role" });
    await selectRole.setValue("admin");

    // Validamos el formulario y esperamos como respuesta un false
    const isValid = await wrapper.vm.formUser.validate();

    expect(isValid.valid).toBe(false);
  });
});
