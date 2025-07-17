<script setup lang="ts">
import { onMounted } from 'vue'
import { XCircleIcon, XMarkIcon } from '@heroicons/vue/24/outline'

const props = defineProps<{
  msg: string
  closeError: () => void
}>()

onMounted(() => {
  setTimeout(() => {
    props.closeError()
  }, 5000)
})
</script>

<template>
  <div
    class="fixed bottom-5 left-52 z-10 grid grid-cols-[25px_auto_20px] items-center gap-2 px-5 py-2 h-[45px] bg-[#fff0f3] border border-[#fb2a2a] border-l-[3px] rounded shadow"
  >
    <XCircleIcon class="text-[#fb2a2a] w-[25px] h-[25px]" />
    <div class="text-[#fb2a2a] text-[16px] ml-3 mr-10">{{ msg }}</div>
    <XMarkIcon
      class="text-[#fb2a2a] w-[20px] h-[20px] hover:shadow hover:rounded-full cursor-pointer transition"
      @click="props.closeError"
    />
  </div>
</template>
