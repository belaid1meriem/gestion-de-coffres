<script setup lang="ts">
import 'vue-sonner/style.css'
import { RouterView } from 'vue-router'
import Navbar from './components/ui/Navbar.vue';
import Header from './components/ui/Header.vue';
import { useAuthStore } from './stores/auth';
import { Toaster } from 'vue-sonner';


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
  <teleport to="body">
    <Toaster position="bottom-left" rich-colors />
  </teleport>
</template>




