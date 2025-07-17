<script setup lang="ts">
import SlideIn from './ui/SlideIn.vue';
import VaultNameForm from './VaultNameForm.vue';

const props = defineProps<{
    close: () => void
}>()

</script>

<template>
    <SlideIn :close>
        <VaultNameForm vaultName="" @close="close"/>
    </SlideIn>
</template>