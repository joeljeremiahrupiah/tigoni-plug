import axios from "axios";
import { defineStore } from "pinia";

export const useUserStore = defineStore("user", {
    state: () => ({
        authuser: null,
        token: null,
        authcustomer: null,
        customertoken: null,
        users: null,
        admindetails: null,
    }),
    actions: {},

    persist: true,
});
