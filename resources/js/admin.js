import "./bootstrap";
import { createApp } from "vue";
import { createWebHistory, createRouter } from "vue-router";
import { createPinia } from "pinia";
import piniaPluginPersistedstate from "pinia-plugin-persistedstate";

import Admin from "@/Pages/AdminMaster.vue";

import { routes } from "@/router/admin.js";

import ElementPlus from "element-plus";
import "element-plus/dist/index.css";

import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";

import ViewUIPlus from "view-ui-plus";
import "view-ui-plus/dist/styles/viewuiplus.css";

const router = createRouter({
    history: createWebHistory(),
    routes, // short for `routes: routes`
    scrollBehavior(to, from, savedPosition) {
        // always scroll to top
        return { top: 0 };
    },
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem("token");

    if (to.matched.some((record) => record.meta.requiresAuth)) {
        if (!token) {
            next({ name: "admin-login" });
        } else {
            // Assuming you have a global user object with user_type
            const user = JSON.parse(localStorage.getItem("user"));
            if (
                user?.authuser?.user_type === "admin" ||
                user?.authuser?.user_type === "vendor"
            ) {
                next(); // Redirect to admin dashboard
            } else {
                next({ name: "admin-login" }); // Redirect to /api route
            }
        }
    } else if (to.matched.some((record) => record.meta.requiresVisitor)) {
        if (token) {
            next({ name: "admin-dashboard" });
        } else {
            next();
        }
    } else {
        next();
    }
});

// export default router;

const pinia = createPinia();

const app = createApp(Admin);
pinia.use(piniaPluginPersistedstate);
app.use(pinia);
app.use(router);
app.use(ElementPlus);
app.component("QuillEditor", QuillEditor);
app.use(ViewUIPlus);

// createApp(App).mount("#app");
app.mount("#admin");
