<script setup lang="ts">
import { ref, watch } from 'vue';
import Input from '../components/ui/Input.vue';
import { MagnifyingGlassIcon } from '@heroicons/vue/24/outline';
import { toast } from 'vue-sonner';
import IconLoading from './icons/IconLoading.vue';

const props = defineProps<{
    searchfn: (...args: any) => any,
    isLoading: boolean,
    error: string | null
}>()

const searchInput = ref<string>('')

watch(() => props.error, ()=>{
    if(props.error){
        toast.error(props.error)
    }
})
</script>

<template>
    <main class="h-full flex flex-col items-center justify-center gap-8 px-6">
    <h1 class="font-semibold text-3xl">Search in <span class="text-[#D6D8FF] text-shadow-2xs text-shadow-[#6C3EF5]">Vaults</span> by typing a <span class="text-[#D6D8FF] text-shadow-2xs text-shadow-[#6C3EF5]">code</span> </h1>
    <Input placeholder="code" 
    v-model="searchInput"
    class="py-4" 
    :icon="MagnifyingGlassIcon" 
    icon-styles="cursor-pointer"
    :onClickIcon="()=>searchfn(searchInput)"
        />
    </main>
    <div v-if="isLoading" class="w-full h-full  flex-1 flex items-center justify-center">
        <IconLoading class="size-12 text-[#6C3EF5]"/>
    </div>
</template>
