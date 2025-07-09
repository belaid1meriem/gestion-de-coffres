<script setup lang="ts">
import CoffreCard from '@/components/CoffreCard.vue';
</script>

<template>
  <div class="flex flex-col items-start justify-start gap-8 w-full">
    <h1 class="text-xl font-semibold px-6">Coffres</h1>
    <div class="flex flex-col items-start justify-start gap-4 w-full">
      <CoffreCard/>
      <CoffreCard/>
      <CoffreCard/>
    </div>
  </div>

</template>
