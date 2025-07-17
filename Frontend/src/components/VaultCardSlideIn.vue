<script setup lang="ts">
import type Vault from '@/interfaces/vault';
import SlideIn from './ui/SlideIn.vue';
import VaultCard from './VaultCard.vue';

const props = defineProps<{
    close: () => void,
    vault: Vault
}>()

</script>

<template>
    <SlideIn :close>
        <VaultCard :vault />
    </SlideIn>
</template>