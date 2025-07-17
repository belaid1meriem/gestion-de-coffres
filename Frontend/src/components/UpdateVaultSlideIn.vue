<script setup lang="ts">
import SlideIn from './ui/SlideIn.vue';
import VaultNameForm from './VaultNameForm.vue';

const props = defineProps<{
    close: () => void,
    name: string,
    id: number
}>()

</script>

<template>
    <SlideIn :close>
        <VaultNameForm :vaultName="name" :id  @close="close" />
    </SlideIn>
</template>