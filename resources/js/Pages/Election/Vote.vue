<template>
  <ElectionLayout>
    <div class="flex flex-col max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2">
      <!----header ---->
      <div class="mx-auto">
        <HimatifFifthLogo class="mx-auto w-32"/>

      </div>

      <!----Form--->
      <div class="mx-auto w-full">
        <form @submit.prevent="submit" class=" space-y-10"  method="POST">
          <!---- Input Name, NPM, Gen ----->
          <div class="rounded-md shadow-sm space-y-4 max-w-xl mx-auto">
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
              <div class="mt-1">
                <input type="text" v-model="form.name" name="name" id="name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="" />
                <InputError :message="form.errors.name"/>
              </div>
            </div>
            <div>
              <label for="npm" class="block text-sm font-medium text-gray-700">NPM</label>
              <div class="mt-1">
                <input type="text" name="npm" v-model="form.npm" id="npm" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="" />
                <InputError :message="form.errors.npm"/>
              </div>
            </div>
            <div>
              <Listbox as="div" v-model="form.generation_id">
                <ListboxLabel class="block text-sm font-medium text-gray-700">Your Generation</ListboxLabel>
                <div class="mt-1 relative">
                  <ListboxButton class="bg-white relative w-full border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <span class="block truncate">{{ form.generation_id.year }}</span>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
          <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
        </span>
                  </ListboxButton>
                  <InputError :message="form.errors.generation_id"/>

                  <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                    <ListboxOptions class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                      <ListboxOption as="template" v-for="gen in generations" :key="gen.id" :value="gen" v-slot="{ active, selected }">
                        <li :class="[active ? 'text-white bg-indigo-600' : 'text-gray-900', 'cursor-default select-none relative py-2 pl-3 pr-9']">
              <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">
                {{ gen.year }}
              </span>

                          <span v-if="selected" :class="[active ? 'text-white' : 'text-indigo-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
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
          <div>
            <RadioGroup v-model="form.candidate_id">
              <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-3 sm:gap-x-4 justify-items-center">
                <RadioGroupOption as="template" v-for="candidate in candidates" :key="candidate.id" :value="candidate.id" v-slot="{ checked, active }">
                  <div :class="[checked ? 'border-transparent' : 'border-gray-300', active ? 'border-indigo-500 ring-2 ring-indigo-500' : '', 'relative bg-white border rounded-lg shadow-sm flex cursor-pointer focus:outline-none']">
                    <div class="flex-1 flex">
                      <div class="flex flex-col">
                        <img src="../../Assets/IWIWYJ_1B.webp" alt="Candidate Name"
                             class="w-full mx-auto h-full object-center object-cover rounded-t-lg"/>
                        <RadioGroupLabel as="span" class="block mx-auto text-3xl font-medium text-gray-900">
                          {{candidate.number}}
                        </RadioGroupLabel>
                        <RadioGroupLabel as="span" class="block mx-auto text-sm text-gray-500">
                          {{candidate.name}}
                        </RadioGroupLabel>
                      </div>
                    </div>
                    <!---- <CheckIcon :class="[!checked ? 'invisible' : '', 'h-5 w-5 text-indigo-600']" aria-hidden="true" /> ---->
                    <div :class="[active ? 'border' : 'border-2', checked ? 'border-indigo-500' : 'border-transparent', 'absolute -inset-px rounded-lg pointer-events-none']" aria-hidden="true" />
                  </div>
                </RadioGroupOption>
              </div>
            </RadioGroup>
          </div>


          <div class="">
            <button type="submit"  class="group relative mx-auto w-full max-w-xl flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-slate-800 hover:bg-slate-950">
              Submit
            </button>
          </div>
        </form>
      </div>
    </div>
  </ElectionLayout>
</template>
<script setup>
import ElectionLayout from "@/Layouts/ElectionLayout.vue";
import HimatifFifthLogo from "@/Assets/HimatifFifthLogo.vue";
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
import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/24/solid'
import {useForm, usePage} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
const form = useForm({
  name: null,
  npm : null,
  candidate_id : null,
  generation_id : props.generations[0]
})
const page = usePage();

const props = defineProps({
  candidates : {
    required : true
  },
  generations : {
    required : true
  }
})

function submit(){
  form
      .transform((data) => ({
        ...data,
        generation_id: data.generation_id.id,
      }))
      .post(route('election.store', {
    'title': page.props.election.selected,
    'token': page.props.election.token
  }))
}
</script>





<!--          <div>-->
<!--            <div class="max-w-2xl mx-auto px-4  sm:px-6 lg:max-w-7xl lg:px-8">-->
<!--              <div class="mt-8 grid justify-items-center grid-cols-1   gap-y-12 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-3 xl:gap-x-8">-->
<!--                <div v-for="product in products" :key="product.id" class="bg-white p-1 rounded-lg">-->
<!--                  <input id="voted" name="voted" type="radio" :value="'voted'" class="peer hidden"/>-->
<!--                  <div class="relative">-->
<!--                    <div class="relative w-full h-72 rounded-lg overflow-hidden">-->
<!--                      <img :src="product.imageSrc" :alt="product.imageAlt"-->
<!--                           class="w-full h-full object-center object-cover"/>-->
<!--                    </div>-->
<!--                    <div class="grid relative mt-4 items-center justify-items-center">-->
<!--                      <p class="mt-1 text-2xl font-extrabold text-gray-900">1</p>-->
<!--                      <h3 class="text-sm font-medium text-gray-500">Husni Robani</h3>-->
<!--                    </div>-->
<!--                    <div-->
<!--                        class="absolute top-0 inset-x-0 h-72 rounded-lg p-4 flex items-end justify-end overflow-hidden">-->
<!--                      <div aria-hidden="true"-->
<!--                           class="absolute inset-x-0 bottom-0 h-36 bg-gradient-to-t from-black opacity-50"/>-->
<!--                    </div>-->
<!--                  </div>-->
<!--                  <div class="mt-6">-->
<!--                    <a :href="product.href"-->
<!--                       class="relative flex bg-gray-100 border border-transparent rounded-md py-2 px-8 items-center justify-center text-sm font-medium text-gray-900 hover:bg-gray-200"-->
<!--                    >Add to bag<span class="sr-only">, {{ product.name }}</span></a-->
<!--                    >-->
<!--                  </div>-->
<!--                </div>-->
<!--              </div>-->
<!--            </div>-->

<!--          </div>-->

<!----Button---->
