<template>
  <div class="min-h-screen w-full bg-white flex items-center justify-center">
    <div class="bg-white min-h-full px-4 py-16 sm:px-6 sm:py-24 md:grid md:place-items-center lg:px-8">
      <div class="max-w-max mx-auto">
        <main class="sm:flex">
          <p class="text-4xl font-extrabold text-accent sm:text-5xl">403</p>
          <div class="sm:ml-6">
            <div class="sm:border-l sm:border-gray-200 sm:pl-6">
              <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl">Forbidden Inactive Election</h1>
              <p class="mt-1 text-base text-gray-500">can't you see that the status is inactive bro?</p>
            </div>
            <div class="mt-10 flex space-x-3 sm:border-l sm:border-transparent sm:pl-6">
              <a :href="route('election.menu')" class="inline-flex items-center px-4 py-2 text-md font-medium text-accent hover:text-accent_old"> try another election  <span aria-hidden="true"> &rarr;</span></a>
            </div>
          </div>
        </main>
      </div>
    </div>
  </div>
</template>
<script setup>
import HimatifThirdLogo from "@/Assets/HimatifThirdLogo.vue";
defineProps({
  message: {
    default: "You're unauthorized for this action",
    required: false
  }
})
</script>