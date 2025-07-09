<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
import Navbar from './components/Navbar.vue';
import Header from './components/Header.vue';
</script>

<template>
  <div class="grid grid-cols-[auto_1fr] h-full">
    <Navbar />
    <div class="flex-1 h-full p-4 ">
      <div class="flex-1 h-full p-6 rounded-2xl bg-[#FAFAFB] shadow flex flex-col gap-5">
        <Header/>
        <RouterView />
      </div>
    </div>
  </div>


</template>




