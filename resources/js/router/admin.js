import AdminMaster from "@/Pages/AdminMaster.vue";
import AdminDashboard from "@/Pages/AdminDashboard.vue";
import AdminLogin from "@/Pages/AdminLogin.vue";
import AdminRegister from "@/Pages/AdminRegister.vue";
import VendorLogin from "@/Pages/VendorLogin.vue";
import VendorRegister from "@/Pages/VendorRegister.vue";
import VendorSetup from "@/Pages/VendorSetup.vue";
import AdminProfile from "@/Pages/Profile/AdminProfile.vue";
import AdminUserList from "@/Pages/User/AdminUserList.vue";
import AdminCategoryList from "@/Pages/Category/AdminCategoryList.vue";
import AdminProductList from "@/Pages/Product/AdminProductList.vue";
import AdminCreateCategory from "@/Pages/Category/AdminCreateCategory.vue";
import AdminUpdateCategory from "@/Pages/Category/AdminUpdateCategory.vue";
import AdminCreateProduct from "@/Pages/Product/AdminCreateProduct.vue";
import AdminUpdateProduct from "@/Pages/Product/AdminUpdateProduct.vue";
import AdminChat from "@/Pages/Chat/AdminChat.vue";

export const routes = [
    {
        name: "admin-login",
        path: "/admin/admin-login",
        component: AdminLogin,
        meta: { title: "AdminLogin" },
        meta: { requiresAuth: false },
    },
    {
        name: "admin-register",
        path: "/admin/admin-register",
        component: AdminRegister,
        meta: { title: "AdminRegister" },
        meta: { requiresAuth: false },
    },
    {
        name: "vendor-login",
        path: "/admin/vendor-login",
        component: VendorLogin,
        meta: { title: "VendorLogin" },
        meta: { requiresAuth: false },
    },
    {
        name: "vendor-register",
        path: "/admin/vendor-register",
        component: VendorRegister,
        meta: { title: "VendorRegister" },
        meta: { requiresAuth: false },
    },
    {
        name: "vendor-setup",
        path: "/admin/vendor-setup",
        component: VendorSetup,
        meta: { title: "VendorSetup" },
        meta: { requiresAuth: false },
    },
    {
        name: "dashboard",
        path: "/admin",
        component: AdminDashboard,
        // meta: { title: "AdminDashboard" },
        meta: { requiresAuth: true },
    },
    {
        name: "admin-profile",
        path: "/admin/admin-profile",
        component: AdminProfile,
        meta: { requiresAuth: true },
    },

    {
        name: "admin-users",
        path: "/admin/users",
        component: AdminUserList,
        // meta: { title: "AdminDashboard" },
        meta: { requiresAuth: true },
    },
    {
        name: "admin-categories",
        path: "/admin/categories",
        component: AdminCategoryList,
        // meta: { title: "AdminDashboard" },
        meta: { requiresAuth: true },
    },
    {
        name: "admin-create-categories",
        path: "/admin/createcategories",
        component: AdminCreateCategory,
        // meta: { title: "AdminDashboard" },
        meta: { requiresAuth: true },
    },
    {
        name: "admin-update-categories",
        path: "/admin/updatecategories",
        component: AdminUpdateCategory,
        // meta: { title: "AdminDashboard" },
        meta: { requiresAuth: true },
    },
    {
        name: "admin-products",
        path: "/admin/products",
        component: AdminProductList,
        // meta: { title: "AdminDashboard" },
        meta: { requiresAuth: true },
    },
    {
        name: "admin-create-products",
        path: "/admin/createproducts",
        component: AdminCreateProduct,
        // meta: { title: "AdminDashboard" },
        meta: { requiresAuth: true },
    },
    {
        name: "admin-update-products",
        path: "/admin/updateproducts",
        component: AdminUpdateProduct,
        // meta: { title: "AdminDashboard" },
        meta: { requiresAuth: true },
    },
    {
        name: "admin-chat",
        path: "/admin/chat",
        component: AdminChat,
        // meta: { title: "AdminDashboard" },
        meta: { requiresAuth: true },
    },
    //
];
