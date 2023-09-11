<template>
  <div class="flex flex-col bg-white border-b border-gray-100  rounded-md shadow-md p-6 text-center sm:border-0 sm:border-r">
    <dt class="order-2 mt-2 text-lg leading-6 font-medium text-gray-500">{{title}}</dt>
    <dd class="order-1 text-5xl font-extrabold text-indigo-600">{{ statistic }}</dd>
  </div>
</template>
<script setup>
const props = defineProps({
  title : {
    required: true
  },
  statistic: {
    required: true
  }
})
</script>