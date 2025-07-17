import { useAuthStore } from "@/stores/auth";
import router from '@/router';
import { nextTick } from "vue";

const useLogout =  () => {

    const authStore = useAuthStore();

    const logout = async (): Promise<void> => {
        authStore.token = null; // Clear the token
        await nextTick()
        router.push('/login'); // Redirect to login page
    };

    return {
        logout,
    };
}

export default useLogout;