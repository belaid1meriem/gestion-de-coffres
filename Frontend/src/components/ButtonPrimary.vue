<script setup lang="ts">
const props = defineProps<{
    class?: string
    text: string
    onClick?: (...args: any[]) => any
    disabled?: boolean
}>();
</script>

<template>
    <button 
    class="px-4 py-2 bg-[#6C3EF5] rounded-md cursor-pointer text-[#FAFAFB] hover:bg-[#5932C6] transition-colors duration-300 text-sm font-medium font-geist disabled:bg-[#7C7C7C]"
    :class="class"
    :disabled
    @click="onClick">
        {{ text }}
    </button>
</template>