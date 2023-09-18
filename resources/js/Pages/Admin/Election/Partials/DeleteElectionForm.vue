<script setup>
import DangerButton from '@/Components/DangerButton.vue';

import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

import {useForm, usePage} from '@inertiajs/vue3';
import { ref } from 'vue';
import {usePush} from "notivue";

const confirmingUserDeletion = ref(false);

const form = useForm({});

const confirmUserDeletion = () => {
  confirmingUserDeletion.value = true;
};
const push = usePush();

const deleteUser = () => {
  form.delete(route('admin.vote-system.delete', {'id' : usePage().props.admin.election.selected.id}), {
    preserveScroll: true,
    onSuccess: () => {
      closeModal()
      push.success({
        message : 'Election Delete Success'
      })
    },
  });
};

const closeModal = () => {
  confirmingUserDeletion.value = false;

  form.reset();
};
</script>

<template>
  <section class="space-y-6">
    <header>
      <h2 class="text-lg font-medium text-gray-900">Delete Account</h2>

      <p class="mt-1 text-sm text-gray-600">
        Once this election is deleted, all of its resources and data will be permanently deleted.
      </p>
    </header>

    <DangerButton @click="confirmUserDeletion">Delete Election</DangerButton>

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
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
              @click="deleteUser"
          >
            Delete
          </DangerButton>
        </div>
      </div>
    </Modal>
  </section>
</template>
