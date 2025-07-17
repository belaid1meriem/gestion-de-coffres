<script setup lang="ts">
import CreateVaultSlideIn from '@/components/CreateVaultSlideIn.vue';
import IconLoading from '@/components/icons/IconLoading.vue';
import VaultCard from '@/components/VaultCard.vue';
import { useVaultsStore } from '@/stores/vaults'
import { PlusIcon } from '@heroicons/vue/24/outline';
import { onMounted, ref } from 'vue';

const modals = {
  createVault: ref<boolean>(false)
}

const vaults = useVaultsStore();

const open = (key: keyof typeof modals) => {
  modals[key].value = true
}

const close = (key: keyof typeof modals) => {
  modals[key].value = false
}

onMounted(async ()=>{
  if(vaults.vaults.length === 0){
    await vaults.fetchVaults();
  }
})
</script>

<template>
  <div class="flex flex-col items-start justify-start gap-8 w-full h-full">
    <div class="flex items-center justify-between w-full px-3">
      <h1 class=" text-xl font-semibold">Vaults</h1>
      <PlusIcon class="size-6 cursor-pointer text-[#1A1A1A]" @click="open('createVault')"/>
    </div>
    <div v-if="vaults.isFetching" class="w-full h-full  flex-1 flex items-center justify-center">
      <IconLoading class="size-12 text-[#6C3EF5]"/>
    </div>
    <div v-else class="grid grid-cols-3 gap-4 w-full px-3">
      <VaultCard v-for="vault in vaults.vaults" :key="vault.id" :vault/>
    </div>
  </div>
  <CreateVaultSlideIn v-if="modals.createVault.value" :close="() => close('createVault')"/>
</template>
