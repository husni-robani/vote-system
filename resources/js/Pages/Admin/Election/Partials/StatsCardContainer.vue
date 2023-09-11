<template>
  <div class="mt-10 pb-12 sm:pb-16">
    <div class="relative">
      <div class="absolute inset-0 h-1/2" />
      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
          <dl class="rounded-lg  shadow-lg sm:grid sm:grid-cols-3">
            <slot name="statsCard"/>
          </dl>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>

</script>