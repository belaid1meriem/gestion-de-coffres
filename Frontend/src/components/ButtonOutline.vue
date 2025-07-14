<script setup lang="ts">
const props = defineProps<{
    customClass?: string
    text: string
    onClick?: () => void
}>();
</script>

<template>
    <button 
    class="px-4 py-1 border border-[#6C3EF5] rounded-md cursor-pointer text-[#6C3EF5] hover:bg-[#F4F4F6] transition-colors duration-300"
    :class="customClass"
    @click="onClick">
        {{ text }}
    </button>
</template>