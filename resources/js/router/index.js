import Home from "@/Pages/Home.vue";
import Dashboard from "@/Pages/Dashboard.vue";
import Account from "@/Pages/User/Account.vue";
import ProductDetails from "@/Pages/User/ProductDetails.vue";
import Shop from "@/Pages/Shop/ShopList.vue";
import ChatMessage from "@/Pages/User/ChatMessage.vue";

export const routes = [
    {
        name: "home",
        path: "/",
        component: Home,
        meta: { title: "Home" },
    },
    {
        name: "dashboard",
        path: "/dashboard",
        component: Dashboard,
        meta: { title: "Dashboard" },
    },
    {
        name: "account",
        path: "/account/:productId?/:userId?",
        component: Account,
        meta: { title: "Account" },
        // meta: { requiresAuth: true },
    },
    {
        name: "product-details",
        path: "/product-details/:id?",
        component: ProductDetails,
        meta: { title: "ProductDetails" },
    },
    {
        name: "shop",
        path: "/shop/:productId?/:categoryId?",
        component: Shop,
        meta: { title: "Shop" },
    },
    {
        name: "chat",
        path: "/chat/:productId?/:userId?",
        component: ChatMessage,
        meta: { title: "ChatMessage" },
    },
];
