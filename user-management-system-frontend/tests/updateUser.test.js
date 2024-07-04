import { describe, expect, it, vi } from "vitest";
import { mount } from "@vue/test-utils";

import UpdateUserDialog from "../src/components/dialogs/UpdateUserDialog.vue";
import vuetify from "../src/plugins/vuetify";

vi.mock("vuex");
vi.mock("vue-router");

describe("UpdateUserDialog.vue", () => {
  it("validar formulario bien formado", async () => {
    const wrapper = mount(UpdateUserDialog, {
      global: {
        plugins: [vuetify],
      },
    });

    wrapper.vm.dialog = true;
    await wrapper.vm.$nextTick();

    // Creamos una imagen
    const file = new File(["dummy content"], "example.png", {
      type: "image/png",
    });

    // Damos valores a los inputs del formulario
    await wrapper.findComponent({ ref: "name" }).setValue("prueba");
    await wrapper.findComponent({ ref: "lastName" }).setValue("prueba");
    await wrapper
      .findComponent({ ref: "email" })
      .setValue("prueba01@gmail.com");
    await wrapper.findComponent({ ref: "phone" }).setValue("999999999");
    await wrapper.findComponent({ ref: "birthdayDate" }).setValue("1999-01-01");

    const selectStatus = wrapper.findComponent({ ref: "status" });
    await selectStatus.setValue("Activo");

    const selectRole = wrapper.findComponent({ ref: "role" });
    await selectRole.setValue("admin");

    const inputFile = wrapper.findComponent({ ref: "fileUpload" });

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

    // Validamos el formulario y esperamos como respuesta un true
    const isValid = await wrapper.vm.formUser.validate();

    expect(isValid.valid).toBe(true);
  });

  it("validar formulario sin imagen", async () => {
    const wrapper = mount(UpdateUserDialog, {
      global: {
        plugins: [vuetify],
      },
    });

    wrapper.vm.dialog = true;
    await wrapper.vm.$nextTick();
    // Damos valores a los inputs del formulario
    await wrapper.findComponent({ ref: "name" }).setValue("prueba");
    await wrapper.findComponent({ ref: "lastName" }).setValue("prueba");
    await wrapper
      .findComponent({ ref: "email" })
      .setValue("prueba01@gmail.com");
    await wrapper.findComponent({ ref: "phone" }).setValue("999999999");
    await wrapper.findComponent({ ref: "birthdayDate" }).setValue("1999-01-01");

    const selectStatus = wrapper.findComponent({ ref: "status" });
    await selectStatus.setValue("Activo");

    const selectRole = wrapper.findComponent({ ref: "role" });
    await selectRole.setValue("admin");
    // Validamos el formulario y esperamos como respuesta un true
    const isValid = await wrapper.vm.formUser.validate();

    expect(isValid.valid).toBe(true);
  });
});
