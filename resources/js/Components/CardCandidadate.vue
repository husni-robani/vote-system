<template>
  <section>
    <div  class="flex flex-row md:flex-col space-x-4 md:space-x-0  border border-gray-300 shadow-xl rounded-lg overflow-hidden">
      <div class="h-52 w-48 md:h-72 md:w-full overflow-hidden">
        <img :src="photo" class="object-cover mx-auto h-full w-full" alt="candidate">
      </div>
      <div class="flex flex-col mx-auto justify-center mb-4">
        <p class="font-extrabold text-lg mb-0 md:text-center text-black line-clamp-1">{{name}}</p>
        <p class="font-extrabold text-md text-slate-400 md:text-center">{{number}}</p>
      </div>
      <div class="mx-auto px-">
        <div class="h-2 w-full bg-gray-200 ">
          <div class="h-2 rounded-full bg-emerald-400" :style="barPercentage(candidateVoters)" ></div>
        </div>
      </div>
    </div>

  </section>
</template>

<script setup>

const props = defineProps({
  name: {
    required: true
  },
  number: {
    required: true
  },
  electionVoters: {
    required: true
  },
  candidateVoters: {
    required: true
  },
  photo: {
    required: true
  }

})
function barPercentage(candidateVoters){
  return "width: " + Math.round(candidateVoters/props.electionVoters*100).toString() + "%"
}
</script>