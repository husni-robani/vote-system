<template>
  <section>
    <div class="mt-10 sm:mt-0">
      <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
          <div class="px-4 sm:px-0">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Result Page Link</h3>
            <p class="mt-1 text-sm text-gray-600">That link navigate to page that show the result</p>
          </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2 bg-white rounded-lg divide-y-2 divide-gray-black py-6 px-4 sm:rounded-md overflow-hidden shadow">
          <div  class="mb-4">
            <div class="grid grid-cols-6 gap-6">
              <div class="col-span-6 sm:col-span-4">
                <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                <div class="flex flex-col space-y-4">
                  <input type="text" name="link" id="link"  disabled :value="link" ref="link"
                         class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                  />
                  <div class="flex space-x-4 justify-end">
                    <PrimaryButton @click="copy">
                      Copy
                    </PrimaryButton>
                    <a :href="link" target="_blank" class="px-4 py-2 border-2 border-slate-700 rounded-md hover:bg-slate-700 hover:text-white">
                      Visit
                    </a>
                  </div>
                </div>
              </div>
              <div class="flex items-center"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script setup>
import { usePage, Link} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {ref} from "vue";

const page = usePage();


const props = defineProps({
  link: {
    required: true
  }
})

const test = ref(props.link)

function copy(){
  navigator.clipboard.writeText(props.link)
}


</script>