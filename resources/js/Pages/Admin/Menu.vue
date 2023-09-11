<template>
  <div class="flex items-center min-h-screen bg-gray-100">
    <Link :href="route('admin.vote-system.random')" v-for="menu in menus" class="bg-white max-w-md border shadow-lg rounded-md py-4 px-10 mx-auto space-y-4">
      <div>
        <h1 class="text-3xl">{{menu.title}}</h1>
        <p class="text-gray-400">{{menu.description }}</p>
      </div>
      <ArrowRightIcon class="w-6"/>
    </Link>
  </div>
</template>

<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {ArrowRightIcon} from "@heroicons/vue/24/outline"
import {Link} from "@inertiajs/vue3";

const menus = [
  {
    title : 'Election System',
    description: 'Navigate our seamless election system and cast your vote effortlessly for a future defined by your choices',
    href: route('admin.vote-system.random')
  },
  {
    title : 'Main System',
    description: 'Dashboard',
    href: route('dashboard')
  }

]
</script>