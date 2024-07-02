import { describe, expect, it } from "vitest";
import { mount } from "@vue/test-utils"
import LoginPage from "../src/pages/LoginPage.vue";


describe("cualquiercosa", () => {
  it("nombre de la prueba", () => {
    const vari = 15;
    console.log("probandoooo");
    expect(vari).toBe(15);
  });
  it("nombre de la prueba2", () => {
    const wrapper = mount(LoginPage);
    console.log("probandoooo", wrapper.vm.isValidForm);
    // expect(vari).toBe(15);
  });
});


