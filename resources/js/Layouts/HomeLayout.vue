<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import NavLink from "@/Components/NavLink.vue";
import NavLinkBtn from "@/Components/NavLinkBtn.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
});

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="flex flex-col min-h-screen">
            <nav
                class="bg-background-light dark:bg-background-dark sticky top-0 z-40 shadow-md"
            >
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex flex-row">
                            <!-- Logo -->
                            <div class="flex-shrink-0 flex items-center gap-3">
                                <Link href="/">
                                    <ApplicationLogo class="block h-9 w-auto" />
                                </Link>
                                <h1
                                    class="border-l-2 text-lg inline-flex items-center font-bold text-white px-3 leading-relaxed"
                                >
                                    PMB 2024/2025
                                </h1>
                            </div>

                            <!-- Navigation Links -->
                            <!-- <div
                                class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
                            >
                                <NavLink
                                    class="text-white dark:text-white font-bold"
                                >
                                    Dashboard
                                </NavLink>
                                <NavLink
                                    class="text-white dark:text-white font-bold"
                                >
                                    Repu
                                </NavLink>
                                <NavLink
                                    class="text-white dark:text-white font-bold"
                                >
                                    About
                                </NavLink>
                            </div> -->
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <div class="flex justify-center gap-2">
                                <Link
                                    v-if="!$page.props.auth.user"
                                    :href="route('login')"
                                    class="inline-flex items-center p-2 text-left border-transparent text-xs uppercase text-white font-bold bg-teal-400 rounded-lg dark:text-gray-800 tracking-widest hover:bg-teal-700 dark:hover:bg-teal-500 focus:outline-none focus:border-teal-700 focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-150 ease-in-out shadow-md"
                                >
                                    <i
                                        class="fa-solid fa-user-graduate pr-2"
                                    ></i>
                                    masuk
                                </Link>
                                <Link
                                    v-if="!$page.props.auth.user"
                                    :href="route('register')"
                                    class="inline-flex items-center p-2 text-left border-transparent text-xs uppercase text-teal-400 font-bold bg-teal-50 rounded-lg dark:text-gray-800 tracking-widest hover:bg-teal-700 dark:hover:bg-teal-500 focus:outline-none focus:border-teal-700 focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-150 ease-in-out shadow-md"
                                >
                                    <i
                                        class="fa-solid fa-right-to-bracket pr-2"
                                    ></i
                                    >daftar</Link
                                >
                                <Link
                                    v-if="$page.props.auth.user"
                                    :href="route('dashboard')"
                                    class="inline-flex items-center p-2 text-left border-transparent text-xs uppercase text-white font-bold bg-teal-400 rounded-lg dark:text-gray-800 tracking-widest hover:bg-teal-700 dark:hover:bg-teal-500 focus:outline-none focus:border-teal-700 focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-150 ease-in-out shadow-md"
                                >
                                    <i
                                        class="fa-solid fa-user-graduate pr-2"
                                    ></i>
                                    Dashboard</Link
                                >
                            </div>
                        </div>

                        <!-- Hamburger Start -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center p-2 rounded-md text-white dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
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
                    <div
                        v-if="$page.props.auth.user"
                        class="pt-2 pb-3 space-y-1 px-4"
                    >
                        <ResponsiveNavLink
                            :href="route('dashboard')"
                            class="text-white dark:text-white font-bold rounded-lg"
                            >Dashboard
                        </ResponsiveNavLink>
                    </div>
                    <div v-else class="pt-2 pb-3 space-y-1 px-4">
                        <ResponsiveNavLink
                            :href="route('login')"
                            class="text-white dark:text-white font-bold rounded-lg bg-teal-400 dark:bg-teal-500"
                            ><i class="fa-solid fa-user-graduate pr-2"></i>
                            Masuk
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('register')"
                            class="text-white dark:text-white font-bold rounded-lg bg-teal-400 dark:bg-teal-500"
                            ><i class="fa-solid fa-right-to-bracket pr-2"></i>
                            Daftar
                        </ResponsiveNavLink>
                    </div>
                </div>
            </nav>
            <main class="flex-grow w-full">
                <slot />
            </main>

            <!-- Footer start -->
            <footer class="pt-16 col-end-1 bg-background-light text-white">
                <div class="container mx-auto">
                    <div
                        class="grid grid-cols-1 md:grid-cols-3 p-4 gap-6 text-sm"
                    >
                        <div>
                            <h3
                                class="text-white font-bold text-lg border-b-2 border-white pb-2 mb-2"
                            >
                                Universitas Hang Tuah Pekanbaru
                            </h3>
                            <ul class="list-disc list-inside text-white">
                                <li>Perguruan Tinggi di Pekanbaru</li>
                                <li>Tenaga Pengajar yang Mumpuni</li>
                                <li>Fasilitas Lengkap</li>
                                <li>
                                    Lokasi Kampus Strategis di Tengah Perkotaan
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-white font-bold text-lg pb-2">
                                Akademik
                            </h3>
                            <ul
                                class="list-disc list-inside text-white capitalize"
                            >
                                <li>
                                    <Link
                                        class="hover:text-gray-300"
                                        href="https://siakadm.htp.ac.id/"
                                        >Sistem informasi Administrasi
                                        Akademik</Link
                                    >
                                </li>
                                <li>
                                    <Link
                                        class="hover:text-gray-300"
                                        href="https://spmb.htp.ac.id/"
                                        >Sistem Pendaftaran Mahasiswa Baru</Link
                                    >
                                </li>
                                <li>
                                    <Link
                                        class="hover:text-gray-300"
                                        href="https://tracer.htp.ac.id/"
                                        >Tracer Study</Link
                                    >
                                </li>
                                <li>
                                    <Link
                                        class="hover:text-gray-300"
                                        href="https://survei.htp.ac.id/"
                                        >Survey</Link
                                    >
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-white font-bold text-lg pb-2">
                                Kontak
                            </h3>
                            <ul class="list-none">
                                <li>
                                    <i
                                        class="fa-solid fa-location-dot pr-2"
                                    ></i>
                                    Jl. Mustafa Sari No.5, Tengkerang Sel., Kec.
                                    Bukit Raya, Kota Pekanbaru, Riau 28281
                                </li>
                                <li>
                                    <i class="fa-solid fa-envelope pr-2"></i>
                                    stikes.hangtuah@gmail.com
                                </li>
                                <li>
                                    <i class="fa-solid fa-phone pr-2"></i>+ 0761
                                    33815
                                </li>
                                <li>
                                    <i class="fa-solid fa-print pr-2"></i>+ 0761
                                    33815
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div
                    class="text-xs md:text-sm font-bold tracking-wide max-w-7xl mx-auto text-center py-6"
                >
                    <p>
                        &copy; 2023
                        <a href="https://htp.ac.id/" class="hover:text-teal-500"
                            >University Hang Tuah Pekanbaru.</a
                        >
                        <span>Created by pais hehe</span>
                    </p>
                </div>
            </footer>
        </div>
    </div>
</template>
