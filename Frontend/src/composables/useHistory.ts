import type History from "@/interfaces/history";
import api from "@/services/axios";
import { ref } from "vue";

const useHistory = () => {

    const isLoading = ref(false);
    const error = ref<string|null>(null);

    const getHistory = async (id: number): Promise<History[] | null> => {
        isLoading.value = true;
        error.value = null;
        let history = null 
        try {
            const response = await api.get(`/history/${id}`,);
            history = response.data
        } catch (err) {
            error.value = err instanceof Error ? err.message : "Fetch failed, please try again!";
        } finally {
            isLoading.value = false;
            return history
        }
    };

    return {
        getHistory,
        isLoading,
        error,
    };
}

export default useHistory