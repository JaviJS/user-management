import { defineConfig } from "vite";
import Vue from "@vitejs/plugin-vue";
import Vuetify, { transformAssetUrls } from "vite-plugin-vuetify";
import ViteFonts from 'unplugin-fonts/vite';

export default defineConfig({
  plugins: [
    Vue({
      template: { transformAssetUrls },
    }),
    Vuetify()
    // ViteFonts({
    //   google: {
    //     families: [
    //       {
    //         name: "Roboto",
    //         styles: "wght@100;300;400;500;700;900",
    //       },
    //     ],
    //   },
    // }),
  ],
});
