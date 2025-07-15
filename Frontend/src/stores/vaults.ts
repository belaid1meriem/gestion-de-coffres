import type Vault from "@/Interfaces/vault";
import { defineStore } from "pinia";
import { ref, watch } from "vue";

export const useVaultsStore = defineStore("vaults", () => {

    const vaults = ref<Vault[]>([]);

    watch(vaults,(newVaults)=>{
        console.log(newVaults)
    })
    return {
        vaults,
    }
})