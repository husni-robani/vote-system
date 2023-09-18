<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <TransitionRoot as="template" :show="open">
    <Dialog as="div" class="fixed inset-0 overflow-hidden" @close="$emit('toggle')">
      <div class="absolute inset-0 overflow-hidden">
        <TransitionChild as="template" enter="ease-in-out duration-500" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-500" leave-from="opacity-100" leave-to="opacity-0">
          <DialogOverlay class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
        </TransitionChild>

        <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10 sm:pl-16">
          <TransitionChild as="template" enter="transform transition ease-in-out duration-500 sm:duration-700" enter-from="translate-x-full" enter-to="translate-x-0" leave="transform transition ease-in-out duration-500 sm:duration-700" leave-from="translate-x-0" leave-to="translate-x-full">
            <div class="pointer-events-auto w-screen max-w-2xl">
              <div class="flex h-full flex-col overflow-y-scroll bg-white py-6 shadow-xl">
                <div class="px-4 sm:px-6">
                  <div class="flex items-center justify-between pb-3 border-b-2 border-gray-300">
                    <div>
                      <DialogTitle class="text-2xl font-extrabold text-gray-900"> {{candidate.name}} </DialogTitle>
                      <p class="text-lg font-extrabold text-gray-400">{{candidate.number}}</p>
                    </div>
                    <div class="ml-3 flex h-7 items-center">
                      <button type="button" class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" @click="$emit('toggle')">
                        <span class="sr-only">Close panel</span>
                        <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                      </button>
                    </div>
                  </div>
                </div>
                <div class="relative mt-6 flex-1 px-4 sm:px-6">
                  <!-- Replace with your content -->
                  <div class="absolute inset-0 px-6 sm:px-10">
                    <div class="h-full flex-col space-y-4" aria-hidden="true">
                      <div class="flex-col space-y-2">
                        <p class="text-gray-400 font-bold">Vision</p>
                        <p>{{candidate.vision}}</p>
                      </div>
                      <div class="flex-col">
                        <p class="text-gray-400 font-bold">Mission</p>
                        <nl2br :text="candidate.mission" class="-mt-4 font-thin"/>
                      </div>
                      <div class="flex-col">
                        <p class="text-gray-400 font-bold">Voters</p>
                        <p>{{candidate.voters.length}}</p>
                      </div>
                    </div>
                  </div>
                  <!-- /End replace -->
                </div>
              </div>
            </div>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import { Dialog, DialogOverlay, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import {XMarkIcon} from "@heroicons/vue/24/outline";
import Nl2br from "vue3-nl2br/src/nl2br.js";

const props = defineProps({
  open : {
    required : true
  },
  candidate: {
    required: true
  },
  gens: {
    required : true
  }
})

</script>