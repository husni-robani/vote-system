<template>
  <section>
    <ul class="flex space-x-2">
      <li v-for="gen in $page.props.admin.election.selected.generations" :key="gen.id">
        <span
            class="inline-flex rounded-md items-center py-0.5 pl-2.5 pr-1 text-sm font-medium bg-gray-200 text-gray-700">
          {{gen.year}}
          <button type="button" @click.prevent="confirmUserDeletion(gen.id)"
            class="flex-shrink-0 ml-0.5 h-4 w-4 rounded-full inline-flex items-center justify-center text-indigo-400 hover:bg-red-200 hover:text-red-500 focus:outline-none focus:bg-indigo-500 focus:text-white">
            <span class="sr-only">Remove year option</span>
            <svg class="h-2 w-2" stroke="gray" fill="none" viewBox="0 0 8 8">
              <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7"/>
            </svg>
          </button>
        </span>
      </li>
    </ul>
    <Modal :show="confirmingUserDeletion" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900">
          Are you sure you want to delete {{$page.props.admin.election.selected.title}} Election
        </h2>

        <p class="mt-1 text-sm text-gray-600">
          Once this election is deleted, all of its resources and data will be permanently deleted.
        </p>

        <div class="mt-6 flex justify-end">
          <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

          <DangerButton
              class="ml-3"
              @click.prevent="destroy(selectedGen)"
          >
            Delete
          </DangerButton>
        </div>
      </div>
    </Modal>
  </section>
</template>
<script setup>
import {router, usePage} from "@inertiajs/vue3";
import {ref} from "vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
const page = ['name'];
const confirmingUserDeletion = ref(false);

const confirmUserDeletion = ($id) => {
  selectedGen.value = $id
  confirmingUserDeletion.value = true;
};

const selectedGen = ref();

const closeModal = () => {
  confirmingUserDeletion.value = false;
};
function destroy($id){
  router.visit(route('admin.vote-system.delete.gen', {'id': usePage().props.admin.election.selected.id}), {
    method: "delete",
    data: {
      'genId' : $id
    }
  })
}
</script>