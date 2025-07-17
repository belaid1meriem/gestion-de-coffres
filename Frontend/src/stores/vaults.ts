import useVaults from "@/composables/useVaults";
import type Vault from "@/interfaces/vault";
import { defineStore } from "pinia";
import { onMounted, onUnmounted, ref, watch } from "vue";
import api from "@/services/axios";
export const useVaultsStore = defineStore("vaults", () => {

    const vaults = ref<Vault[]>([]);

    
    const isFetching = ref(false)
    const fetchError = ref<string | null>(null)
    let refreshTimer: ReturnType<typeof setTimeout> | null = null

     
    const fetchVaults = async (): Promise<void> => {
        isFetching.value = true
        fetchError.value = null

        try {
            const response = await api.get("/vaults")
            vaults.value = response.data
            console.log(response.data)
        } catch (err) {
            fetchError.value = err instanceof Error ? err.message : "Failed to fetch vaults."
        } finally {
            isFetching.value = false
            refreshTimer = setTimeout(fetchVaults, 600000) // auto-refresh every 10 min
        }
    }


    // Lifecycle: auto-fetch on mount and clean up on unmount
    onMounted(() => {
        fetchVaults()
    })

    onUnmounted(() => {
        if (refreshTimer) clearTimeout(refreshTimer)
    })
    return {
        vaults,
        isFetching,
        fetchError
    }
})