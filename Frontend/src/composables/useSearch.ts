import type Vault from "@/interfaces/vault";
import api from "@/services/axios";
import { ref } from "vue";

const useSearch = () => {

    const vault = ref<Vault|null>()
    const isLoading = ref(false);
    const error = ref<string|null>(null);

    const searchVault = async (code: string): Promise<void> => {
        isLoading.value = true;
        error.value = null;
        
        try {
            const response = await api.get(`/vault/search/${code}`,);
            if(response.data.vault){
                vault.value = response.data.vault
            }
            else{
                throw Error('No Vault with this code exists')
            }
        } catch (err) {
            error.value = err instanceof Error ? err.message : "Search failed, please try again!";
        } finally {
            isLoading.value = false;
        }
    };

    return {
        vault,
        searchVault,
        isLoading,
        error,
    };
}

export default useSearch