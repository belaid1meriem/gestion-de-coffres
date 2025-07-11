<script setup lang="ts">
import { computed, defineProps, type FunctionalComponent, type HTMLAttributes, type VNodeProps } from 'vue';

const props = defineProps<{
    placeholder: string
    label?: string
    icon?: FunctionalComponent<HTMLAttributes & VNodeProps, {}, any, {}>
    iconStyles?: string
    onClickIcon?: Function
}>();

const showIcon = computed(()=>{
    return !!props.icon
})

const showLabel = computed(()=>{
    return !!props.label
})
</script>

<template>
    <div class="flex flex-col items-start justify-center gap-2 p-2 w-full">
        <label v-if="showLabel" for="" class="px-0 text-[16px]">{{ label }}</label>
        <div class="w-full flex p-0 relative">
            <input type="text" class="shadow-sm rounded-lg bg-[#FAFAFB] text-sm text-[#7C7C7C] px-4 py-3 w-full" :placeholder="placeholder">
            <component v-if="showIcon" :is="icon" class="w-5 h-full absolute right-4 text-[#7C7C7C]" :class="iconStyles" @click="onClickIcon" />
        </div>
    </div>
</template>