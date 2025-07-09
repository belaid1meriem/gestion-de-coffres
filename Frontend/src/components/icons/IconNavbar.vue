<template>
  <svg
    xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 64 64"
    fill="currentColor"
    :class="customClass"
    :width="size"
    :height="size"
  >
    <path
      d="M50.01,56.074l-35.989,0c-3.309,0 -5.995,-2.686 -5.995,-5.995l0,-36.011c0,-3.308 2.686,-5.994 5.995,-5.994l35.989,0c3.309,0 5.995,2.686 5.995,5.994l0,36.011c0,3.309 -2.686,5.995 -5.995,5.995Zm-25.984,-4l0,-40l-9.012,0c-1.65,0.001 -2.989,1.34 -2.989,2.989l0,34.022c0,1.649 1.339,2.989 2.989,2.989l9.012,0Zm24.991,-40l-20.991,0l0,40l20.991,0c1.65,0 2.989,-1.34 2.989,-2.989l0,-34.022c0,-1.649 -1.339,-2.988 -2.989,-2.989Z"
    />
  </svg>
</template>

<script setup>
defineProps({
  size: {
    type: [Number, String],
    default: 24, // fallback to 24px
  },
  customClass: {
    type: String,
    default: '', // allow passing Tailwind classes like 'text-indigo-500'
  },
})
</script>
