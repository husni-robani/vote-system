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
          <StatsCard  v-for="generation in voter_by_gen" :title="generation.gen_year" :statistic="generation.voter_count"/>
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
  },
    'voter_by_gen': {
      required: true
    }
})

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
