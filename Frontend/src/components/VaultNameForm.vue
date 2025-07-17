<script setup lang="ts">
import Input from './ui/Input.vue';
import ButtonPrimary from './ui/ButtonPrimary.vue';
import useVaultNameForm from '@/composables/forms/useVaultNameForm';
import SuccessIndicator from './ui/SuccessIndicator.vue';
import ErrorIndicator from './ui/ErrorIndicator.vue';
import { computed, watch } from 'vue';
import { toast } from 'vue-sonner';

const props = defineProps<{
    id?: number
    vaultName: string
}>()

const emit = defineEmits(['close'])

const { 
    name,
    nameError,
    isLoading,
    error,
    success,
    onSubmit
  } = useVaultNameForm({name: props.vaultName}, props.id)

const actionTitle = computed(()=>{
    return props.id ? 'Edit the vault' : 'Create a new vault'
})

watch(success,()=>{
    if(success){
        emit('close')
        toast.success(success)
    }
})

watch(error,()=>{
    if(error){
        emit('close')
        toast.error(error)
    }
})

</script>
<template>
    <form @submit="onSubmit">
        <div class="flex flex-col gap-6 min-w-2xs">
            <h1 class="text-xl font-semibold">{{ actionTitle }}</h1>
            <div class="flex flex-col gap-6">
                <Input v-model="name" :error="nameError" label="Name" placeholder="my Vault" />
                <ButtonPrimary :text="isLoading ? 'Loading...' : 'Save'" class="w-full px-2" :disabled="isLoading"/>
            </div>
        </div>
    </form>
</template>