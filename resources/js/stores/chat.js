import axios from "axios";
import { defineStore } from "pinia";

export const useChatStore = defineStore("chat", {
    state: () => ({
        chats: null,
        latestchat: null,
        adminchats: null,
    }),
    actions: {},

    persist: true,
});
