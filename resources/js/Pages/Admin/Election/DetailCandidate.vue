<template>
  <AdminElectionLayout>
    <template #header>{{props.candidate.name}}</template>
    <div class="space-y-6">
      <!---- Edit Form ---->
      <EditCandidateForm :candidate="props.candidate"/>
      <!---- Candidate Analysis ---->
      <div>
        <div class="max-w-7xl mx-auto mt-24 px-4 sm:px-6 lg:px-8">
          <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-extrabold text-gray-500 sm:text-4xl">Voted By {{candidate.counter}} students</h2>
          </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-x-8  my-5">
          <StatsCard  v-for="generation in $page.props.admin.election.selected.generations" :title="generation.year" statistic="0"/>
        </div>
      </div>
      <!---- Voter List ---->
      <div class="bg-white py-4 px-10 rounded-lg mb-4">
          <ul role="list" class="divide-y divide-gray-200">
            <li v-for="voter in voters" :key="voter.id" class="py-4 flex justify-between">
              <div class="ml-3">
                <p class="text-sm font-medium text-gray-900">{{ voter.name }}</p>
                <p class="text-sm text-gray-500">{{ voter.email }}</p>
              </div>
              <DangerButton @click.prevent="deleteVoter(voter.id)">Delete</DangerButton>
            </li>
          </ul>
      </div>
    </div>
  </AdminElectionLayout>
</template>

<script setup>
import AdminElectionLayout from "@/Layouts/Admin/AdminElectionLayout.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import EditCandidateForm from "@/Pages/Admin/Election/Partials/EditCandidateForm.vue";
import StatsCard from "@/Components/StatsCard.vue";
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps({
  'candidate' : {
    required: true
  },
  'voters' : {
    required: true
  }
})

const people = [
  {
    name: 'Calvin Hawkins',
    email: 'calvin.hawkins@example.com',
    image:
        'https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
  },
  {
    name: 'Kristen Ramos',
    email: 'kristen.ramos@example.com',
    image:
        'https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
  },
  {
    name: 'Ted Fox',
    email: 'ted.fox@example.com',
    image:
        'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
  },
]


function deleteVoter(voterId){
  useForm({}).delete(route('admin.vote-system.voter.destroy', {
    'id' : usePage().props.admin.election.selected.id,
    'voterId' : voterId
  }), {
    preserveScroll: false,
    onSuccess: () => {

    }
  })
}
</script>