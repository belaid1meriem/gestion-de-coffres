import type Vault from "@/interfaces/vault";
import api from "@/services/axios";
import { ref } from "vue";

const useSearch = () => {

    const isLoading = ref(false);
    const error = ref<string|null>(null);

    const searchVault = async (code: string): Promise<Vault | null> => {
        isLoading.value = true;
        error.value = null;
        let vault = null 
        try {
            const response = await api.get(`/vault/search/${code}`,);
            vault = response.data.vault
        } catch (err) {
            error.value = err instanceof Error ? err.message : "Search failed, please try again!";
        } finally {
            isLoading.value = false;
            return vault
        }
    };

    return {
        searchVault,
        isLoading,
        error,
    };
}

export default useSearch