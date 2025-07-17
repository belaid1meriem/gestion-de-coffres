<script setup lang="ts">
import { onMounted } from 'vue'
import { CheckCircleIcon, XMarkIcon } from '@heroicons/vue/24/outline'

const props = defineProps<{
  msg: string
  closeSuccess: () => void
}>()

onMounted(() => {
  setTimeout(() => {
    props.closeSuccess()
  }, 5000)
})
</script>

<template>
  <div
    class="fixed bottom-5 left-52 z-10 grid grid-cols-[25px_auto_20px] items-center gap-2 px-5 py-2 h-[45px] bg-[#f0fff1] border border-[#2dc653] border-l-[3px] rounded shadow"
  >
    <CheckCircleIcon class="text-[#2dc653] w-[25px] h-[25px]" />
    <div class="text-[#2dc653] text-[16px] ml-3 mr-10">{{ msg }}</div>
    <XMarkIcon
      class="text-[#2dc653] w-[20px] h-[20px] hover:shadow hover:rounded-full cursor-pointer transition"
      @click="props.closeSuccess"
    />
  </div>
</template>
