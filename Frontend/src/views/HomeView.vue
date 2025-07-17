<script setup lang="ts">
import IconLoading from '@/components/icons/IconLoading.vue';
import VaultCard from '@/components/VaultCard.vue';
import { useVaultsStore } from '@/stores/vaults'

const vaults = useVaultsStore();
</script>

<template>
  <div class="flex flex-col items-start justify-start gap-8 w-full h-full">
    <h1 class=" text-xl font-semibold px-3">Vaults</h1>
    <div v-if="vaults.isFetching" class="w-full h-full  flex-1 flex items-center justify-center">
      <IconLoading class="size-12 text-[#6C3EF5]"/>
    </div>
    <div v-else class="grid grid-cols-3 gap-4 w-full px-3">
      <VaultCard v-for="vault in vaults.vaults" :key="vault.id" :vault/>
    </div>
  </div>
</template>
