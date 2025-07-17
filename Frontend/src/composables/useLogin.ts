import { useAuthStore } from "@/stores/auth";
import api from "@/services/axios";
import { ref } from "vue";
import { useRouter } from "vue-router";
import { nextTick } from "vue";

const useLogin = () => {

    const isLoading = ref(false);
    const error = ref<string|null>(null);
    const authStore = useAuthStore();
    const router = useRouter()


    const login = async (email: string, password: string): Promise<void> => {

        isLoading.value = true;
        error.value = null;

        try {
            const response = await api.post("/login", { email, password });
            const token = response.data.token;
            if (token) {
                authStore.token = token;
                await nextTick();
                router.push("/");
            } else {
                throw new Error("Login failed, please try again!");
            }
        } catch (err) {
            error.value = err instanceof Error ? err.message : "Login failed, please try again!";
            if (
                typeof err === "object" &&
                err !== null &&
                "response" in err &&
                typeof (err as any).response === "object" &&
                (err as any).response !== null &&
                "data" in (err as any).response &&
                typeof (err as any).response.data === "object" &&
                (err as any).response.data !== null &&
                "error" in (err as any).response.data
            ) {
                error.value = (err as any).response.data.error;
            } else {
                error.value = err instanceof Error ? err.message : "Login failed, please try again!";
            }
        } finally {
            isLoading.value = false;
        }
    };

    return {
        login,
        isLoading,
        error,
    };
}

export default useLogin;