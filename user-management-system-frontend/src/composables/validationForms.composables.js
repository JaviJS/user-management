import { getCurrentInstance } from "vue";
import moment from "moment";

export function validationForms() {
  const { appContext } = getCurrentInstance();

  const requiredRule = (text) => [
    (v) => !!v || `El campo ${text} es obligatorio.`,
  ];
  const requiredDateRule = (text) => {
    return [
      (v) => !!v || `El campo ${text} es obligatorio.`,
      (v) => {
        var date = moment(v).format("DD-MM-YYYY");
        return (
          (v &&
            /^(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[0-2])-(19|20)\d\d$/.test(
              date
            )) ||
          "Formato de fecha dd-mm-YYYY"
        );
      },
      (v) => {
        var date = moment(v, "DD-MM-YYYY");
        return date.isValid() || `El campo ${text} debe ser una fecha.`;
      },
    ];
  };

  const passwordRule = (text) => [
    (v) => !!v || `El campo ${text} es obligatorio.`,
    (v) => (v && /\d/.test(v)) || "Al menos un digito",
    (v) => (v && /[A-Z]{1}/.test(v)) || "Al menos una letra en mayuscula",
    (v) => (v && /[a-z]{1}/.test(v)) || "Al menos una letra en minuscula",
    (v) => (v && /[^A-Za-z0-9]/.test(v)) || "Al menos un caracter especial",
    (v) => (v && v.length >= 8) || `Mínimo 8 caracteres`,
    (v) => (v && v.length <= 16) || `Máximo 16 caracteres`,
  ];

  const newPasswordRule = (text, currentPass) => [
    (v) => !!v || `El campo ${text} es obligatorio.`,
    (v) =>
      (v && v !== currentPass) ||
      "Contraseña actual y nueva no deben ser iguales",
    (v) => (v && /\d/.test(v)) || "Al menos un digito",
    (v) => (v && /[A-Z]{1}/.test(v)) || "Al menos una letra en mayuscula",
    (v) => (v && /[a-z]{1}/.test(v)) || "Al menos una letra en minuscula",
    (v) => (v && /[^A-Za-z0-9]/.test(v)) || "Al menos un caracter especial",
    (v) => (v && v.length >= 8) || `Mínimo 8 caracteres`,
    (v) => (v && v.length <= 16) || `Máximo 16 caracteres`,
  ];

  const passwordMatchRule = (text, pass) => [
    (v) => !!v || `El campo ${text} es obligatorio.`,
    (v) => (v && v === pass) || "Contraseñas no coinciden",
  ];

  const formGroupRule = (text) => [
    (v) => v.length > 0 || `El campo ${text} es obligatorio.`,
  ];

  const formGroupRule2 = (text) => [(v) => !!v || `Seleccione un ${text}.`];

  const formGroupRule3 = (text) => [
    (v) => v.length > 0 || `Seleccione al menos un ${text}`,
  ];

  const descriptionRule = (text) => [
    (v) => !!v || `El campo ${text} es obligatorio.`,
    (v) => (v && v.length <= 1000) || "Son 1000 caracteres como máximo.",
  ];

  const descriptionLongRule = (text) => [
    (v) => !!v || `El campo ${text} es obligatorio.`,
    (v) => (v && v.length <= 2000) || "Son 2000 caracteres como máximo.",
  ];

  const imgRule = (text) => [
    (v) => v.length !== 0 || `El campo ${text} es obligatorio.`,
  ];

  const fileRule = (text) => [
    (v) => v.length !== 0 || `El campo ${text} es obligatorio.`,
    (v) =>
      (v && v.length > 0 && !(v[0].size > 10 * 1024 * 1024)) ||
      "El documento debe pesar menos que 10 MB!",
  ];
  const fileNoRequiredRule = () => [
    (v) =>
      (v && !(v.size > 10 * 1024 * 1024)) ||
      "El documento debe pesar menos que 10 MB!",
  ];
  const integerRule = (text) => [
    (v) => !!v || `El campo ${text} es obligatorio.`,
    (v) =>
      (v && Number.isInteger(Number(v))) || `El número tiene que ser entero.`,
    (v) => (v && v >= 1) || `El número tiene que ser mayor a 0.`,
  ];

  const requiredTextRule = (text) => [
    (v) => !!v || `El campo ${text} es obligatorio.`,
    (v) =>
      (v && /[a-zA-ZáéíóúñÁÉÍÓÚÑ][a-zA-ZáéíóúñÁÉÍÓÚÑ ]/.test(v)) ||
      "Solo se admiten letras.",
  ];
  const phoneRule = (text) => [
    (v) => !!v || `El campo ${text} es obligatorio.`,
    (v) => (v && Number.isInteger(Number(v))) || "Ingrese un número válido.",
    (v) =>
      (v && v.length === 9) || `El campo ${text} tiene que ser de 9 dígitos.`,
    (v) => (v && /^9[0-9]{8}/.test(v)) || "Formato a utilizar, ej. 9XXXXXXXX.",
  ];

  const personRule = (text) => {
    return [
      (v) => !!v || `El campo ${text} es obligatorio.`,
      (v) => (v && v.length >= 3) || `Mínimo 3 caracteres`,
      (v) => (v && v.length <= 30) || `Máximo 30 caracteres`,
      (v) =>
        (v && /^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/.test(v)) || "Solo se admiten letras.",
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
    requiredTextRule,
    phoneRule,
    personRule,
    emailRule,
    descriptionLongRule,
    descriptionRule,
    formGroupRule,
    formGroupRule2,
    formGroupRule3,
    requiredDateRule,
    fileNoRequiredRule,
  };
}