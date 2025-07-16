<script setup lang="ts">
import Input from '../components/Input.vue';
import { MagnifyingGlassIcon } from '@heroicons/vue/24/outline';

</script>

<template>
  <main class="h-full flex flex-col items-center justify-center gap-8 px-6">
    <h1 class="font-semibold text-3xl">Search in <span class="text-[#D6D8FF] text-shadow-2xs text-shadow-[#6C3EF5]">Vaults</span> by typing a <span class="text-[#D6D8FF] text-shadow-2xs text-shadow-[#6C3EF5]">code</span> </h1>
    <Input placeholder="placeholder" class="py-4" :icon="MagnifyingGlassIcon" icon-styles="cursor-pointer" />
  </main>

</template>
