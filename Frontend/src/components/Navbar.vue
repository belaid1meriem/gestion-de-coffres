<script setup lang="ts">
import {HomeIcon, MagnifyingGlassIcon, UserPlusIcon} from '@heroicons/vue/24/outline'
import NavElt from './NavElt.vue';

</script>
<template>
  <nav class="bg-[#F4F4F6] h-full flex flex-col items-center justify-start gap-10 p-3 ">
    <div class="flex flex-col items-start justify-start gap-6 w-full">
      <div class='p-2'>
        <RouterLink to="/" class="text-[#6C3EF5] text-xl font-bold px-4">VaultManager</RouterLink>
      </div>
      <div class='p-2 flex flex-col items-start justify-end gap-4'>
        <NavElt :title="'Home'" :to="'/'" :icon=HomeIcon />
        <NavElt :title="'Search'" :to="'/search'" :icon="MagnifyingGlassIcon" />
        <NavElt :title="'Add a friend'" :to="'/user/add'" :icon="UserPlusIcon" />
      </div>
    </div>
  </nav>
</template>