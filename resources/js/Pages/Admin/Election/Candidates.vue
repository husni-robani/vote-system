<template>
  <Notivue v-slot="item">
    <Notifications :item="item" :theme="materialTheme"/>
  </Notivue>
  <AdminElectionLayout>
    <template #header>Candidates</template>
    <PrimaryButton @click="open = true">New Candidate</PrimaryButton>
    <div class="bg-white my-2 py-5 px-10 rounded-md shadow-md">
      <div class="mb-10">
        <h1 class="text-2xl font-bold ">List Of Candidate</h1>
        <p class="text-sm text-gray-500">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab aspernatur autem debitis dolorem esse eveniet explicabo praesentium quia, repellat velit?</p>
      </div>
      <ul role="list" class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        <li v-for="candidate in candidates" :key="candidate.email" class="col-span-1 flex flex-col text-center bg-gray-700 xl:w-80  rounded-2xl shadow-lg">
          <CandidateCard :number="candidate.number" :name="candidate.name" :candidate-voters="candidate.voters.length" :id="candidate.id" :total-voter="totalVoter.length" :photo="candidate.photo"/>
        </li>
      </ul>
    </div>
    <CreateCandidateSlide :open="open" @toggle="() => open = false"/>
  </AdminElectionLayout>
</template>
<script setup>
import AdminElectionLayout from "@/Layouts/Admin/AdminElectionLayout.vue";
import {materialTheme, Notifications, Notivue} from "notivue";
import CandidateCard from "@/Components/CandidateCard.vue";
import {Link} from "@inertiajs/vue3";
import CreateCandidateSlide from "@/Pages/Admin/Election/Partials/CreateCandidateSlide.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {ref} from "vue";

const props = defineProps({
  candidates : {
    required: true
  },
  totalVoter: {
    required: true
  }
})
const open = ref(false);
</script>