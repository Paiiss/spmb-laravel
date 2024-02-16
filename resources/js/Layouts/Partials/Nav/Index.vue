<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { watch } from "vue";
import Dropdown from "@/Components/Dropdown.vue";
import NotifsHandler from "@/Components/NotifsHandler.vue";
import DropdownLink from "@/Components/DropdownLink.vue";

import useNotifs from "@/Composables/useNotifs.js";
const { unreadNotif } = useNotifs();

defineProps({
    modelValue: Boolean,
});

defineEmits(["update:modelValue"]);
</script>

<template>
    <nav
        class="fixed top-0 z-50 w-full bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700"
    >
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div
                        class="shrink-0 flex items-center text-black dark:text-white text-2xl font-bold leading-7"
                    >
                        <button
                            @click="$emit('update:modelValue', !modelValue)"
                            type="button"
                            class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                        >
                            <span class="sr-only">Open sidebar</span>
                            <svg
                                class="w-6 h-6"
                                aria-hidden="true"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    clip-rule="evenodd"
                                    fill-rule="evenodd"
                                    d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"
                                ></path>
                            </svg>
                        </button>
                        <Link :href="route('dashboard')" class="ml-3">
                            {{ $page.props.web_settings.title_dashboard }}
                        </Link>
                    </div>

                    <div
                        class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
                    ></div>
                </div>

                <div class="flex items-center ms-6">
                    <!-- Settings Dropdown -->
                    <div class="ms-3 relative">
                        <Dropdown align="right" width="responsive">
                            <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <button
                                        type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                                    >
                                        <i class="fa-solid fa-bell text-2xl">
                                            <div
                                                v-if="unreadNotif() > 0"
                                                class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full top-0 end-0 dark:border-gray-900"
                                            >
                                                {{ unreadNotif() }}
                                            </div>
                                        </i>
                                    </button>
                                </span>
                            </template>

                            <template #content>
                                <NotifsHandler />
                            </template>
                        </Dropdown>
                    </div>
                    <div class="ms-3 relative">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <button
                                        type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                                    >
                                        <i
                                            class="fa-solid fa-user text-2xl"
                                        ></i>
                                    </button>
                                </span>
                            </template>

                            <template #content>
                                <DropdownLink :href="route('profile.edit')">
                                    Profile
                                </DropdownLink>
                                <DropdownLink
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                >
                                    Log Out
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>
