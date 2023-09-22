<template>
  <ElectionLayout>
    <div class="min-h-full ">
      <div class="max-w-7xl mx-auto px-4">
        <h4 class="sr-only">Steps</h4>
        <div class="mt-6" aria-hidden="true">
          <div class="bg-gray-200 rounded-full overflow-hidden">
            <div class=" w-full h-2 rounded-full bg-accent"/>
          </div>
          <div class="hidden sm:grid grid-cols-3 text-sm font-medium text-gray-600 mt-6">
            <div class="text-accent">Personal Information</div>
            <div class="text-accent text-center">Vote Candidate</div>
            <div class="text-accent text-right">Finish</div>
          </div>
        </div>
      </div>

      <div class="flex items-center justify-center mt-40 divide-x-2 divide-gray-300">
        <HimatifThirdLogo class="text-accent w-32 pr-4"/>
        <div class="border-accent items-center pl-4">
          <h1 class="text-3xl sm:text-5xl font-extrabold text-black">Voting Complete</h1>
          <p class="font-lg font-medium text-gray-500 pt-1">Your Vote is Counted</p>
        </div>
      </div>
      <div class="flex items-center justify-center mt-5">
        <a :href="link" target="_blank" class="flex items-center text-lg text-secondaryAccent hover:border-b border-secondaryAccent cursor-pointer">
          see results
          <span>
            <ArrowRightIcon class="w-6"/>
          </span>
        </a>
      </div>
    </div>
  </ElectionLayout>
</template>
<script setup>
import {CheckCircleIcon, ArrowRightIcon} from "@heroicons/vue/20/solid/index.js";
import ElectionLayout from "@/Layouts/ElectionLayout.vue";
import HimatifThirdLogo from "@/Assets/HimatifThirdLogo.vue";
defineProps({
  link: {
    required: false
  }
})
</script>