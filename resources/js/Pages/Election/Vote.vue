<script setup>
import ElectionLayout from "@/Layouts/ElectionLayout.vue";
import {
  Listbox,
  ListboxButton,
  ListboxLabel,
  ListboxOption,
  ListboxOptions,
  RadioGroup,
  RadioGroupLabel,
  RadioGroupOption
} from '@headlessui/vue'
import { CheckIcon, ChevronUpDownIcon, ChevronRightIcon, ChevronLeftIcon } from '@heroicons/vue/24/solid'
import {useForm, usePage} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import {ref} from "vue";
import Finish from "@/Pages/Election/Finish.vue";
const form = useForm({
  name: null,
  npm : null,
  candidate_id : null,
  generation_id : props.generations[0]
})
const page = usePage();
const formStep = ref(1);
const props = defineProps({
  candidates : {
    required : true
  },
  generations : {
    required : true
  },
  email: {
    required: true
  }
})

function nextStep(){
  form
      .transform((data) => ({
        ...data,
        generation_id: data.generation_id.id,
      }))
      .post(route('election.first-step', {
        'id': page.props.election.selected,
        'token': page.props.election.token
      }), {
        onSuccess : () => {
          formStep.value++;
        }
      })
}

function prevStep(){
  formStep.value--;
}

function submit(){
  form
      .transform((data) => ({
        ...data,
        generation_id: data.generation_id.id,
      }))
      .post(route('election.store', {
        'id': page.props.election.selected,
        'token': page.props.election.token
      }), {
        onSuccess: () => {
          formStep.value = 100
        }
      })
}
</script>

