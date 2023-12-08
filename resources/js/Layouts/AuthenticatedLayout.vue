<script setup>
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import ResponsiveSideBar from "@/Components/ResponsiveSideBar.vue";
import { Link, usePage } from "@inertiajs/vue3";

const showingNavigationDropdown = ref(false);
const showingListForm = ref(route().current("form.edit") || false);
const isSideBarOpen = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <!--  -->
            <nav
                class="fixed top-0 z-50 w-full bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700"
            >
                <!-- Primary Navigation Menu -->
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div
                                class="shrink-0 flex items-center text-black dark:text-white text-2xl font-bold leading-7"
                            >
                                <button
                                    @click="isSideBarOpen = !isSideBarOpen"
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
                                    <!-- <ApplicationLogo
                                        class="block h-12 w-auto fill-current text-gray-800 dark:text-gray-200"
                                    /> -->
                                    PMB HTP
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div
                                class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
                            >
                                <!-- <NavLink
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                >
                                    Dashboard
                                </NavLink>
                                <NavLink
                                    :href="route('form.edit')"
                                    :active="route().current('form.edit')"
                                >
                                    Form
                                </NavLink> -->
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                <!-- {{ $page.props.auth.user.name }} -->

                                                <!-- <svg
                                                    class="ms-2 -me-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg> -->
                                                <!-- <img
                                                    src="https://flowbite.com/docs/images/logo.svg"
                                                    class="h-8 me-3"
                                                    alt="User Logo"
                                                /> -->
                                                <i
                                                    class="fa-solid fa-user text-2xl"
                                                ></i>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink
                                            :href="route('profile.edit')"
                                        >
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

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
                            >
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            Dashboard
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="
                                route('form.edit', {
                                    id: 'personal',
                                })
                            "
                            :active="
                                route().current('form.edit', { id: 'personal' })
                            "
                        >
                            Form
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div
                        class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600"
                    >
                        <div class="px-4">
                            <div
                                class="font-medium text-base text-gray-800 dark:text-gray-200"
                            >
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')">
                                Profile
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <aside
                class="fixed top-0 left-0 z-40 w-64 pt-20 h-screen transition-transform -translate-x-full sm:translate-x-0 bg-white dark:bg-gray-800"
                :class="{ 'translate-x-0': isSideBarOpen }"
            >
                <div class="h-full px-3 py-4 overflow-y-auto">
                    <ul class="space-y-2 font-medium">
                        <li>
                            <ResponsiveSideBar
                                icon="fa-solid fa-house"
                                :href="route('dashboard')"
                                :active="route().current('dashboard')"
                            >
                                Dashboard
                            </ResponsiveSideBar>
                        </li>
                        <li>
                            <button
                                type="button"
                                @click="showingListForm = !showingListForm"
                                class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                            >
                                <i class="fa-solid fa-address-card" />
                                <span
                                    class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap"
                                    >Profile</span
                                >
                                <i
                                    class="fa-solid"
                                    :class="{
                                        'fa-chevron-up': showingListForm,
                                        'fa-chevron-down': !showingListForm,
                                    }"
                                />
                            </button>
                            <ul
                                class="py-2 space-y-2"
                                :class="{
                                    block: showingListForm,
                                    hidden: !showingListForm,
                                }"
                            >
                                <li>
                                    <ResponsiveSideBar
                                        :href="
                                            route('form.edit', {
                                                id: 'personal',
                                            })
                                        "
                                        :active="
                                            route().current('form.edit', {
                                                id: 'personal',
                                            })
                                        "
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                        >Personal</ResponsiveSideBar
                                    >
                                </li>
                                <li>
                                    <ResponsiveSideBar
                                        :href="
                                            route('form.edit', {
                                                id: 'disability',
                                            })
                                        "
                                        :active="
                                            route().current('form.edit', {
                                                id: 'disability',
                                            })
                                        "
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                        >Disabilitas</ResponsiveSideBar
                                    >
                                </li>
                                <li>
                                    <ResponsiveSideBar
                                        :href="
                                            route('form.edit', {
                                                id: 'education',
                                            })
                                        "
                                        :active="
                                            route().current('form.edit', {
                                                id: 'education',
                                            })
                                        "
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                        >Pendidikan</ResponsiveSideBar
                                    >
                                </li>
                                <li>
                                    <ResponsiveSideBar
                                        :href="
                                            route('form.edit', {
                                                id: 'parent',
                                            })
                                        "
                                        :active="
                                            route().current('form.edit', {
                                                id: 'parent',
                                            })
                                        "
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                        >Orang tua / wali</ResponsiveSideBar
                                    >
                                </li>
                            </ul>
                        </li>
                        <li>
                            <ResponsiveSideBar
                                icon="fa-solid fa-file-invoice"
                                :href="route('dashboard')"
                                :active="route().current('dashboard')"
                            >
                                Pendaftaran
                            </ResponsiveSideBar>
                        </li>
                        <li>
                            <ResponsiveSideBar
                                icon="fa-solid fa-money-bill"
                                :href="route('dashboard')"
                                :active="route().current('dashboard')"
                            >
                                Pembayaran
                            </ResponsiveSideBar>
                        </li>
                    </ul>
                </div>
            </aside>

            <!-- Page Heading -->

            <!-- Page Content -->
            <!-- <header
                class="bg-white dark:bg-gray-800 shadow mb-6"
                v-if="$slots.header"
            >
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header> -->
            <main class="p-4 py-20 sm:ml-64" @click="isSideBarOpen = false">
                <slot />
            </main>
        </div>
    </div>
</template>
