<template>
  <!-- component -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

  <section style="font-family: Montserrat">
    <Modal :show="confirmingUserDeletion" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900">
          Are you sure you want to delete Election
        </h2>
        <p class="mt-1 text-sm text-gray-600">
          Once this election is deleted, all of its resources and data will be permanently deleted.
        </p>

        <div class="mt-6 flex justify-end">
          <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

          <DangerButton
              class="ml-3"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
              @click="destroy"
          >
            Delete
          </DangerButton>
        </div>
      </div>
    </Modal>

    <section class="mx-auto px-8 py-6">
      <div class="flex justify-between ">
        <span class="text-gray-400 text-xl font-bold rounded-full">
          {{number}}
        </span>
        <span>
          <DropdownTailwinUi>
            <template #menu>
              <MenuItem v-slot="{ active }">
                <Link :href="route('admin.vote-system.candidate.edit', {'id' : $page.props.admin.election.selected.id, 'candidateId' : props.id})" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Detail</Link>
              </MenuItem>
              <MenuItem v-slot="{ active }">
                <button  type="button" @click="confirmingUserDeletion = true" class="hover:bg-gray-50 w-full block px-4 py-2 text-sm text-red-500 text-left">Delete</button>
              </MenuItem>
            </template>
          </DropdownTailwinUi>
        </span>
      </div>
      <div class="mt-6 w-fit mx-auto">
        <img :src="props.photo" class="object-cover hidden lg:block w-64 h-64 rounded-lg" alt="profile picture" srcset="">
      </div>
      <div class="flex-col h-full justify-between">
        <div class="mt-8 ">
          <h2 class="text-white font-bold text-2xl tracking-wide text-left">{{name}}</h2>
        </div>
        <div>
          <div class="h-1 w-full bg-white mt-8 rounded-full">
            <div :class="test" ></div>
          </div>
          <div class="mt-3 text-white text-sm">
            <span>{{candidateVoters + ' / ' + totalVoter}}</span>
          </div>
        </div>
      </div>

    </section>
  </section>
</template>

<script setup>
import {Link, router, useForm, usePage} from "@inertiajs/vue3";
import DropdownTailwinUi from "@/Components/DropdownTailwinUi.vue";
import {MenuItem} from "@headlessui/vue";
import {onMounted, ref} from "vue";
import {usePush} from "notivue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import {urlWithoutHash} from "@inertiajs/core";

const props = defineProps({
  'name' : {
    required : true
  },
  'number' : {
    required : true
  },
  'photo' : {
    required: false
  },
  'totalVoter' : {
    required: true
  },
  'id' : {
    required: true
  },
  'candidateVoters' : {
    required: true,
  },
})
const test = ref(barClass().toString())
const form = useForm({});
const push = usePush();
const confirmingUserDeletion = ref(false);
const closeModal = () => {
  confirmingUserDeletion.value = false;

  form.reset();
};

onMounted(() => {
  const page = usePage();
  const notifications = usePage().props.notifications
  if (notifications.success !== null){
    push.success({
      message: notifications.success
    })
  }
})
function destroy(){
  useForm({
    'candidateId' : props.id
  }).delete(route('admin.vote-system.candidate.delete', {
    'id' : usePage().props.admin.election.selected.id,
  }), {
    preserveScroll: true,
    onSuccess: () => {
      confirmingUserDeletion.value = false
    }
  })
}

function voterPercentage(){
  if (props.candidateVoters === 0){
    return 0;
  }
  return (props.candidateVoters/props.totalVoter) * 100;
}

function barClass(){
  return "h-1 rounded-full bg-yellow-500 " + "w-[".concat(voterPercentage(), "%]")
}

</script>