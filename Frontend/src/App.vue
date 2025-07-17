<script setup lang="ts">
import { RouterView } from 'vue-router'
import Navbar from './components/Navbar.vue';
import Header from './components/Header.vue';
import { useAuthStore } from './stores/auth';
import { onMounted } from 'vue';
import SlideIn from './components/ui/SlideIn.vue';


const auth = useAuthStore();
// onMounted(
//   async () =>{
//     const login = useLogin()
//     await login.login("meriem@email.com","12345678")
//   }
// )
</script>


<template>
  <div v-if="auth.isAuthenticated" class="grid grid-cols-[auto_1fr] h-screen">
    <Navbar />
    <div class="h-screen p-2 ">
      <div class="p-4 pt-2 rounded-2xl bg-[#FAFAFB] shadow flex flex-col gap-5 h-full overflow-auto">
        <div class=" sticky top-0">
          <Header/>
        </div>
        <RouterView />
      </div>
    </div>
  </div>
  <div v-else class="h-screen">
    <RouterView />
  </div>
  <!-- <SlideIn/> -->
</template>




