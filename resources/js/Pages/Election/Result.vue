<template>
  <ElectionLayout>
    <div class="mt-10 mx-4 md:mx-10">
      <!---- Candidate List ---->
      <div class="flex flex-col space-y-4 md:space-y-0 md:flex-row  md:px-10 lg:px-24 md:space-x-12 md:justify-around">
        <div @click="openSlideOver(candidate)" v-for="candidate in election.candidates" :key="candidate.id" class="md:w-64 overflow-hidden bg-white shadow-lg cursor-pointer hover:shadow-2xl hover:scale-105  transition-all">
          <!---- Card ---->
          <CardCandidadate :photo="candidate.photo" :candidate-voters="candidate.voters.length" :election-voters="election.voters.length" :number="candidate.number" :name="candidate.name"/>
        </div>
        <CandidateInformationSlide v-if="candidateSelected !== null" :open="open" :candidate="candidateSelected" :gens="election.generations" @toggle="() => open = false"/>
      </div>
      <!---- Candidate Stat ----->
      <div class="grid grid-cols-1 md:grid-cols-2 md:max-w-screen-xl gap-y-2 py-2 md:gap-x-4 mx-auto mt-12 w-full border rounded-lg shadow-lg bg-white overflow-hidden">
        <!---- Candidates ---->
        <div class="">
          <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto">
              <div class="inline-block min-w-full py-2 align-middle">
                <div class="overflow-hidden shadow-sm ">
                  <table class="min-w-full divide-y divide-gray-400">
                    <thead class="">
                      <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">Name</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Number</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Voters</th>
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                      <tr v-for="candidate in election.candidates" :key="candidate.id" class="border-l-8 border-gray-300 first:border-emerald-500 first:bg-emerald-50">
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">{{ candidate.name }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ candidate.number }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ candidate.voters.length }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!---- Graphic ---->
        <div class="md:w-full mx-auto">
          <canvas id="candidateVoters" class="mx-auto"/>
        </div>
      </div>
      <!---- Generation Stat ---->


      <div class="grid grid-cols-1 md:grid-cols-1 md:max-w-screen-xl gap-y-2 md:gap-x-4 mx-auto mt-12 w-full">
        <div class="md:w-full mx-auto border rounded-lg p-2 shadow-lg bg-white">
          <p class="text-gray-400 font-bold">Election Participants</p>
          <canvas id="electionParticipants" class="mx-auto"/>
        </div>
<!--        <div class="md:w-full mx-auto border rounded-lg p-2 shadow-lg bg-white">-->
<!--          <p class="text-gray-400 font-bold">Candidate Voters</p>-->
<!--          <canvas id="candidateVoters" class="mx-auto"/>-->
<!--        </div>-->
      </div>
    </div>
  </ElectionLayout>
</template>

<script setup>
import ElectionLayout from "@/Layouts/ElectionLayout.vue";
import CardCandidadate from "@/Components/CardCandidadate.vue";
import {onMounted, ref} from "vue";
import {Chart} from "chart.js/auto";
import CandidateInformationSlide from "@/Pages/Election/Partials/CandidateInformationSlide.vue";

const candidateSelected = ref(null);
const open = ref(false);

const props = defineProps({
  election : {
    required : true
  },
})

function openSlideOver(candidate){
  open.value = true
  candidateSelected.value = candidate
}



onMounted(() => {
  props.election.candidates.sort(function (a, b) {
    return b.voters.length - a.voters.length;
  })

  new Chart(document.getElementById('candidateVoters'), {
    type: 'doughnut',
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
    type: 'polarArea',
    data: {
      labels: props.election.generations.map(function (gen){
        return gen.year
      }),
      datasets: [{
        label: 'voters',
        data: props.election.generations.map(function (gen){
          return gen.voters.length
        }),
        backgroundColor: [
          'rgb(255, 99, 132)',
          'rgb(75, 192, 192)',
          'rgb(255, 205, 86)',
        ],
        hoverOffset: 4
      }]
    }
  })


})
</script>
