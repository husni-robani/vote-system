<template>
  <AdminElectionLayout>
    <div class="flex flex-wrap justify-around gap-y-4 md:gap-x-16">
      <div v-for="item in electionInformation" class="flex items-center justify-around w-56 gap-x-2 py-2 px-5 bg-white border rounded-md shadow-md">
        <component :is="item.icon" class="w-20 mx-auto text-secondaryAccent"/>
        <div class="">
          <p class="text-center font-medium text-gray-500 text-sm">{{item.title}}</p>
          <h1 class="text-6xl font-bold text-center text-black">{{item.stat}}</h1>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 md:max-w-screen-xl gap-y-2 md:gap-x-4 mx-auto mt-12 w-full">
      <div class="md:w-full mx-auto border rounded-lg p-2 shadow-lg bg-white">
        <p class="text-gray-400 font-bold">Candidate Voters</p>
        <canvas id="candidateVoters" class="mx-auto"/>
      </div>
      <div class="md:w-full mx-auto border rounded-lg p-2 shadow-lg bg-white">
        <p class="text-gray-400 font-bold">Election Participants</p>
        <canvas id="electionParticipants" class="mx-auto"/>
      </div>
    </div>
  </AdminElectionLayout>
</template>
<script setup>
import AdminElectionLayout from "@/Layouts/Admin/AdminElectionLayout.vue";
import {usePush} from "notivue";
import {onMounted} from "vue";
import {usePage} from "@inertiajs/vue3";
import {UserIcon, UserGroupIcon, CheckBadgeIcon} from '@heroicons/vue/24/outline'
import {Chart} from "chart.js/auto";

const props = defineProps({
  election: {
    required: true
  }
})

const electionInformation = [
  {
    title: 'Candidates',
    icon: UserIcon,
    stat: props.election.candidates.length
  }, {
    title: 'Voters',
    icon: UserGroupIcon,
    stat: props.election.voters.length
  }, {
    title: 'Generation',
    icon: CheckBadgeIcon,
    stat: props.election.generations.length
  }
]

const push = usePush();
onMounted(() => {
  new Chart(document.getElementById('candidateVoters'), {
    type: 'pie',
    data: {
      labels: props.election.candidates.map(function (candidate){
        return candidate.name
      }),
      datasets: [{
        label: 'voters',
        data: props.election.candidates.map(function (candidate){
          return candidate.voters.length
        }),
        backgroundColor: [
          'rgb(255, 99, 132)',
          'rgb(54, 162, 235)',
          'rgb(255, 205, 86)'
        ],
        hoverOffset: 4
      }]
    }
  })

  new Chart(document.getElementById('electionParticipants'), {
    type: 'pie',
    data: {
      labels: props.election.generations.map(function (gen){
        return gen.year
      }),
      datasets: [{
        label: 'voters',
        data: props.election.generations.map(function (gen){
          return gen.voters.length
        }),
        hoverOffset: 4
      }]
    }
  })

  const page = usePage();
  const notifications = usePage().props.notifications
  if (notifications.success !== null){
    push.success({
      message: notifications.success
    })
  }
})
</script>
