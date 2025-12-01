<template>
    <div>
        <button
            class="rounded-md bg-gray-950/5 px-2.5 py-1.5 text-sm font-semibold text-gray-900 hover:bg-gray-950/10 dark:bg-white/10 dark:text-white dark:inset-ring dark:inset-ring-white/5 dark:hover:bg-white/20"
            @click="open = true">Open dialog</button>
        <TransitionRoot as="template" :show="open">
            <Dialog class="relative z-10" @close="open = false">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to=""
                    leave="ease-in duration-200" leave-from="" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-gray-500/75 transition-opacity dark:bg-gray-900/50"></div>
                </TransitionChild>

                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <TransitionChild as="template" enter="ease-out duration-300"
                            enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            enter-to=" translate-y-0 sm:scale-100" leave="ease-in duration-200"
                            leave-from=" translate-y-0 sm:scale-100"
                            leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                            <DialogPanel
                                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg dark:bg-gray-800 dark:outline dark:-outline-offset-1 dark:outline-white/10">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 dark:bg-gray-800">
                                    <div class="sm:flex sm:items-start">
                                        <div
                                            class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10 dark:bg-red-500/10">
                                            <ExclamationTriangleIcon class="size-6 text-red-600 dark:text-red-400"
                                                aria-hidden="true" />
                                        </div>
                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                            <DialogTitle as="h3"
                                                class="text-base font-semibold text-gray-900 dark:text-white">Deactivate
                                                account</DialogTitle>
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Are you sure you
                                                    want to deactivate your account? All of your data will be
                                                    permanently removed. This action cannot be undone.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 dark:bg-gray-700/25">
                                    <button type="button"
                                        class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:ml-3 sm:w-auto dark:bg-red-500 dark:shadow-none dark:hover:bg-red-400"
                                        @click="open = false">Deactivate</button>
                                    <button type="button"
                                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs inset-ring inset-ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto dark:bg-white/10 dark:text-white dark:shadow-none dark:inset-ring-white/5 dark:hover:bg-white/20"
                                        @click="open = false" ref="cancelButtonRef">Cancel</button>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationTriangleIcon } from '@heroicons/vue/24/outline'

const open = ref(true)
</script>