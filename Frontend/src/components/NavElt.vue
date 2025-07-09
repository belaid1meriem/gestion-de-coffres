<script setup lang="ts">
import { RouterLink } from 'vue-router';
import { defineProps, type FunctionalComponent, type HTMLAttributes, type VNodeProps } from 'vue';
import { useRoute } from 'vue-router'
import { computed } from 'vue'

const props = defineProps<{
    title: string
    to: string
    icon:FunctionalComponent<HTMLAttributes & VNodeProps, {}, any, {}>
}>();

const route = useRoute()
const isActive = computed(() => route.path === props.to)

</script>

<template>
    <div class="flex items-start  justify-start gap-2 transition-colors duration-300 hover:bg-[#D6D8FF]  px-4 py-2 rounded-md w-full"
         :class="{'shadow-[inset_3px_0_0_0_#6C3EF5] bg-[#D6D8FF]': isActive}">
        <component :is="icon" class="w-5 h-full " />
        <RouterLink :to="to" >{{ title }}</RouterLink>
    </div>
</template>