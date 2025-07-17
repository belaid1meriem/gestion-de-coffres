<script setup lang="ts">
import IconNavbar from '../icons/IconNavbar.vue';
import ButtonOutline from './ButtonOutline.vue';
import useLogout from '@/composables/useLogout';

const logout = useLogout();
</script>
<template>
    <header class="flex justify-between items-center w-full px-5 py-2 border-b-1 border-[#D6D8FF] bg-[#FAFAFB]" >
        <IconNavbar customClass="text-[#1A1A1A] w-9 h-9 border-r-1 border-[#D6D8FF] p-2 " />
        <ButtonOutline text="Logout" :onClick="logout.logout" />
</header>
</template>