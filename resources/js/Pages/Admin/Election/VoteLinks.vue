<template>
  <AdminElectionLayout>
    <template #header>Vote-Links</template>

    <div class="px-4 sm:px-6 lg:px-8">
      <div class="mt-8 flex flex-col">
        <div class="-my-2 -mx-4 sm:-mx-6 lg:-mx-8">
          <div class="inline-block min-w-full py-2 align-middle">
            <div class="shadow-sm ring-1 ring-black ring-opacity-5">
              <table class="min-w-full border-separate" style="border-spacing: 0">
                <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 bg-opacity-75 py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter sm:pl-6 lg:pl-8">Email</th>
                  <th scope="col" class="sticky top-0 z-10 hidden border-b border-gray-300 bg-gray-50 bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter sm:table-cell">Token</th>
                  <th scope="col" class="sticky top-0 z-10 hidden border-b border-gray-300 bg-gray-50 bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter sm:table-cell">Created</th>
                  <th scope="col" class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50 bg-opacity-75 py-3.5 pr-4 pl-3 backdrop-blur backdrop-filter sm:pr-6 lg:pr-8">
                    <span class="sr-only">Edit</span>
                  </th>
                </tr>
                </thead>
                <tbody class="bg-white">
                <tr v-for="link in links" :key="link.email" >
                  <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8 border-b border-gray-200">{{ link.email }}</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 hidden sm:table-cell border-b border-gray-200">{{ link.token }}</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 hidden sm:table-cell border-b border-gray-200">{{ link.created_at }}</td>
                  <td class="relative whitespace-nowrap py-4 pr-4 pl-3 text-right text-sm font-medium sm:pr-6 lg:pr-8 border-b border-gray-200">
                    <PrimaryButton @click="copy(link.link)"
                    >Copy link<span class="sr-only">, {{ link.email }}</span></PrimaryButton
                    >
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminElectionLayout>
</template>
<script setup>
import AdminElectionLayout from "@/Layouts/Admin/AdminElectionLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
const people = [
  { name: 'Lindsay Walton', title: 'Front-end Developer', email: 'lindsay.walton@example.com', role: 'Member' },
  // More people...
]
const props = defineProps({
  links : {
    required : true
  }
})
function copy(link){
  navigator.clipboard.writeText(link)
}
</script>