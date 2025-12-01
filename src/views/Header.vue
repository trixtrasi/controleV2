<template>
    <header class="bg-white dark:bg-gray-900">
        <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="#" class="-m-1.5 p-1.5">
                    <span class="sr-only">Your Company</span>
                    <img class="h-8 w-auto dark:hidden"
                        src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="" />
                    <img class="h-8 w-auto not-dark:hidden"
                        src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="" />
                </a>
            </div>
            <div class="flex lg:hidden">
                <button type="button"
                    class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700 dark:text-gray-400"
                    @click="mobileMenuOpen = true">
                    <span class="sr-only">Open main menu</span>
                    <Bars3Icon class="size-6" aria-hidden="true" />
                </button>
            </div>
            <PopoverGroup class="hidden lg:flex lg:gap-x-12">
                <Popover class="relative">
                    <PopoverButton
                        class="flex items-center gap-x-1 text-sm/6 font-semibold text-gray-900 dark:text-white">
                        Product
                        <ChevronDownIcon class="size-5 flex-none text-gray-400 dark:text-gray-500" aria-hidden="true" />
                    </PopoverButton>

                    <transition enter-active-class="transition ease-out duration-200"
                        enter-from-class="opacity-0 translate-y-1" enter-to-class="translate-y-0"
                        leave-active-class="transition ease-in duration-150" leave-from-class="translate-y-0"
                        leave-to-class="opacity-0 translate-y-1">
                        <PopoverPanel
                            class="absolute left-1/2 z-10 mt-3 w-screen max-w-md -translate-x-1/2 overflow-hidden rounded-3xl bg-white shadow-lg outline-1 outline-gray-900/5 dark:bg-gray-800 dark:shadow-none dark:-outline-offset-1 dark:outline-white/10">
                            <div class="p-4">
                                <div v-for="item in products" :key="item.name"
                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-gray-50 dark:hover:bg-white/5">
                                    <div
                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white dark:bg-gray-700/50 dark:group-hover:bg-gray-700">
                                        <component :is="item.icon"
                                            class="size-6 text-gray-600 group-hover:text-indigo-600 dark:text-gray-400 dark:group-hover:text-white"
                                            aria-hidden="true" />
                                    </div>
                                    <div class="flex-auto">
                                        <a :href="item.href" class="block font-semibold text-gray-900 dark:text-white">
                                            {{ item.name }}
                                            <span class="absolute inset-0"></span>
                                        </a>
                                        <p class="mt-1 text-gray-600 dark:text-gray-400">{{ item.description }}</p>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="grid grid-cols-2 divide-x divide-gray-900/5 bg-gray-50 dark:divide-white/10 dark:bg-gray-700/50">
                                <a v-for="item in callsToAction" :key="item.name" :href="item.href"
                                    class="flex items-center justify-center gap-x-2.5 p-3 text-sm/6 font-semibold text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700/50">
                                    <component :is="item.icon" class="size-5 flex-none text-gray-400 dark:text-gray-500"
                                        aria-hidden="true" />
                                    {{ item.name }}
                                </a>
                            </div>
                        </PopoverPanel>
                    </transition>
                </Popover>

                <a href="#" class="text-sm/6 font-semibold text-gray-900 dark:text-white">Features</a>
                <a href="#" class="text-sm/6 font-semibold text-gray-900 dark:text-white">Marketplace</a>
                <a href="#" class="text-sm/6 font-semibold text-gray-900 dark:text-white">Company</a>
            </PopoverGroup>
            <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                <a href="#" class="text-sm/6 font-semibold text-gray-900 dark:text-white">Log in <span
                        aria-hidden="true">&rarr;</span></a>
            </div>
        </nav>
        <Dialog class="lg:hidden" @close="mobileMenuOpen = false" :open="mobileMenuOpen">
            <div class="fixed inset-0 z-50"></div>
            <DialogPanel
                class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white p-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10 dark:bg-gray-900 dark:sm:ring-gray-100/10">
                <div class="flex items-center justify-between">
                    <a href="#" class="-m-1.5 p-1.5">
                        <span class="sr-only">Your Company</span>
                        <img class="h-8 w-auto dark:hidden"
                            src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600"
                            alt="" />
                        <img class="h-8 w-auto not-dark:hidden"
                            src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
                            alt="" />
                    </a>
                    <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700 dark:text-gray-400"
                        @click="mobileMenuOpen = false">
                        <span class="sr-only">Close menu</span>
                        <XMarkIcon class="size-6" aria-hidden="true" />
                    </button>
                </div>
                <div class="mt-6 flow-root">
                    <div class="-my-6 divide-y divide-gray-500/10 dark:divide-white/10">
                        <div class="space-y-2 py-6">
                            <Disclosure as="div" class="-mx-3" v-slot="{ open }">
                                <DisclosureButton
                                    class="flex w-full items-center justify-between rounded-lg py-2 pr-3.5 pl-3 text-base/7 font-semibold text-gray-900 hover:bg-gray-50 dark:text-white dark:hover:bg-white/5">
                                    Product
                                    <ChevronDownIcon :class="[open ? 'rotate-180' : '', 'size-5 flex-none']"
                                        aria-hidden="true" />
                                </DisclosureButton>
                                <DisclosurePanel class="mt-2 space-y-2">
                                    <DisclosureButton v-for="item in [...products, ...callsToAction]" :key="item.name"
                                        as="a" :href="item.href"
                                        class="block rounded-lg py-2 pr-3 pl-6 text-sm/7 font-semibold text-gray-900 hover:bg-gray-50 dark:text-white dark:hover:bg-white/5">
                                        {{ item.name }}</DisclosureButton>
                                </DisclosurePanel>
                            </Disclosure>
                            <a href="#"
                                class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50 dark:text-white dark:hover:bg-white/5">Features</a>
                            <a href="#"
                                class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50 dark:text-white dark:hover:bg-white/5">Marketplace</a>
                            <a href="#"
                                class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50 dark:text-white dark:hover:bg-white/5">Company</a>
                        </div>
                        <div class="py-6">
                            <a href="#"
                                class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-gray-900 hover:bg-gray-50 dark:text-white dark:hover:bg-white/5">Log
                                in</a>
                        </div>
                    </div>
                </div>
            </DialogPanel>
        </Dialog>
    </header>
