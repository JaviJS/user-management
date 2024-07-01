import { VDateInput } from 'vuetify/labs/VDateInput'
import "@mdi/font/css/materialdesignicons.css";
import "vuetify/styles";

import { createVuetify } from "vuetify";
export default createVuetify({
  components: {
    VDateInput
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
