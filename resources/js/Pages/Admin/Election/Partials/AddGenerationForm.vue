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
        <div
            class="mt-5 md:mt-0 md:col-span-2 bg-white rounded-lg divide-y-2 divide-gray-black py-6 px-4 sm:rounded-md overflow-hidden shadow">
          <form @submit.prevent="update" method="POST" class="mb-4">
            <div class="grid grid-cols-6 gap-6">
              <div class="col-span-6 sm:col-span-4">
                <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                <div class="flex space-x-4">
                  <input type="text" name="year" id="year" v-model="form.year"
                         class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block max-w-md shadow-sm sm:text-sm border-gray-300 rounded-md"
                         placeholder="yyyy"
                  />
                  <PrimaryButton type="submit" v-show="form.isDirty">
                    Add
                  </PrimaryButton>
                  <Transition
                      enter-active-class="transition ease-in-out"
                      enter-from-class="opacity-0"
                      leave-active-class="transition ease-in-out"
                      leave-to-class="opacity-0"
                  >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Added.</p>
                  </Transition>

                </div>
                <InputError :message="form.errors.year"/>
              </div>
              <div class="flex items-center"></div>
            </div>
          </form>
          <div class="pt-4 space-y-4">
            <p class="font-medium text-gray-500">Available Year</p>
            <AvailableYearList/>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script setup>
import InputError from "@/Components/InputError.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AvailableYearList from "@/Pages/Admin/Election/Partials/AvailableYearList.vue";

const page = usePage();
const form = useForm({
  year: null,
})

function update() {
  form.post(route('admin.vote-system.update.gen', {'id': page.props.admin.election.selected.id}), {
    onSuccess: () => {
      form.reset()
    }
  });
}
</script>