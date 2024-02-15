<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
import { ref, onMounted, onBeforeUnmount } from "vue";
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

const scrollY = ref(0);

const handleHeader = () => {
    // console.log(window.scrollY, window.scrollY > 0);
    /* const nav = document.querySelector("nav");
    if (nav) {
        nav.classList.toggle("sticky", window.scrollY > 0);
    } */
    scrollY.value = window.scrollY || 0;
};

onMounted(() => {
    console.log("HomeLayout.vue mounted");
    window.addEventListener("scroll", handleHeader);
});

onBeforeUnmount(() => {
    console.log("HomeLayout.vue unmounted");
    window.removeEventListener("scroll", handleHeader);
});

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="flex flex-col min-h-screen">
            <nav
                class="fixed w-full z-20 h-20 top-0 start-0 border-b bg-gray-50"
                :class="{
                    'bg-opacity-90 ': scrollY > 150,
                }"
            >
                <div
                    class="mx-auto px-4 sm:px-6 lg:px-8 h-full flex justify-between"
                >
                    <div class="flex flex-row">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center gap-3">
                            <Link href="/">
                                <ApplicationLogo class="block h-9 w-auto" />
                            </Link>
                            <h1
                                class="text-lg md:text-2xl inline-flex items-center font-bold text-gray-900 px-3 leading-relaxed"
                            >
                                {{ $page.props.web_settings.title_home }}
                            </h1>
                        </div>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <div class="flex justify-center gap-2">
                            <Link
                                v-if="!$page.props.auth.user"
                                :href="route('login')"
                                class="inline-flex items-center text-gray-900 hover:text-blue-500 font-bold capitalize"
                            >
                                Masuk
                            </Link>
                            <Link
                                v-if="!$page.props.auth.user"
                                :href="route('register')"
                                class="inline-flex items-center p-2 text-left border-transparent text-xs uppercase text-white font-bold bg-blue-500 rounded-lg dark:text-gray-800 tracking-widest hover:bg-blue-700 dark:hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-150 ease-in-out shadow-md"
                            >
                                daftar</Link
                            >
                            <Link
                                v-if="$page.props.auth.user"
                                :href="route('dashboard')"
                                class="inline-flex items-center p-2 text-left border-transparent text-xs uppercase text-white font-bold bg-blue-500 rounded-lg dark:text-gray-800 tracking-widest hover:bg-blue-700 dark:hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-150 ease-in-out shadow-md"
                            >
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
                            class="inline-flex items-center justify-center p-2 rounded-md text-black dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
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

                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden bg-white"
                >
                    <div
                        v-if="$page.props.auth.user"
                        class="pt-2 pb-3 space-y-1 px-4"
                    >
                        <ResponsiveNavLink :href="route('dashboard')"
                            >Dashboard
                        </ResponsiveNavLink>
                    </div>
                    <div v-else class="pt-2 pb-3 space-y-1 px-4">
                        <ResponsiveNavLink :href="route('login')"
                            ><i class="fa-solid fa-user-graduate pr-2"></i>
                            Masuk
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('register')"
                            ><i class="fa-solid fa-right-to-bracket pr-2"></i>
                            Daftar
                        </ResponsiveNavLink>
                    </div>
                </div>
            </nav>
            <main class="flex-grow w-full bg-gray-50">
                <slot />
            </main>

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
                                    {{
                                        $page.props.web_settings.contact_address
                                    }}
                                </li>
                                <li>
                                    <i class="fa-solid fa-envelope pr-2"></i>
                                    {{ $page.props.web_settings.contact_email }}
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
                        {{ $page.props.web_settings.footer }}
                    </p>
                </div>
            </footer>
        </div>
    </div>
</template>
