import type User from "@/Interfaces/user";
import { defineStore } from "pinia";
import { computed, ref, watch } from "vue";


export const useAuthStore = defineStore("auth", () => {

    const token = ref<string|null>((() => {
        const token = localStorage.getItem("token");
        return token ? JSON.parse(token) : null;
    })());

    const isAuthenticated = computed(() => !!token.value);

    watch(token, (newToken) => {
        if (newToken) {
            localStorage.setItem("token", JSON.stringify(newToken));
        } else {
            localStorage.removeItem("token");
        }
    })

    return {
        token,
        isAuthenticated,
    }
})