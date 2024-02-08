<script setup>
import { ref, onMounted } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import ResponsiveSideBar from "@/Components/ResponsiveSideBar.vue";
import { Link, usePage } from "@inertiajs/vue3";
import AlertHandler from "@/Components/AlertHandler.vue";
import NotifsHandler from "@/Components/NotifsHandler.vue";

import useNotifs from "@/Composables/useNotifs.js";
const { unreadNotif } = useNotifs();

const showingNavigationDropdown = ref(false);
const showingListForm = ref(
    route().current("form.edit") || route().current("documents.index") || false
);
const showingListAdmin = ref(route() || false);
const isSideBarOpen = ref(false);

const checkRole = (role = []) => {
    if (role.length == 0) return true;
    return role.some((r) => usePage().props.auth.user.roles.includes(r));
};
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <!--  -->
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
                                    {{
                                        $page.props.web_settings.title_dashboard
                                    }}
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
                                                <i
                                                    class="fa-solid fa-bell text-2xl"
                                                >
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
                    </div>
                </div>
            </nav>

            <aside
                class="fixed top-0 left-0 z-40 w-64 pt-20 h-screen transition-transform -translate-x-full sm:translate-x-0 bg-white dark:bg-gray-800"
                :class="{ 'translate-x-0': isSideBarOpen }"
            >
                <div class="h-full px-3 py-4 overflow-y-auto">
                    <template v-if="checkRole(['user'])">
                        <div class="mb-8">
                            <header
                                class="px-3 mb-4 text-xs font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400"
                            >
                                Menu
                            </header>
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
                                    <ResponsiveSideBar
                                        icon="fa-solid fa-file-invoice"
                                        :href="route('form.submission')"
                                        :active="
                                            route().current('form.submission')
                                        "
                                    >
                                        Pendaftaran
                                    </ResponsiveSideBar>
                                </li>
                                <li
                                    v-if="
                                        $page.props.auth.form
                                            .is_paid_registration
                                    "
                                >
                                    <button
                                        type="button"
                                        @click="
                                            showingListForm = !showingListForm
                                        "
                                        class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                    >
                                        <i class="fa-solid fa-address-card" />
                                        <span
                                            class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap capitalize"
                                            >Data diri</span
                                        >
                                        <i
                                            class="fa-solid"
                                            :class="{
                                                'fa-chevron-up':
                                                    showingListForm,
                                                'fa-chevron-down':
                                                    !showingListForm,
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
                                                    route().current(
                                                        'form.edit',
                                                        {
                                                            id: 'personal',
                                                        }
                                                    )
                                                "
                                                class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                                >Personal</ResponsiveSideBar
                                            >
                                        </li>
                                        <li>
                                            <ResponsiveSideBar
                                                :href="
                                                    route('form.edit', {
                                                        id: 'address',
                                                    })
                                                "
                                                :active="
                                                    route().current(
                                                        'form.edit',
                                                        {
                                                            id: 'address',
                                                        }
                                                    )
                                                "
                                                class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                                >Alamat</ResponsiveSideBar
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
                                                    route().current(
                                                        'form.edit',
                                                        {
                                                            id: 'disability',
                                                        }
                                                    )
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
                                                    route().current(
                                                        'form.edit',
                                                        {
                                                            id: 'education',
                                                        }
                                                    )
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
                                                    route().current(
                                                        'form.edit',
                                                        {
                                                            id: 'parent',
                                                        }
                                                    )
                                                "
                                                class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                                >Orang tua /
                                                wali</ResponsiveSideBar
                                            >
                                        </li>
                                        <li>
                                            <ResponsiveSideBar
                                                :href="route('documents.index')"
                                                :active="
                                                    route().current(
                                                        'documents.index'
                                                    )
                                                "
                                                class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                                >Dokumen</ResponsiveSideBar
                                            >
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <ResponsiveSideBar
                                        icon="fa-solid fa-money-bill"
                                        :href="route('form.payment')"
                                        :active="
                                            route().current('form.payment')
                                        "
                                    >
                                        Pembayaran
                                    </ResponsiveSideBar>
                                </li>
                            </ul>
                        </div>
                    </template>

                    <template
                        v-if="
                            $page.props.auth.form.status == 'approved' &&
                            checkRole(['user'])
                        "
                    >
                        <div class="mb-8">
                            <header
                                class="px-3 mb-4 text-xs font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400"
                            >
                                Ujian
                            </header>
                            <ul
                                class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"
                            >
                                <li v-if="$page.props.auth.exams.knowledge">
                                    <ResponsiveSideBar
                                        :href="route('exams.knowledge')"
                                        :active="
                                            route().current('exams.knowledge')
                                        "
                                        icon="fas fa-clipboard"
                                    >
                                        Ujian pengetahuan
                                    </ResponsiveSideBar>
                                </li>
                                <li v-if="$page.props.auth.exams.health">
                                    <ResponsiveSideBar
                                        :href="route('exams.health')"
                                        :active="
                                            route().current('exams.health')
                                        "
                                        icon="fas fa-stethoscope"
                                    >
                                        Pemeriksaan kesehatan
                                    </ResponsiveSideBar>
                                </li>
                                <li v-if="$page.props.auth.exams.interview">
                                    <ResponsiveSideBar
                                        :href="route('exams.interview')"
                                        :active="
                                            route().current('exams.interview')
                                        "
                                        icon="fas fa-microphone"
                                    >
                                        Wawancara
                                    </ResponsiveSideBar>
                                </li>
                            </ul>
                        </div>
                    </template>

                    <template v-if="checkRole(['admin', 'panitia'])">
                        <div class="mb-8">
                            <header
                                class="px-3 mb-4 text-xs font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400"
                            >
                                Panitia
                            </header>
                            <ul
                                class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"
                            >
                                <li>
                                    <ResponsiveSideBar
                                        :href="route('admin.user')"
                                        :active="route().current('admin.user')"
                                        icon="fa-solid fa-users"
                                    >
                                        User
                                    </ResponsiveSideBar>
                                </li>

                                <li>
                                    <ResponsiveSideBar
                                        :href="route('admin.prodi')"
                                        :active="route().current('admin.prodi')"
                                        icon="fa-solid fa-university"
                                    >
                                        Prodi
                                    </ResponsiveSideBar>
                                </li>
                                <li>
                                    <ResponsiveSideBar
                                        :href="route('admin.wave')"
                                        :active="route().current('admin.wave')"
                                        icon="fa-solid fa-wave-square"
                                    >
                                        Gelombang
                                    </ResponsiveSideBar>
                                </li>
                                <li>
                                    <ResponsiveSideBar
                                        :href="route('admin.exams')"
                                        :active="route().current('admin.exams')"
                                        icon="fa-solid fa-book"
                                    >
                                        Soal
                                    </ResponsiveSideBar>
                                </li>
                            </ul>
                        </div>
                    </template>

                    <template v-if="checkRole(['admin', 'panitia'])">
                        <div class="mb-8">
                            <header
                                class="px-3 mb-4 text-xs font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400"
                            >
                                Verifikasi
                            </header>
                            <ul
                                class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"
                            >
                                <li>
                                    <ResponsiveSideBar
                                        :href="route('admin.verification')"
                                        :active="
                                            route().current(
                                                'admin.verification'
                                            )
                                        "
                                        icon="fa-solid fa-book-open"
                                    >
                                        Formulir
                                    </ResponsiveSideBar>
                                </li>
                                <li>
                                    <ResponsiveSideBar
                                        :href="
                                            route('admin.health-verification')
                                        "
                                        :active="
                                            route().current(
                                                'admin.health-verification'
                                            )
                                        "
                                        icon="fa-solid fa-kit-medical"
                                    >
                                        Kesehatan
                                    </ResponsiveSideBar>
                                </li>
                                <li>
                                    <ResponsiveSideBar
                                        :href="route('admin.interview')"
                                        :active="
                                            route().current('admin.interview')
                                        "
                                        icon="fa-solid fa-microphone"
                                    >
                                        Wawancara
                                    </ResponsiveSideBar>
                                </li>
                            </ul>
                        </div>
                    </template>

                    <template v-if="checkRole(['admin', 'keuangan'])">
                        <div class="mb-8">
                            <header
                                class="px-3 mb-4 text-xs font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400"
                            >
                                Keuangan
                            </header>
                            <ul
                                class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"
                            >
                                <li>
                                    <ResponsiveSideBar
                                        :href="route('admin.payment')"
                                        :active="
                                            route().current('admin.payment')
                                        "
                                        icon="fa-solid fa-money-bill"
                                    >
                                        Pembayaran
                                    </ResponsiveSideBar>
                                </li>
                            </ul>
                        </div>
                    </template>

                    <template v-if="checkRole(['admin'])">
                        <div class="mb-8">
                            <header
                                class="px-3 mb-4 text-xs font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400"
                            >
                                Admin
                            </header>
                            <ul
                                class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"
                            >
                                <li>
                                    <ResponsiveSideBar
                                        :href="route('admin.web-setting')"
                                        :active="
                                            route().current('admin.web-setting')
                                        "
                                        icon="fa-solid fa-cog"
                                    >
                                        Web Setting
                                    </ResponsiveSideBar>
                                </li>
                            </ul>
                        </div>
                    </template>
                </div>
            </aside>
            <div
                v-show="isSideBarOpen"
                class="fixed inset-0 z-30 bg-gray-500 opacity-50"
                @click="isSideBarOpen = false"
            />
            <main class="p-4 py-20 sm:ml-64">
                <slot />
            </main>
            {{ $page.props.alert }}
            <AlertHandler />
        </div>
    </div>
</template>
