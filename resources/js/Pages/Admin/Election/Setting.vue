<template>
  <AdminElectionLayout>
    <Notivue v-slot="item">
      <Notifications :item="item" :theme="materialTheme"/>
    </Notivue>
    <template #header>{{$page.props.admin.election.selected.title}} Setting</template>
    <div class="space-y-6">
      <ElectionProfileForm/>
      <AddGenerationForm/>
      <ResultLink :link="resultLink"/>
      <DeleteElectionForm/>
    </div>
    {{$page.props.notifications.failed}}
  </AdminElectionLayout>
</template>

<script setup>

import AdminElectionLayout from "@/Layouts/Admin/AdminElectionLayout.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import ElectionProfileForm from "@/Pages/Admin/Election/Partials/ElectionProfileForm.vue";
import DeleteElectionForm from "@/Pages/Admin/Election/Partials/DeleteElectionForm.vue";
import AddGenerationForm from "@/Pages/Admin/Election/Partials/AddGenerationForm.vue";
import {materialTheme, Notifications, Notivue, usePush} from "notivue";
import {onMounted} from "vue";
import ResultLink from "@/Pages/Admin/Election/Partials/ResultLink.vue";
const props = defineProps({
  resultLink: {
    required: true
  }
})
const form = useForm({
  title : null,
  status: null
})
</script>