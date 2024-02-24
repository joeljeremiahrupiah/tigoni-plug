import axios from "axios";
import { defineStore } from "pinia";

export const useProductStore = defineStore("product", {
    state: () => ({
        product: null,
        products: null,
        paidproducts: null,
        unpaidproducts: null,
        relatedproducts: null,
        productimages: null,
        rerendershoppage: 0,
    }),
    actions: {},

    persist: true,
});
