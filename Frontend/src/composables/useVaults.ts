import { ref, onMounted, onUnmounted } from "vue"
import { useVaultsStore } from "@/stores/vaults"
import api from "@/services/axios"


const useVaults = () => {
  const vaultsStore = useVaultsStore()

  // States for CREATE
  const isCreating = ref(false)
  const createError = ref<string | null>(null)
  const createSuccess = ref<string | null>(null)

  // States for UPDATE Code
  const isUpdatingCode = ref(false)
  const updateCodeError = ref<string | null>(null)
  const updateCodeSuccess = ref<string | null>(null)

  // 🔹 Update Vault Name
  const isUpdatingName = ref(false)
  const updateNameError = ref<string | null>(null)
  const updateNameSuccess = ref<string | null>(null)



  // 🟢 Create a new vault
  const createVault = async (name: string): Promise<void> => {
    isCreating.value = true
    createError.value = null
    createSuccess.value = null
    try {
      const response = await api.post("/vault/create", { name })
      vaultsStore.vaults.push(response.data.vault)
      createSuccess.value = "Vault created succesfully!"
    } catch (err) {
      createError.value = err instanceof Error ? err.message : "Failed to create vault."
    } finally {
      isCreating.value = false
    }
  }

  // 🟢 Update a vault's name
  const updateNameVault = async (id: number, name: string): Promise<void> => {
    isUpdatingName.value = true
    updateNameError.value = null
    updateNameSuccess.value = null
    try {
      const response = await api.put(`/vault/edit/name/${id}`, { name })
      const vault = vaultsStore.vaults.find(v => v.id === response.data.vault.id);
      if (vault) {
        vault.name = response.data.vault.name; 
      }
      updateNameSuccess.value = "Vault updated successfully!"
    } catch (err) {
      updateNameError.value = err instanceof Error ? err.message : "Failed to update vault."
    } finally {
      isUpdatingName.value = false
    }
  }

  // 🟢 Update a vault's code
  const updateCodeVault = async (id: number): Promise<void> => {
    isUpdatingCode.value = true
    updateCodeError.value = null
    updateCodeSuccess.value = null
    try {
      const response = await api.put(`/vault/edit/code/${id}`)
      const vault = vaultsStore.vaults.find(v => v.id === response.data.vault.id);
      if (vault) {
        vault.code = response.data.vault.code; 
      }
      updateCodeSuccess.value = "Vault updated successfully!"
    } catch (err) {
      updateCodeError.value = err instanceof Error ? err.message : "Failed to update vault."
    } finally {
      isUpdatingCode.value = false
    }
  }





  return {

    // Create
    isCreating,
    createError,
    createVault,

    // Update Code
    isUpdatingCode,
    updateCodeError,
    updateCodeSuccess,
    updateCodeVault,

    // Update Name
    isUpdatingName,
    updateNameError,
    updateNameSuccess,
    updateNameVault,

  }
}

export default useVaults
