<script setup lang="ts">
import useVaults from '@/composables/useVaults';
import ButtonOutline from './ui/ButtonOutline.vue';
import ButtonPrimary from './ui/ButtonPrimary.vue';
import Modal from './ui/Modal.vue';
import SuccessIndicator from './ui/SuccessIndicator.vue';
import ErrorIndicator from './ui/ErrorIndicator.vue';
import { watch } from 'vue';
import { toast } from 'vue-sonner';

const props = defineProps<{
  show: boolean
  close: () => void
  id: number
}>()

const vaults = useVaults()

watch(() => vaults.updateCodeSuccess.value, () => {
    if (vaults.updateCodeSuccess.value) {
        props.close()
        toast.success(vaults.updateCodeSuccess.value)
    }
})

watch(() => vaults.updateCodeError.value, () => {
    if (vaults.updateCodeError.value) {
        props.close()
        toast.success(vaults.updateCodeError.value)
    }
})


</script>

<template>
    <Modal :show :close>
        <div class=" flex flex-col max-w-prose items-center justify-center gap-6">
            <p class="font-medium text-lg text-center ">Click on the button below to regenerate and assign a new code to the vault</p>
            <div class="flex items-center justify-center gap-3 w-full">
                <ButtonOutline text="Dismiss" :onClick="close"/>
                <ButtonPrimary :text="vaults.isUpdatingCode.value ? 'Regenerating...' : 'Regenerate'" :disabled="vaults.isUpdatingCode.value" :onClick="async ()=> await vaults.updateCodeVault(id)"/>
            </div>
        </div>
    </Modal>
</template>