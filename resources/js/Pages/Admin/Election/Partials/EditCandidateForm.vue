<template>
  <section>
    <div class="mt-10 sm:mt-0">
      <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
          <div class="px-4 sm:px-0">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Candidate Profile</h3>
            <p class="mt-1 text-sm text-gray-600">Fill the input field, then saved to update.</p>
          </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">
          <form @submit.prevent="update" method="POST">
            <div class="shadow overflow-hidden sm:rounded-md">
              <div class="px-4 py-5 bg-white sm:p-6">
                <div class="grid grid-cols-6 gap-6">
                  <div class="col-span-6 sm:col-span-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" v-model="form.name"
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                    <InputError :message="form.errors.name"/>
                  </div>

                  <div class="col-span-6 sm:col-span-4">
                    <label for="vision" class="block text-sm font-medium text-gray-700">Vision</label>
                    <textarea rows="3" type="text" name="vision" id="vision" v-model="form.vision"
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                    <InputError :message="form.errors.vision"/>
                  </div>

                  <div class="col-span-6 sm:col-span-4">
                    <label for="mission" class="block text-sm font-medium text-gray-700">Mission</label>
                    <textarea rows="3" type="text" name="mission" id="mission" v-model="form.mission"
                              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                    <InputError :message="form.errors.mission"/>
                  </div>

                  <div class="col-span-6 sm:col-span-4">
                    <label for="vision" class="block text-sm font-medium text-gray-700">Number</label>
                    <input  type="number" name="number" id="number" v-model="form.number"
                              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block max-w-xs shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                    <InputError :message="form.errors.number"/>
                  </div>

                </div>
              </div>
              <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 ">
                <PrimaryButton type="submit" v-show="form.isDirty">
                  Save
                </PrimaryButton>
                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                  <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>
<script setup>
import InputError from "@/Components/InputError.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
const page = usePage();
const props = defineProps({
  candidate : {
    required : true
  }
})
const form = useForm({
  name : props.candidate.name,
  number : props.candidate.number,
  vision : props.candidate.vision,
  mission: props.candidate.mission
})

function update (){
  form.patch(route('admin.vote-system.candidate.update', {
    'id' : page.props.admin.election.selected.id,
    'candidateId' : props.candidate.id
  }), {
    onSuccess: () => {}
  });
}
</script>