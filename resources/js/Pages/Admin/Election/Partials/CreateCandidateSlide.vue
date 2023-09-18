<!--
  This example requires Tailwind CSS v2.0+

  This example requires some changes to your config:

  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
<template>
  <TransitionRoot as="template" :show="open">
    <Dialog as="div" class="fixed inset-0 overflow-hidden z-20" @close="$emit('toggle')">
      <div class="absolute inset-0 overflow-hidden">
        <TransitionChild as="template" enter="ease-in-out duration-500" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-500" leave-from="opacity-100" leave-to="opacity-0">
          <DialogOverlay class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
        </TransitionChild>

        <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10 sm:pl-16">
          <TransitionChild as="template" enter="transform transition ease-in-out duration-500 sm:duration-700" enter-from="translate-x-full" enter-to="translate-x-0" leave="transform transition ease-in-out duration-500 sm:duration-700" leave-from="translate-x-0" leave-to="translate-x-full">
            <div class="pointer-events-auto w-screen max-w-2xl">
              <form @submit.prevent="submit" class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                <div class="flex-1">
                  <!-- Header -->
                  <div class="bg-gray-50 px-4 py-6 sm:px-6">
                    <div class="flex items-start justify-between space-x-3">
                      <div class="space-y-1">
                        <DialogTitle class="text-lg font-medium text-gray-900"> New project </DialogTitle>
                        <p class="text-sm text-gray-500">Get started by filling in the information below to create your new project.</p>
                      </div>
                      <div class="flex h-7 items-center">
                        <button type="button" class="text-gray-400 hover:text-gray-500" @click="$emit('toggle')">
                          <span class="sr-only">Close panel</span>
                          <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                        </button>
                      </div>
                    </div>
                  </div>

                  <!-- Divider container -->
                  <div class="space-y-6 py-6 sm:space-y-0 sm:divide-y sm:divide-gray-200 sm:py-0">
                    <!-- Candidate Order Number  -->
                    <div class="space-y-1 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:space-y-0 sm:px-6 sm:py-5">
                      <div>
                        <label for="number" class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">Number</label>
                      </div>
                      <div class="sm:col-span-2">
                        <input v-model="form.number" type="number" name="number" id="number" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        <InputError :message="form.errors.number"/>
                      </div>
                    </div>
                    <!-- name -->
                    <div class="space-y-1 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:space-y-0 sm:px-6 sm:py-5">
                      <div>
                        <label for="name" class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">Name </label>
                      </div>
                      <div class="sm:col-span-2">
                        <input v-model="form.name" type="text" name="name" id="name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        <InputError :message="form.errors.name" />
                      </div>
                    </div>

                    <!-- Vision -->
                    <div class="space-y-1 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:space-y-0 sm:px-6 sm:py-5">
                      <div>
                        <label for="vision" class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">Vision</label>
                      </div>
                      <div class="sm:col-span-2">
                        <textarea v-model="form.vision" id="vision" name="vision" rows="3" class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        <InputError :message="form.errors.vision"/>
                      </div>
                    </div>

                    <!-- Mission -->
                    <div class="space-y-1 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:space-y-0 sm:px-6 sm:py-5">
                      <div>
                        <label for="mission" class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">mission</label>
                      </div>
                      <div class="sm:col-span-2">
                        <textarea id="mission" name="mission" v-model="form.mission" rows="3" class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        <InputError :message="form.errors.mission"/>
                      </div>
                    </div>

                    <!---- Photo ---->
                    <div class="space-y-1 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:space-y-0 sm:px-6 sm:py-5">
                      <div>
                        <label for="photo" class="block text-sm font-medium text-gray-900 sm:mt-px sm:pt-2">Photo</label>
                      </div>
                      <div class="sm:col-span-2">
                        <input @input="form.photo = $event.target.files[0]" type="file" id="photo"  name="photo" class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        <InputError :message="form.errors.photo"/>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Action buttons -->
                <div class="flex-shrink-0 border-t border-gray-200 px-4 py-5 sm:px-6">
                  <div class="flex justify-end space-x-3">
                    <DangerButton type="button"  @click="$emit('toggle')">Cancel</DangerButton>
                    <PrimaryButton type="submit">Create</PrimaryButton>
                  </div>
                </div>
              </form>
            </div>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import { Dialog, DialogOverlay, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { XMarkIcon } from '@heroicons/vue/24/outline'
import {useForm, usePage} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import {ref} from "vue";
import InputError from "@/Components/InputError.vue";
const props = defineProps({
  open : {
    required: true
  }
})

const form = useForm({
  number: null,
  name: null,
  vision: null,
  mission: null,
  photo: null
})

const emit = defineEmits(['toggle'])

function submit(){
  form.post(route('admin.vote-system.candidate.store', {'id':usePage().props.admin.election.selected.id}), {
    onSuccess: () => {
      form.reset();
      emit('toggle');
    }
  })
}
</script>