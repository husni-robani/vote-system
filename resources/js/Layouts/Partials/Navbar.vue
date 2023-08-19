<template>
  <header>
    <Popover class="relative bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex justify-between items-center border-b-2 border-gray-100 py-6 md:justify-start md:space-x-10">
          <div class="flex justify-start lg:w-0 lg:flex-1">
            <Link :href="route('welcome')">
              <span class="sr-only">Workflow</span>
              <HimatifPrimaryLogo class="h-16 w-16 "/>
            </Link>
          </div>
          <div class="-mr-2 -my-2 md:hidden">
            <PopoverButton
                class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
              <span class="sr-only">Open menu</span>
              <Bars3Icon aria-hidden="true" class="h-6 w-6"/>
            </PopoverButton>
          </div>
          <PopoverGroup as="nav" class="hidden md:flex space-x-10">
            <a class="text-base font-medium text-gray-500 hover:text-gray-900" href="#"> About </a>
            <Link href="#" class="text-base font-medium text-gray-500 hover:text-gray-900">Send
              Your Aspiration
            </Link>
          </PopoverGroup>
          <div class="hidden md:flex items-center justify-end md:flex-1 lg:w-0">
            <Link v-if="$page.props.auth.user === null" :href="route('login')"
                  class="whitespace-nowrap text-base font-medium text-gray-500 hover:text-gray-900"> Sign in
            </Link>
<!--            <div v-else>-->
<!--              <Link v-show="$page.props.auth.user.admin" href="#"-->
<!--                    class="whitespace-nowrap text-base font-medium text-gray-500 hover:text-gray-900"> Dashboard-->
<!--              </Link>-->
<!--              <Link v-show="!$page.props.auth.user.admin" href="#"-->
<!--                    class="whitespace-nowrap text-base font-medium text-gray-500 hover:text-gray-900"> Dashboard-->
<!--              </Link>-->
<!--            </div>-->
          </div>
        </div>
      </div>

      <transition enter-active-class="duration-200 ease-out" enter-from-class="opacity-0 scale-95"
                  enter-to-class="opacity-100 scale-100" leave-active-class="duration-100 ease-in"
                  leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
        <PopoverPanel class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden" focus>
          <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50">
            <div class="pt-5 pb-6 px-5">
              <div class="flex items-center justify-between">
                <div>
                  <img alt="Workflow" class="h-8 w-auto"
                       src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg"/>
                </div>
                <div class="-mr-2">
                  <PopoverButton
                      class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                    <span class="sr-only">Close menu</span>
                    <XMarkIcon aria-hidden="true" class="h-6 w-6"/>
                  </PopoverButton>
                </div>
              </div>
              <div class="mt-6">
                <nav class="grid gap-y-8">
                  <a v-for="item in solutions" :key="item.name" :href="item.href"
                     class="-m-3 p-3 flex items-center rounded-md hover:bg-gray-50">
                    <component :is="item.icon" aria-hidden="true" class="flex-shrink-0 h-6 w-6 text-indigo-600"/>
                    <span class="ml-3 text-base font-medium text-gray-900">
                      {{ item.name }}
                    </span>
                  </a>
                </nav>
              </div>
            </div>
            <div class="py-6 px-5 space-y-6">
              <div class="grid grid-cols-2 gap-y-4 gap-x-8">
                <a class="text-base font-medium text-gray-900 hover:text-gray-700" href="#"> Pricing </a>

                <a class="text-base font-medium text-gray-900 hover:text-gray-700" href="#"> Docs </a>
                <a v-for="item in resources" :key="item.name" :href="item.href"
                   class="text-base font-medium text-gray-900 hover:text-gray-700">
                  {{ item.name }}
                </a>
              </div>
              <div>
                <a class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700"
                   href="#">
                  Sign up </a>
                <p class="mt-6 text-center text-base font-medium text-gray-500">
                  Existing customer?
                  {{ ' ' }}
                  <a class="text-indigo-600 hover:text-indigo-500" href="#"> Sign in </a>
                </p>
              </div>
            </div>
          </div>
        </PopoverPanel>
      </transition>
    </Popover>
  </header>
</template>

<script setup>
import {Link} from "@inertiajs/vue3";
import {Popover, PopoverButton, PopoverGroup, PopoverPanel} from '@headlessui/vue'
import {
  CalendarIcon,
  ChartBarIcon,
  CursorArrowRippleIcon,
  Bars3Icon,
  PhoneIcon,
  PlayIcon,
  ShieldCheckIcon,
  XMarkIcon, BookmarkIcon, ArrowPathIcon, ViewfinderCircleIcon,
} from '@heroicons/vue/24/solid'
import HimatifPrimaryLogo from "../../Assets/HimatifPrimaryLogo";

const solutions = [
  {
    name: 'Analytics',
    description: 'Get a better understanding of where your traffic is coming from.',
    href: '#',
    icon: ChartBarIcon,
  },
  {
    name: 'Engagement',
    description: 'Speak directly to your customers in a more meaningful way.',
    href: '#',
    icon: CursorArrowRippleIcon,
  },
  {name: 'Security', description: "Your customers' data will be safe and secure.", href: '#', icon: ShieldCheckIcon},
  {
    name: 'Integrations',
    description: "Connect with third-party tools that you're already using.",
    href: '#',
    icon: ViewfinderCircleIcon,
  },
  {
    name: 'Automations',
    description: 'Build strategic funnels that will drive your customers to convert',
    href: '#',
    icon: ArrowPathIcon,
  },
]
const callsToAction = [
  {name: 'Watch Demo', href: '#', icon: PlayIcon},
  {name: 'Contact Sales', href: '#', icon: PhoneIcon},
]
const resources = [
  {
    name: 'Help Center',
    description: 'Get all of your questions answered in our forums or contact support.',
    href: '#',
    icon: PhoneIcon,
  },
  {
    name: 'Guides',
    description: 'Learn how to maximize our platform to get the most out of it.',
    href: '#',
    icon: BookmarkIcon,
  },
  {
    name: 'Events',
    description: 'See what meet-ups and other events we might be planning near you.',
    href: '#',
    icon: CalendarIcon,
  },
  {name: 'Security', description: 'Understand how we take your privacy seriously.', href: '#', icon: ShieldCheckIcon},
]
const recentPosts = [
  {id: 1, name: 'Boost your conversion rate', href: '#'},
  {id: 2, name: 'How to use search engine optimization to drive traffic to your site', href: '#'},
  {id: 3, name: 'Improve your customer experience', href: '#'},
]
</script>