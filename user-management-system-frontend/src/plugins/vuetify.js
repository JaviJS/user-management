import { VDateInput } from "vuetify/labs/VDateInput";
import "@mdi/font/css/materialdesignicons.css";
import "vuetify/styles";
import { es } from "vuetify/locale";

import { createVuetify } from "vuetify";
export default createVuetify({
  locale: {
    locale: "es",
    messages: { es },
  },
  components: {
    VDateInput,
  },
  theme: {
    themes: {
      light: {
        primary: "#3f51b5",
        secondary: "#696969",
        accent: "#8c9eff",
        error: "#b71c1c",
      },
    },
  },
});
