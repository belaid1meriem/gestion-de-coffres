<script setup lang="ts">
import useHistory from '@/composables/useHistory';
import SlideIn from './ui/SlideIn.vue';
import { onMounted } from 'vue';
import { ref } from 'vue';
import type MyHistory from '@/interfaces/history';
import IconLoading from './icons/IconLoading.vue';

const props = defineProps<{
    close: () => void,
    id: number
}>()

const historyData = ref<MyHistory[] | null>([])

const history = useHistory();

onMounted(async()=>{
    historyData.value  = await history.getHistory(props.id);
})

</script>
<template>
  <SlideIn :close="close" >
    <div class="space-y-2">
      <div v-if="history.isLoading.value" class="w-full h-full flex-1 flex items-center justify-center">
        <IconLoading class="size-12 text-[#6C3EF5]"/>
      </div>
      <div
        v-for="h in historyData"
        :key="h.id"
        class="bg-white p-6 rounded-md shadow-sm transition-all duration-200 w-full max-w-sm"
      >
        <div class="mb-3">
          <!-- <h3 class="text-sm font-semibold text-[#1A1A1A] mb-1">Updated Code</h3> -->
          <p class="font-mono break-words text-[#1A1A1A] text-sm">{{ h.code }}</p>
        </div>
        <div class="space-y-1 text-sm text-[#4A4A4A]">
          <p><span class="font-medium">Updated At</span> {{ new Date(h.updatedAt).toLocaleString() }}</p>
          <p><span class="font-medium">By</span> {{ h.user.email }}</p>
        </div>
      </div>
    </div>
  </SlideIn>
</template>

