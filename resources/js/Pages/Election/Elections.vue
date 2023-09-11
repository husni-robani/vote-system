<template>
  <ElectionLayout>
    <div class="mx-auto">
      <h1 class="mx-auto text-5xl font-extrabold text-center mt-16">Election List</h1>
      <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qui, quisquam!</p>
    </div>
    <div class="container flex flex-wrap justify-center items-center mx-auto my-10 gap-x-8 gap-y-10">
      <Link :href="route('election.requestLink', {id : election.id})" v-for="election in $page.props.admin.election.all" :key="election.id" class="p-4 border shadow-md rounded-md space-y-2 w-80 overflow-hidden">
        <h1 class="font-extrabold text-xl line-clamp-2 h-16">{{election.title}}</h1>
        <span :class="[election.active ? 'bg-emerald-100 text-emerald-600' : 'bg-gray-200 text-gray-600', 'inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium']">
          <svg :class="[election.active ? 'text-emerald-600 animate-pulse' : 'text-gray-600' , '-ml-0.5 mr-1.5 h-2 w-2']" fill="currentColor" viewBox="0 0 8 8">
            <circle cx="4" cy="4" r="3" />
          </svg>
          {{election.active ? 'Active' : 'Inactive'}}
        </span>
        <div class="flex gap-x-2">
          <span v-for="gen in election.generations" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-200 text-black"> {{gen.year}} </span>
        </div>
      </Link>
    </div>
  </ElectionLayout>
</template>
<script setup>
import ElectionLayout from "@/Layouts/ElectionLayout.vue";
import {Link} from "@inertiajs/vue3";
</script>