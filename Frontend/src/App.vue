<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
import Navbar from './components/Navbar.vue';
import Header from './components/Header.vue';
</script>

<template>
  <div class="grid grid-cols-[auto_1fr] h-full">
    <Navbar />
    <div class="h-full p-2 ">
      <div class="p-4 pt-2 rounded-2xl bg-[#FAFAFB] shadow flex flex-col gap-5 h-full  overflow-auto">
        <Header/>
        <RouterView />
      </div>
    </div>
  </div>


</template>




