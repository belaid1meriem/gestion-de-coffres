<script setup lang="ts">
import { ref } from 'vue'
import {
  PencilSquareIcon,
  ArrowPathIcon,
  ClockIcon,
} from '@heroicons/vue/24/outline'
import { defineProps } from 'vue'
import type Vault from '@/interfaces/vault';
import HistorySlideIn from './HistorySlideIn.vue';
import RegenrateCodeModal from './RegenrateCodeModal.vue';

const props = defineProps<{
  vault: Vault
}>()

const modals = {
  history: ref(false),
  updateName: ref(false),
  updateCode: ref(false),
}

const open = (key: keyof typeof modals) => {
  modals[key].value = true
}

const close = (key: keyof typeof modals) => {
  modals[key].value = false
}

</script>

<template>
  <div class="bg-white p-6 rounded-md shadow-sm transition-all duration-200 w-full max-w-sm">

    <div class="flex justify-between items-center mb-4">
      <h2 class="text-lg font-semibold text-[#1A1A1A]">{{ vault.name }}</h2>

      <div class="flex items-center gap-3 text-gray-500">
        <ClockIcon @click="open('history')" class="w-5 h-5 hover:text-[#6C3EF5] cursor-pointer" title="View history" />
        <ArrowPathIcon @click="open('updateCode')" class="w-5 h-5 hover:text-[#6C3EF5] cursor-pointer" title="Regenerate code" />
        <PencilSquareIcon @click="open('updateName')" class="w-5 h-5 hover:text-[#6C3EF5] cursor-pointer" title="Edit name" />
      </div>

    </div>

    <div>
      <p class="text-sm">
        <span class="font-medium text-[#4A4A4A]">Current code</span>
        <span class=" pl-1 block font-mono break-words mt-1 text-[#1A1A1A]">
          {{ vault.code }}
        </span>
      </p>
    </div>

    <!-- modals -->
    <HistorySlideIn :close="() => close('history')" :id="vault.id" v-if="modals.history.value"  />
    <RegenrateCodeModal :show="modals.updateCode.value" :close="() => close('updateCode') " :id="vault.id"/> 
  </div>
</template>
