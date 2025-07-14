<script setup>
import { ref } from 'vue'
import {
  PencilSquareIcon,
  ArrowPathIcon,
  ClockIcon,
  EllipsisVerticalIcon,
} from '@heroicons/vue/24/outline'

const vaults = [
  { name: 'Vault A', code: 'a2cf4a7143c6e2fc99ffc128c38797eef6f9' },
  { name: 'Vault B', code: 'b3de3c74313c6e2fc99ffc128c123456eef6f9' },
]

// Track open dropdown per row
const openMenus = ref({})
const toggleMenu = (index) => {
  openMenus.value[index] = !openMenus.value[index]
}
</script>

<template>
  <div class="w-full">
    <table class="min-w-full table-auto border border-gray-200 rounded-md text-sm">
      <thead class="bg-gray-100 text-left font-medium text-gray-700">
        <tr>
          <th class="px-6 py-3 whitespace-nowrap">Name</th>
          <th class="px-6 py-3 whitespace-nowrap">Current Code</th>
          <th class="px-6 py-3 whitespace-nowrap">Actions</th>
          <th class="px-6 py-3 whitespace-nowrap">History</th>
        </tr>
      </thead>
      <tbody class="text-gray-800 divide-y divide-gray-200">
        <tr
          v-for="(vault, index) in vaults"
          :key="index"
          :class="[
            index % 2 === 0 ? 'bg-white' : 'bg-gray-50',
            'hover:bg-gray-100 transition-colors'
          ]"
        >
          <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ vault.name }}</td>
          <td class="px-6 py-4 text-gray-600 truncate max-w-xs" :title="vault.code">
            {{ vault.code }}
          </td>

          <!-- Dropdown Actions -->
          <td class="px-6 py-4 relative">
            <div class="relative inline-block text-left">
              <button
                @click="toggleMenu(index)"
                class="p-1 text-gray-500 hover:text-gray-700 focus:outline-none"
              >
                <EllipsisVerticalIcon class="w-5 h-5" />
              </button>

              <!-- Dropdown content -->
              <transition name="fade">
                <div
                  v-if="openMenus[index]"
                  class="absolute right-0 mt-2 w-40 origin-top-right rounded-md bg-white border border-gray-200 shadow-lg z-10"
                >
                  <ul class="py-1 text-sm text-gray-700">
                    <li>
                      <button
                        class="w-full flex items-center gap-2 px-4 py-2 hover:bg-gray-100"
                      >
                        <ArrowPathIcon class="w-4 h-4 text-purple-600" />
                        Regenerate Code
                      </button>
                    </li>
                    <li>
                      <button
                        class="w-full flex items-center gap-2 px-4 py-2 hover:bg-gray-100"
                      >
                        <PencilSquareIcon class="w-4 h-4 text-blue-600" />
                        Edit Name
                      </button>
                    </li>
                  </ul>
                </div>
              </transition>
            </div>
          </td>

          <!-- View History -->
          <td class="px-6 py-4">
            <button
              class="flex items-center gap-1 text-sm text-purple-600 border border-purple-500 px-3 py-1 rounded hover:bg-purple-50 focus:outline-none"
              title="View History"
              aria-label="View History"
            >
              <ClockIcon class="w-4 h-4" />
              History
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.15s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
