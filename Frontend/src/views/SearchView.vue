<script setup lang="ts">
import SearchForm from '@/components/SearchForm.vue';
import VaultCardSlideIn from '@/components/VaultCardSlideIn.vue';
import useSearch from '@/composables/useSearch';
import type Vault from '@/interfaces/vault';
import { ref } from 'vue';

const { vault,
      searchVault,
      isLoading,
      error } = useSearch()

</script>

<template>
  <SearchForm :searchfn="searchVault" :is-loading :error  />
  <VaultCardSlideIn v-if="vault" :vault :close="() => vault = null"/>
</template>
