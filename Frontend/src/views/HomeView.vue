<script setup lang="ts">
import CoffreCard from '@/components/VaultCard.vue';
</script>

<template>
  <div class="flex flex-col items-start justify-start gap-8 w-full">
    <h1 class="text-xl font-semibold px-6">Coffres</h1>
    <div class="grid grid-cols-3 gap-4 w-full">
      <CoffreCard/>
      <CoffreCard/>
      <CoffreCard/>

      <CoffreCard/>
      <CoffreCard/>
      <CoffreCard/>
    </div>
  </div>

</template>
