import "./bootstrap";
import { createApp } from "vue";
import { createWebHistory, createRouter } from "vue-router";
import { createPinia } from "pinia";
import piniaPluginPersistedstate from "pinia-plugin-persistedstate";

import App from "./App.vue";

import ElementPlus from "element-plus";
import "element-plus/dist/index.css";

import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";

import ViewUIPlus from "view-ui-plus";
import "view-ui-plus/dist/styles/viewuiplus.css";

import { routes } from "./router/index.js";

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        return { top: 0 };
    },
});

// router.beforeEach((to, from, next) => {
//     const token = localStorage.getItem("token");

//     if (to.matched.some((record) => record.meta.requiresAuth)) {
//         if (!token) {
//             next({ name: "home" });
//         } else {
//             next({ name: "home" });
//         }
//     } else if (to.matched.some((record) => record.meta.requiresVisitor)) {
//         if (token) {
//             next({ name: "home" });
//         } else {
//             next({ name: "home" });
//         }
//     } else {
//         next();
//     }
// });

const pinia = createPinia();

const app = createApp(App);
pinia.use(piniaPluginPersistedstate);
app.use(pinia);
app.use(router);
app.use(ElementPlus);
app.component("QuillEditor", QuillEditor);
app.use(ViewUIPlus);

// createApp(App).mount("#app");
app.mount("#app");
