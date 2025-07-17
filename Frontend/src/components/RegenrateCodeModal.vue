<script setup lang="ts">
import useVaults from '@/composables/useVaults';
import ButtonOutline from './ButtonOutline.vue';
import ButtonPrimary from './ButtonPrimary.vue';
import Modal from './Modal.vue';
import SuccessIndicator from './SuccessIndicator.vue';
import ErrorIndicator from './ErrorIndicator.vue';

const props = defineProps<{
  show: boolean
  close: () => void
  id: number
}>()

const vaults = useVaults()
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

    <!-- Indicators for better UX -->
    <SuccessIndicator
        v-if="!!vaults.updateCodeSuccess.value"
        :msg="vaults.updateCodeSuccess.value"
        :closeSuccess="() => {
            vaults.updateCodeSuccess.value = null
            close()
        }"
    />
    <ErrorIndicator
        v-if="!!vaults.updateCodeError.value"
        :msg="vaults.updateCodeError.value"
        :closeError="() => {
            vaults.updateCodeError.value = null
            close()
        }"
    />
</template>