</template>

<script setup>
import { ref } from 'vue'
import {
    Dialog,
    DialogPanel,
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Popover,
    PopoverButton,
    PopoverGroup,
    PopoverPanel,
} from '@headlessui/vue'
import {
    ArrowPathIcon,
    Bars3Icon,
    ChartPieIcon,
    CursorArrowRaysIcon,
    FingerPrintIcon,
    SquaresPlusIcon,
    XMarkIcon,
} from '@heroicons/vue/24/outline'
import { ChevronDownIcon, PhoneIcon, PlayCircleIcon } from '@heroicons/vue/20/solid'

const products = [
    { name: 'Analytics', description: 'Get a better understanding of your traffic', href: '#', icon: ChartPieIcon },
    { name: 'Engagement', description: 'Speak directly to your customers', href: '#', icon: CursorArrowRaysIcon },
    { name: 'Security', description: 'Your customers’ data will be safe and secure', href: '#', icon: FingerPrintIcon },
    { name: 'Integrations', description: 'Connect with third-party tools', href: '#', icon: SquaresPlusIcon },
    { name: 'Automations', description: 'Build strategic funnels that will convert', href: '#', icon: ArrowPathIcon },
]
const callsToAction = [
    { name: 'Watch demo', href: '#', icon: PlayCircleIcon },
    { name: 'Contact sales', href: '#', icon: PhoneIcon },
]

const mobileMenuOpen = ref(false)
</script>