<template>
  <AdminElectionLayout>
    <template #header>Create Election</template>
    <div class="mt-10 sm:mt-0">
      <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
          <div class="px-4 sm:px-0">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Personal Information</h3>
            <p class="mt-1 text-sm text-gray-600">Use a permanent address where you can receive mail.</p>
          </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">
          <form @submit.prevent="submit" method="POST">
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
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="status" name="status" autocomplete="country-name" v-model="form.active"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                      <option :value="true">Active</option>
                      <option :value="false">InActive</option>
                    </select>
                    <InputError :message="form.errors.active"/>
                  </div>
                </div>
              </div>
              <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  Create
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AdminElectionLayout>
</template>

<script setup>
import AdminElectionLayout from "@/Layouts/Admin/AdminElectionLayout.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";

const form = useForm({
  title : null,
  active: null
})

function submit (){
  form.post(route('admin.vote-system.store', {id : usePage().props.admin.election.selected.id}))
}
</script>