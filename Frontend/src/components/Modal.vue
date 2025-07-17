<script setup lang="ts">
import { XMarkIcon } from '@heroicons/vue/24/outline'

const props = defineProps<{
  show: boolean
  close: () => void
}>()

</script>

<template>
  <Transition
    enter-active-class="transition-transform duration-500 ease-in-out"
    enter-from-class="translate-x-full"
    enter-to-class="translate-x-0"
    leave-active-class="transition-transform duration-500 ease-in-out"
    leave-from-class="translate-x-0"
    leave-to-class="translate-x-full"
  >
  <div class=" flex items-center justify-center fixed inset-0" v-if="show">
    <div
      class="h-fit w-fit max-w-xl p-12 shadow-xl border border-[#E0E0E0] bg-[#FAFAFB] rounded-md z-50 relative"
    >
      <XMarkIcon @click="close" class="size-4 absolute top-4 right-4 cursor-pointer" />
      <slot></slot>
    </div>
  </div>

  </Transition>
</template>
