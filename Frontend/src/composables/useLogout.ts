import { useAuthStore } from "@/stores/auth";
import router from '@/router';

const useLogout = () => {

    const authStore = useAuthStore();

    const logout = (): void => {
        authStore.token = null; // Clear the token
        router.push('/login'); // Redirect to login page
    };

    return {
        logout,
    };
}

export default useLogout;