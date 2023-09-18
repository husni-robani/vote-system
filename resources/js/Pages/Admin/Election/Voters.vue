<template>
  <AdminElectionLayout>
    <template #header>Voters</template>
    <div class="px-4 sm:px-6 lg:px-8">
      <div class="-mx-4 mt-8 overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg">
        <table class="min-w-full divide-y divide-gray-300">
          <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
            <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">NPM</th>
            <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell">Gen</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 text-center">voted</th>
            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
              <span class="sr-only">Edit</span>
            </th>
          </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 bg-white">
          <tr v-if="voters !== null" v-for="voter  in voters.data" :key="voter.email">
            <td class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6">
              <div class="">
                <div class="font-medium text-gray-900">{{ voter.name }}</div>
                <div class="text-gray-500">{{ voter.email }}</div>
              </div>
              <dl class="font-normal lg:hidden">
                <dt class="sr-only">Npm</dt>
                <dd class="mt-1 truncate text-gray-700">{{ voter.npm }}</dd>
                <dt class="sr-only sm:hidden">Gen</dt>
                <dd class="mt-1 truncate text-gray-500 sm:hidden">{{ voter.generation }}</dd>
              </dl>
            </td>
            <td class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell">{{ voter.npm }}</td>
            <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell">{{ voter.generation }}</td>
            <td class="px-3 py-4 text-sm text-gray-500 text-center">{{ voter.candidateVoted }}</td>
            <td class="py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
              <DangerButton @click="useForm({}).delete(route('admin.vote-system.voter.destroy', {'id' : $page.props.admin.election.selected.id, 'voterId' : voter.id}))">Delete</DangerButton>
            </td>
          </tr>
          </tbody>
        </table>
        <nav v-if="voters !== null" class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6" aria-label="Pagination">
          <div class="hidden sm:block">
            <p class="text-sm text-gray-700">
              Showing
              <span class="font-medium">{{ voters.from }}</span>
              to
              <span class="font-medium">{{voters.to}}</span>
              of
              <span class="font-medium">{{voters.total}}</span>
              results
            </p>
          </div>
          <div class="flex-1 flex justify-between sm:justify-end">
            <Link v-if="voters.current_page !== 1" :href="voters.prev_page_url" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Previous </Link>
            <Link v-if="voters.current_page !== voters.last_page" :href="voters.next_page_url" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Next </Link>
          </div>
        </nav>
      </div>
    </div>
  </AdminElectionLayout>
</template>
<script setup>
import AdminElectionLayout from "@/Layouts/Admin/AdminElectionLayout.vue";
import DangerButton from "@/Components/DangerButton.vue";
import {Link, useForm} from "@inertiajs/vue3";

const props = defineProps({
  voters : {
    required: true
  }
})
const people = [
  { name: 'Lindsay Walton', title: 'Front-end Developer', email: 'lindsay.walton@example.com', role: 'Member' },
]
function deleteVoter($id){

}
</script>