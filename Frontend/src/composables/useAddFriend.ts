import api from "@/services/axios";
import { ref } from "vue";


const useAddFriend = () => {

    const isLoading = ref(false);
    const error = ref<string|null>(null);
    const success =  ref<string|null>(null);

    
    const addFriend = async (email: string, lastName: string, firstName: string, password: string): Promise<void> => {

        isLoading.value = true;
        error.value = null;

        try {
            const response = await api.post("/add/user", { email, password, lastName, firstName });
            success.value = "Friend added successfully"

        } catch (err) {
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
                error.value = err instanceof Error ? err.message : "addFriend failed, please try again!";
            }
        } finally {
            isLoading.value = false;
        }
    };

    return {
        addFriend,
        isLoading,
        error,
        success
    };
}

export default useAddFriend;