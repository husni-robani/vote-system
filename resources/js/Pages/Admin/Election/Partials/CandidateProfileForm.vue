<template>
  <section>
    <div class="mt-10 sm:mt-0">
      <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
          <div class="px-4 sm:px-0">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Election Profile</h3>
            <p class="mt-1 text-sm text-gray-600">Fill the input field, then saved to update.</p>
          </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">
          <form @submit.prevent="update" method="POST">
            <div class="shadow overflow-hidden sm:rounded-md">
              <div class="px-4 py-5 bg-white sm:p-6">
                <div class="grid grid-cols-6 gap-6">
                  <div class="col-span-6 sm:col-span-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" v-model="form.title"
                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                    <InputError :message="form.errors.title"/>
                  </div>

                  <div class="col-span-6 sm:col-span-3">
                    <label for="active" class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="active" name="status" autocomplete="country-name" v-model="form.active"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                      <option :value="1">Active</option>
                      <option :value="0">InActive</option>
                    </select>
                    <InputError :message="form.errors.active"/>
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
const form = useForm({
  title : page.props.admin.election.selected.title,
  active: page.props.admin.election.selected.active
})

function update (){
  form.patch(route('admin.vote-system.update.profile', {'id' : page.props.admin.election.selected.id}));
}
</script>