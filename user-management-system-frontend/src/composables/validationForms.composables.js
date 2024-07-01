import { ref } from "vue";

export function validationForms() {
    const getCodeArea = () => [
        "2", "32", "33", "34", "35", "39", "41", "42", "43", "44", "45",
        "51", "52", "53", "55", "57", "58", "61", "63", "64", "65", "67",
        "68", "71", "72", "73", "76"
      ];
    
      const requiredRule = (text) => [(v) => !!v || `El campo ${text} es obligatorio.`];

      const passwordRule = (text) => [
        (v) => !!v || `El campo ${text} es obligatorio.`,
        (v) => (v && /\d/.test(v)) || "Al menos un digito",
        (v) => (v && /[A-Z]{1}/.test(v)) || "Al menos una letra en mayuscula",
        (v) => (v && /[^A-Za-z0-9]/.test(v)) || "Al menos un caracter especial",
        (v) => (v && v.length >= 6) || `Mínimo 6 caracteres`,
      ];
    
      const newPasswordRule = (text, currentPass) => [
        (v) => !!v || `El campo ${text} es obligatorio.`,
        (v) => (v && v !== currentPass) || "Contraseña actual y nueva no deben ser iguales",
        (v) => (v && /\d/.test(v)) || "Al menos un digito",
        (v) => (v && /[A-Z]{1}/.test(v)) || "Al menos una letra en mayuscula",
        (v) => (v && /[^A-Za-z0-9]/.test(v)) || "Al menos un caracter especial",
        (v) => (v && v.length >= 6) || `Mínimo 6 caracteres`,
      ];
    
      const passwordMatchRule = (text, pass) => [
        (v) => !!v || `El campo ${text} es obligatorio.`,
        (v) => (v && v === pass) || "Contraseñas no coinciden",
      ];
    
      const formGroupRule = (text) => [(v) => v.length > 0 || `El campo ${text} es obligatorio.`];
    
      const formGroupRule2 = (text) => [(v) => !!v || `Seleccione un ${text}.`];
    
      const formGroupRule3 = (text) => [(v) => v.length > 0 || `Seleccione al menos un ${text}`];
    
      const descriptionRule = (text) => [
        (v) => !!v || `El campo ${text} es obligatorio.`,
        (v) => (v && v.length <= 1000) || "Son 1000 caracteres como máximo.",
      ];
    
      const descriptionLongRule = (text) => [
        (v) => !!v || `El campo ${text} es obligatorio.`,
        (v) => (v && v.length <= 2000) || "Son 2000 caracteres como máximo.",
      ];
    
      const imgRule = (text) => [(v) => v.length !== 0 || `El campo ${text} es obligatorio.`];
    

    
      const fileRule = (text) => [
        (v) => !!v || `El campo ${text} es obligatorio.`,
        (v) => (v && !(v.size > 10 * 1024 * 1024)) || 'El documento debe pesar menos que 10 MB!',
      ];
    
      const integerRule = (text) => [
        (v) => !!v || `El campo ${text} es obligatorio.`,
        (v) => (v && Number.isInteger(Number(v))) || `El número tiene que ser entero.`,
        (v) => (v && v >= 1) || `El número tiene que ser mayor a 0.`,
      ];
    
      const floatNumberRule = (text) => [
        (v) => !!v || `El campo ${text} es obligatorio.`,
        (v) => (v && /^[+-]?((\.\d+)|(\d+(\.\d+)?))$/.test(v)) || `El número tiene que ser numerico.`,
      ];
    
      const requiredTextRule = (text) => [
        (v) => !!v || `El campo ${text} es obligatorio.`,
        (v) => (v && /[a-zA-ZáéíóúñÁÉÍÓÚÑ][a-zA-ZáéíóúñÁÉÍÓÚÑ ]/.test(v)) || "Solo se admiten letras.",
      ];
      const phoneRule = (text) => [
        (v) => !!v || `El campo ${text} es obligatorio.`,
        (v) => (v && Number.isInteger(Number(v))) || "Ingrese un número válido.",
        (v) => (v && v.length === 9) || "El número tiene que ser de 9 dígitos.",
        (v) => (v && /^9[0-9]{8}/.test(v)) || "Formato a utilizar, ej. 9XXXXXXXX.",
      ];
    
      const generalPhoneRule = (text) => {
        const landlineRegex = new RegExp(`^(${getCodeArea().join("|")})\\d{7}$|^44\\d{7}$`);
        const mobilePhoneRegex = /^9[0-9]{8}/;
    
        return [
          (v) => !!v || `El campo ${text} es obligatorio.`,
          (v) => (v && Number.isInteger(Number(v))) || "Ingrese un número válido.",
          (v) => (v && v.length === 9) || "El número tiene que ser de 9 dígitos.",
          (v) => (v && (landlineRegex.test(v) || mobilePhoneRegex.test(v))) || "Formato a utilizar, ej. 9XXXXXXXX o [codigo de region]XXXXXXX.",
        ];
      };

      const personRule = (text) => {
        return [
          (v) => !!v || `El campo ${text} es obligatorio.`,
          (v) =>
            (v && /[a-zA-ZáéíóúñÁÉÍÓÚÑ][a-zA-ZáéíóúñÁÉÍÓÚÑ ]{2,30}/.test(v)) ||
            "Solo se admiten letras y espacios con un minimo de 3 caracteres y un maximo de 30.",
        ];
      };

      const emailRule = (text) => {
        return [
          (v) => !!v || `El campo ${text} es obligatorio.`,
          (v) =>
            (v &&
              /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(
                v
              )) ||
            "El formato debe ser ###@###.##, ejemplo hola@hotmail.cl.",
        ];
      };

      return {
        requiredRule,
        passwordRule,
        newPasswordRule,
        passwordMatchRule,
        imgRule,
        fileRule,
        integerRule,
        floatNumberRule,
        requiredTextRule,
        phoneRule,
        generalPhoneRule,
        personRule,
        emailRule
      }
}