<template>
  <ElectionLayout>
    <div class="min-h-full">
      <div class="max-w-7xl mx-auto px-4">
        <h4 class="sr-only">Steps</h4>
        <div class="mt-6" aria-hidden="true">
          <div class="bg-gray-200 rounded-full overflow-hidden">
            <div :class="[formStep === 1 ? 'w-0' : formStep === 2 ? 'w-1/2' : 'w-full', 'h-2 rounded-full bg-accent']"/>
          </div>
          <div class="hidden sm:grid grid-cols-3 text-sm font-medium text-gray-600 mt-6">
            <div :class="[formStep > 1 ? 'text-accent': '']">Personal Information</div>
            <div :class="[formStep > 2 ? 'text-accent' : '', 'text-center']">Vote Candidate</div>
            <div :class="[formStep > 3 ? 'text-accent' : '', 'text-right']">Finish</div>
          </div>
        </div>
      </div>

      <div class="flex flex-col max-w-7xl mt-10 mx-auto px-4 sm:px-6 lg:px-8 py-2 space-y-10">
        <!----header ---->
        <div class="mx-auto">
          <p v-show="formStep === 1" class="text-4xl font-extrabold">Complete Your Profile</p>
          <p v-show="formStep === 2" class="text-4xl font-extrabold">Cast Your Vote: Have Your Say</p>
        </div>

        <!----Form--->
        <div class="mx-auto w-full">
          <form @submit.prevent="submit" class="min-h-full space-y-10"  method="POST">
            <!---- Input Name, NPM, Gen ----->
            <div v-show="formStep === 1" class="rounded-md shadow-sm space-y-4 max-w-2xl mx-auto">
              <div>
                <label for="email" class="block text-sm font-medium text-gray-400">Email</label>
                <div class="mt-1 text-gray-400">
                  <input type="email" name="email" id="email" :value="email" class="shadow-sm focus:ring-accent focus:border-accent block w-full sm:text-sm border-gray-300 rounded-md" disabled/>
                </div>
              </div>
              <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <div class="mt-1">
                  <input type="text" v-model="form.name" name="name" id="name" class="shadow-sm focus:ring-accent focus:border-accent block w-full sm:text-sm border-gray-300 rounded-md" placeholder="" />
                  <InputError :message="form.errors.name"/>
                </div>
              </div>
              <div>
                <label for="npm" class="block text-sm font-medium text-gray-700">NPM</label>
                <div class="mt-1">
                  <input type="text" name="npm" v-model="form.npm" id="npm" class="shadow-sm focus:ring-accent focus:border-accent block w-full sm:text-sm border-gray-300 rounded-md" placeholder="" />
                  <InputError :message="form.errors.npm"/>
                </div>
              </div>
              <div>
                <Listbox as="div" v-model="form.generation_id">
                  <ListboxLabel class="block text-sm font-medium text-gray-700">Your Generation</ListboxLabel>
                  <div class="mt-1 relative">
                    <ListboxButton class="bg-white relative w-full border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-accent focus:border-accent sm:text-sm">
                      <span class="block truncate">{{ form.generation_id.year }}</span>
                      <span class="absolute inset-y-0 right-0 flex items-center pr-2' pointer-events-none">
                        <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                      </span>
                    </ListboxButton>
                    <InputError :message="form.errors.generation_id"/>

                    <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                      <ListboxOptions class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                        <ListboxOption as="template" v-for="gen in generations" :key="gen.id" :value="gen" v-slot="{ active, selected }">
                          <li :class="[active ? 'text-white bg-accent_old' : 'text-gray-900', 'cursor-default select-none relative py-2 pl-3 pr-9']">
                            <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">
                              {{ gen.year }}
                            </span>
                            <span v-if="selected" :class="[active ? 'text-white' : 'text-accent', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                              <CheckIcon class="h-5 w-5" aria-hidden="true" />
                            </span>
                          </li>
                        </ListboxOption>
                      </ListboxOptions>
                    </transition>
                  </div>
                </Listbox>
              </div>
            </div>

            <!---- Select Candidate Form ---->
            <div v-show="formStep === 2" class="">
              <RadioGroup v-model="form.candidate_id">
                <div class="grid grid-cols-2 justify-around gap-y-6 gap-x-8 max-w-lg sm:w-full sm:grid-cols-3 sm:gap-x-12 sm:max-w-4xl mx-auto justify-items-center">
                  <RadioGroupOption as="template" v-for="candidate in candidates" :key="candidate.id" :value="candidate.id" v-slot="{ checked, active }">
                    <div :class="[checked ? 'border-4 border-accent' : 'border-gray-300', active ? 'ring-2 ring-accent' : '', 'relative bg-white border rounded-lg shadow-lg flex cursor-pointer focus:outline-none']">
                      <div class="flex-1 flex">
                        <div class="flex flex-col ">
                          <img :src="candidate.photo" alt="Candidate Name"
                               class="w-full mx-auto h-full object-center object-cover rounded-t-lg"/>
                          <RadioGroupLabel as="span" class="block mx-auto text-md md:text-lg font-bold text-center text-gray-900">
                            {{candidate.name}}
                          </RadioGroupLabel>
                          <RadioGroupLabel as="span" class="block mx-auto text-md text-gray-500 text-center">
                            {{candidate.number}}
                          </RadioGroupLabel>
                        </div>
                      </div>
                      <!---- <CheckIcon :class="[!checked ? 'invisible' : '', 'h-5 w-5 text-accent']" aria-hidden="true" /> ---->
                      <div :class="[active ? 'border' : 'border-2', checked ? 'border-accent' : 'border-transparent', 'absolute -inset-px rounded-lg pointer-events-none']" aria-hidden="true" />
                    </div>
                  </RadioGroupOption>
                </div>
              </RadioGroup>
            </div>


            <div class="flex flex-row-reverse max-w-xs sm:max-w-xl mx-auto">
              <button v-show="formStep === 1" type="button" @click="nextStep"  class="group relative max-w-xl items-center space-x-2 flex justify-center py-2 pl-4 pr-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-slate-950">
                Next
                <ChevronRightIcon class="w-4 text-white"/>
              </button>
              <div class="w-full flex justify-between items-center">
                <button v-show="formStep === 2" type="button" @click="prevStep"  class="group relative  max-w-xl items-center space-x-2 flex justify-center py-2 pr-4 pl-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-slate-950">
                  <ChevronLeftIcon class="w-4 text-white"/>
                  Prev
                </button>
                <button v-show="formStep === 2" type="submit" class="group relative  max-w-xl items-center space-x-2 flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-accent hover:bg-accent_old">
                  Send Vote
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div v-show="formStep === 100">
        <Finish/>
      </div>
    </div>
    <!--Steps-->
  </ElectionLayout>
</template>
