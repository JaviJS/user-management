import { describe, expect, it, vi } from "vitest";
import { mount } from "@vue/test-utils";
import RegisterPage from "../src/pages/RegisterPage.vue";
import vuetify from "../src/plugins/vuetify";
import moment from "moment";

vi.mock("vuex");
vi.mock("vue-router");

describe("RegisterPage.vue", () => {
  it("validar formulario mal formado de registrar usuario", async () => {
    const wrapper = mount(RegisterPage, {
      global: {
        plugins: [vuetify],
      },
    });
    // Buscamos input name de formulario y validamos de inmediato el formulario, por lo cual esperamos una respuesta false
    await wrapper.find("input#name").setValue("testexample.com");
    await wrapper.find('button[type="submit"]').trigger("click");
    const isValid = await wrapper.vm.formUser.validate();

    expect(isValid.valid).toBe(false);
  });

  it("probar formulario valido", async () => {
    const wrapper = mount(RegisterPage, {
      global: {
        plugins: [vuetify],
      },
    });

    // Creamos una imagen que mas adelante sera dada a un input de un formulario
    const file = new File(["dummy content"], "example.png", {
      type: "image/png",
    });

    // Obtenemos los inputs del formulario de CreateUserPage y les damos valores aceptados por las reglas de cada input
    await wrapper.find("input#name").setValue("prueba");
    await wrapper.find("input#lastName").setValue("prueba");
    await wrapper.find("input#email").setValue("prueba01@gmail.com");
    await wrapper.find("input#phone").setValue("999999999");
    await wrapper.find("input#password").setValue("Goala14*");
    await wrapper.find("input#passwordConfirmation").setValue("Goala14*");
    await wrapper.find("input#birthdayDate").setValue("1999-01-01");

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

  it("probar formulario con email invalido", async () => {
    const wrapper = mount(RegisterPage, {
      global: {
        plugins: [vuetify],
      },
    });

    const file = new File(["dummy content"], "example.png", {
      type: "image/png",
    });

    // Buscamos los componentes y les damos valores correctos excepto el email
    await wrapper.find("input#name").setValue("prueba");
    await wrapper.find("input#lastName").setValue("prueba");
    await wrapper.find("input#email").setValue("prueba01gmail.com");
    await wrapper.find("input#phone").setValue("999999999");
    await wrapper.find("input#password").setValue("Goala14*");
    await wrapper.find("input#passwordConfirmation").setValue("Goala14*");
    await wrapper.find("input#birthdayDate").setValue("1999-01-01");

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

    // Validamos el formulario y esperamos como respuesta un false
    const isValid = await wrapper.vm.formUser.validate();

    expect(isValid.valid).toBe(false);
  });

  it("probar formulario con diferentes passwords", async () => {
    const wrapper = mount(RegisterPage, {
      global: {
        plugins: [vuetify],
      },
    });

    const file = new File(["dummy content"], "example.png", {
      type: "image/png",
    });
    // Buscamos los inputs y les ingresamos valores correctos excepto las contraseñas
    await wrapper.find("input#name").setValue("prueba");
    await wrapper.find("input#lastName").setValue("prueba");
    await wrapper.find("input#email").setValue("prueba01@gmail.com");
    await wrapper.find("input#phone").setValue("999999999");
    await wrapper.find("input#password").setValue("Goala");
    await wrapper.find("input#passwordConfirmation").setValue("Goala14*");
    await wrapper.find("input#birthdayDate").setValue("1999-01-01");

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

    // Validamos formulario y esperamos como respuesta un false
    const isValid = await wrapper.vm.formUser.validate();

    expect(isValid.valid).toBe(false);
  });

  it("probar formulario con fecha en distinto formato", async () => {
    const wrapper = mount(RegisterPage, {
      global: {
        plugins: [vuetify],
        mocks: {
          $moment: moment,
        },
      },
      mocks: {
        $moment: moment,
      },
    });
    // Creamos una imagen que sera dada a un input mas adelante
    const file = new File(["dummy content"], "example.png", {
      type: "image/png",
    });

    // Buscamos los inputs y les ingresamos valores correctos excepto la fecha de nacimiento
    await wrapper.find("input#name").setValue("prueba");
    await wrapper.find("input#lastName").setValue("prueba");
    await wrapper.find("input#email").setValue("prueba01@gmail.com");
    await wrapper.find("input#phone").setValue("999999999");
    await wrapper.find("input#password").setValue("Goala14*");
    await wrapper.find("input#passwordConfirmation").setValue("Goala14*");
    await wrapper.find("input#birthdayDate").setValue("01-01-1999");

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

    // Validamos formulario y esperamos como respuesta un false
    const isValid = await wrapper.vm.formUser.validate();

    expect(isValid.valid).toBe(false);
  });
});
