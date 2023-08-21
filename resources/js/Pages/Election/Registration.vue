<template>
  <Notivue v-slot="item">
    <Notifications :item="item" :theme="materialTheme"/>
  </Notivue>
  <div class="min-h-screen flex flex-col items-center pt-10">
    <div class="bg-gray-100 w-full">
      <div class="items-center justify-center flex mb-5">
        <HimatifThirdLogo />
      </div>
      <div class="relative sm:py-16">
        <div aria-hidden="true" class="hidden sm:block">
          <div class="absolute inset-y-0 left-0 w-1/2 bg-slate-700 rounded-r-3xl" />
          <svg class="absolute top-8 left-1/2 -ml-3" width="404" height="392" fill="none" viewBox="0 0 404 392">
            <defs>
              <pattern id="8228f071-bcee-4ec8-905a-2a059a2cc4fb" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor"  />
              </pattern>
            </defs>
            <rect width="404" height="392" fill="url(#8228f071-bcee-4ec8-905a-2a059a2cc4fb)" />
          </svg>
        </div>
        <div class="mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:max-w-7xl lg:px-8">
          <div class="relative rounded-2xl px-6 py-10 bg-accent overflow-hidden shadow-xl sm:px-12 sm:py-20">
            <div aria-hidden="true" class="absolute inset-0 -mt-72 sm:-mt-32 md:mt-0">
              <svg class="absolute inset-0 h-full w-full" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 1463 360">
                <path class="text-slate-300 text-opacity-40" fill="currentColor" d="M-82.673 72l1761.849 472.086-134.327 501.315-1761.85-472.086z" />
                <path class="text-slate-700 text-opacity-40" fill="currentColor" d="M-217.088 544.086L1544.761 72l134.327 501.316-1761.849 472.086z" />
              </svg>
            </div>
            <div class="relative">
              <div class="sm:text-center">
                <h2 class="text-3xl font-extrabold text-white tracking-tight sm:text-4xl">Get Verified Link</h2>
                <p class="mt-6 mx-auto max-w-2xl text-lg text-white">Input your email, then we will send verified vote link to your email </p>
              </div>
              <form @submit.prevent="submit" class="mt-12 sm:mx-auto sm:max-w-lg sm:flex">
                <div class="min-w-0 flex-1">
                  <label for="cta-email" class="sr-only">Email address</label>
                  <input id="cta-email" v-model="form.email"  class="block w-full border border-transparent rounded-md px-5 py-3 text-base text-gray-900 placeholder-gray-500 shadow-sm focus:outline-none focus:border-transparent focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600" placeholder="you@widyatama.ac.id" />
                  <InputError :message="form.errors.email" />
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-3">
                  <button type="submit" class="block w-full rounded-md border border-transparent px-5 py-3 bg-slate-700 text-base font-medium text-white shadow hover:bg-slate-800 sm:px-10">Get Link</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import HimatifThirdLogo from "@/Assets/HimatifThirdLogo.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import {materialTheme, Notifications, Notivue, usePush} from "notivue";

const form = useForm({
  //utilize notivue
  email : null,
})

const push = usePush();

function submit(){
  form.post(route('election.storeEmail', usePage().props.election.selected), {
    onSuccess: () => {
      form.reset();
      push.success({
        message: 'Signed Url has been sent to your email',
        duration: 10000
      })
    }
  })
}

</script>