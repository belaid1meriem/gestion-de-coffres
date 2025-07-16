<script setup lang="ts">
import {
  computed,
  defineModel,
  defineProps,
  type FunctionalComponent,
  type HTMLAttributes,
  type VNodeProps
} from 'vue'

const model = defineModel<string>()

const props = defineProps<{
  placeholder?: string
  label?: string
  name?: string
  error?: string
  type?: string
  icon?: FunctionalComponent<HTMLAttributes & VNodeProps>
  iconStyles?: string
  onClickIcon?: () => void
  class?: string
}>()

const showIcon = computed(() => !!props.icon)
const showLabel = computed(() => !!props.label)
const inputType = computed(() => props.type || 'text')
</script>

<template>
  <div class="flex flex-col items-start justify-center gap-2 w-full">
    <label
      v-if="showLabel"
      :for="name"
      class="text-sm font-medium text-gray-700"
    >
      {{ label }}
    </label>

    <div class="relative w-full">
      <input
        :id="name"
        :type="inputType"
        v-model="model"
        :placeholder="props.placeholder"
        class="flex h-10 w-full rounded-md border shadow-xs border-[#E0E0E0] px-3 py-2 text-sm text-[#333] placeholder-[#aaa] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#6C3EF5] disabled:cursor-not-allowed disabled:opacity-50"
        :class="[{ 'border-red-500': props.error }, props.class]"
      />

      <component
        v-if="showIcon"
        :is="props.icon"
        class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-[#7C7C7C] cursor-pointer"
        :class="props.iconStyles"
        @click="props.onClickIcon"
      />
    </div>

    <p v-if="props.error" class="text-xs text-red-500 mt-1">
      {{ props.error }}
    </p>
  </div>
</template>
