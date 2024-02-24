import axios from "axios";
import { defineStore } from "pinia";

export const useCategoryStore = defineStore("category", {
    state: () => ({
        category: null,
        categories: null,
    }),
    actions: {},

    persist: true,
});
