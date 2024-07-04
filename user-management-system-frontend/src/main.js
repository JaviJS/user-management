import router from "./routes/routes";
import { createApp } from "vue";
import App from "./App.vue";
import "./style.css";
import vuetify from "./plugins/vuetify";
import store from "./store/store";
import moment from "moment";
import Toast from "vue-toastification";
// Import the CSS or use your own!
import "vue-toastification/dist/index.css";

const options = {
  timeout: 2038,
  closeOnClick: true,
  pauseOnFocusLoss: false,
  pauseOnHover: false,
  draggable: false,
  position: "bottom-center",
};

const app = createApp(App);
app.config.globalProperties.$moment = moment;
app.use(vuetify).use(router).use(store).use(Toast, options).mount("#app");
