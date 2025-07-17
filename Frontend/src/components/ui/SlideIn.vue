<script setup lang="ts">
import { XMarkIcon } from '@heroicons/vue/24/outline'

const props = defineProps<{
  close: () => void
}>()

</script>

<template>
  <div class="fixed top-0 right-0 h-screen w-fit p-12 shadow-xl border border-[#E0E0E0] bg-[#FAFAFB] rounded-md overflow-y-auto z-50 ">
    <XMarkIcon @click="close" class="size-4 absolute top-4 left-4 cursor-pointer" />
    <slot></slot>
  </div>
</template>
