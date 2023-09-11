<template>
  <Notivue v-slot="item">
    <Notifications :item="item" :theme="materialTheme"/>
  </Notivue>
  <div>
    <TransitionRoot as="template" :show="sidebarOpen">
      <Dialog as="div" class="fixed inset-0 flex z-40 md:hidden bg-black" @close="sidebarOpen = false">
        <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
          <DialogOverlay class="fixed inset-0 bg-gray-600 bg-opacity-75" />
        </TransitionChild>
        <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="-translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="-translate-x-full">
          <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-white">
            <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
              <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="sidebarOpen = false">
                  <span class="sr-only">Close sidebar</span>
                  <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
                </button>
              </div>
            </TransitionChild>
            <div class="flex-shrink-0 flex items-center px-4">
              <p>HIMATIF-Election</p>
            </div>
            <div class="mt-5 flex-1 h-0 overflow-y-auto">
              <nav class="px-2 space-y-1">
                <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900', 'group flex items-center px-2 py-2 text-base font-medium rounded-md']">
                  <component :is="item.icon" :class="[item.current ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-4 flex-shrink-0 h-6 w-6']" aria-hidden="true" />
                  {{ item.name }}
                </a>
                <Link method="post" as="button" :href="route('logout')" class="group flex w-full items-center px-2 py-2 text-base text-red-500 hover:text-red-700 hover:bg-red-50 font-medium rounded-md">
                  <ArrowLeftOnRectangleIcon class="mr-3 flex-shrink-0 h-6 w-6 text-red-500 group-hover:text-red-700"/>
                  Logout
                </Link>
              </nav>
            </div>
          </div>
        </TransitionChild>
        <div class="flex-shrink-0 w-14" aria-hidden="true">
          <!-- Dummy element to force sidebar to shrink to fit close icon -->
        </div>
      </Dialog>
    </TransitionRoot>

    <!-- Static sidebar for desktop -->
    <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
      <!-- Sidebar component, swap this element with another sidebar if you like -->
      <div class="flex flex-col flex-grow border-r border-gray-200 pt-5 bg-white overflow-y-auto">
        <div class="flex items-center flex-shrink-0 px-4">
          <p class="text-2xl text-accent font-bold">HIMATIF-<span class="text-secondaryAccent">ELECTION</span></p>
        </div>
        <div class="mt-5 flex-grow flex flex-col">
          <nav class="flex-1 px-2 pb-4 space-y-1">
            <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']">
              <component :is="item.icon" :class="[item.current ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-3 flex-shrink-0 h-6 w-6']" aria-hidden="true" />
              {{ item.name }}
            </a>
            <Link method="post" as="button" :href="route('logout')" class="group w-full flex items-center px-2 py-2 text-base text-red-500 hover:text-red-700 hover:bg-red-50 font-medium rounded-md">
              <ArrowLeftOnRectangleIcon class="mr-3 flex-shrink-0 h-6 w-6 text-red-500 group-hover:text-red-700"/>
              Logout
            </Link>
          </nav>
        </div>
      </div>
    </div>
    <div class="md:pl-64 flex flex-col flex-1">
      <div class="sticky top-0 z-10 flex-shrink-0 flex h-16 bg-white shadow">
        <button type="button" class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden" @click="sidebarOpen = true">
          <span class="sr-only">Open sidebar</span>
          <Bars3Icon class="h-6 w-6" aria-hidden="true" />
        </button>
        <div class="flex-1 px-4 lg:px-24 flex justify-between">
          <div class="flex-1 flex">
          </div>
          <div class="ml-4 flex items-center md:ml-6 lg:space-x-4 space-x-6">
            <!---- Election Switch Dropdown ---->
            <Menu as="div" class="ml-3 relative">
              <div>
                <MenuButton class="max-w-xs bg-white flex items-center text-sm ">
                  <span class="sr-only">Open user menu</span>
                  <div class="flex items-center">
                    <p class="text-sm text-gray-500 px-1">{{$page.props.admin.election.selected.title}}</p>
                    <ChevronUpDownIcon class="h-4 w-4"/>
                  </div>
                </MenuButton>
              </div>
              <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                <MenuItems class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg pt-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                  <div>
                    <MenuItem>
                      <p class="block px-4 py-1 text-xs text-gray-500">Manage Election</p>
                    </MenuItem>
                    <MenuItem v-for="item in electionNavigation" :key="item.name" v-slot="{ active }">
                      <a :href="item.href" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">{{ item.name }}</a>
                    </MenuItem>
                  </div>
                  <div>
                    <MenuItem class="border-t  border-gray-200">
                      <p class="block px-4 py-1 text-xs text-gray-500">Switch Elections</p>
                    </MenuItem>
                    <MenuItem v-for="item in $page.props.admin.election.all" :key="item.title" v-slot="{ active }">
                      <form @submit.prevent="switchElection(item.id)" method="get">
                        <button  type="submit" :class="[item.id === $page.props.admin.election.selected.id ? 'bg-gray-200' : 'hover:bg-gray-50', 'w-full block px-4 py-2 text-sm text-gray-700 text-left']">{{ item.title }}</button>
                      </form>
                    </MenuItem>
                  </div>
                </MenuItems>
              </transition>
            </Menu>

          </div>
        </div>
      </div>

      <main class="flex-1">
        <div class="py-6">
          <div class="max-w-7xl mx-auto mb-10 px-4 sm:px-6 md:px-8">
            <h1 class="text-2xl font-semibold text-gray-900">
              <slot name="header"/>
            </h1>
          </div>
          <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
            <!-- Replace with your content -->
            <slot/>
            <!-- /End replace -->
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import {ref} from 'vue'
import {
  Dialog,
  DialogOverlay,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import {
  HomeIcon,
  ArrowLeftOnRectangleIcon,
  Bars3Icon,
  UsersIcon,
  XMarkIcon, ChevronDownIcon, ChevronUpDownIcon, UserGroupIcon, LinkIcon
} from '@heroicons/vue/24/solid'
import {Link, router, useForm, usePage} from "@inertiajs/vue3";
import {materialTheme, Notifications, Notivue, usePush} from "notivue";

const navigation = [
  { name: 'Dashboard', href: route('admin.vote-system', usePage().props.admin.election.selected.id), icon: HomeIcon, current:route().current() === 'admin.vote-system' },
  { name: 'Candidates', href: route('admin.vote-system.candidates', {'id' : usePage().props.admin.election.selected.id}), icon: UsersIcon, current: route().current() === 'admin.vote-system.candidates'},
  {name: 'Voters', href: route('admin.vote-system.voters', usePage().props.admin.election.selected.id), icon: UserGroupIcon, current: route().current() === 'admin.vote-system.voters'},
  {name: 'Vote-links', href: route('admin.vote-system.voteLinks', usePage().props.admin.election.selected.id), icon: LinkIcon, current: route().current() === 'admin.vote-system.voteLinks'}
]

const electionNavigation = [
  { name: 'Election Setting', href: route('admin.vote-System.edit', {'id' : usePage().props.admin.election.selected.id}) },
  { name: 'Create New Election', href: route('admin.vote-system.create', {'id' : usePage().props.admin.election.selected.id}) },
]

const sidebarOpen = ref(false)

function switchElection(id){
  router.visit(route('admin.vote-system.switch', {
    'id' : id
  }), {
    preserveScroll: false,
    method: "get"
  })

}
</script>