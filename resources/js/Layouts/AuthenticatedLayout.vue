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
import MenuUser from "@/Layouts/Partials/Menu/User.vue";
import MenuPanitia from "@/Layouts/Partials/Menu/Panitia.vue";
import MenuVerifikasi from "@/Layouts/Partials/Menu/Verifikasi.vue";
import MenuKeuangan from "@/Layouts/Partials/Menu/Keuangan.vue";
import MenuAdmin from "@/Layouts/Partials/Menu/Admin.vue";
import NavBar from "@/Layouts/Partials/Nav/Index.vue";

import useNotifs from "@/Composables/useNotifs.js";
const { unreadNotif } = useNotifs();

const showingNavigationDropdown = ref(false);

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
            <NavBar v-model="isSideBarOpen" />

            <aside
                class="fixed top-0 left-0 z-40 w-64 pt-20 h-screen transition-transform -translate-x-full md:translate-x-0 bg-white dark:bg-gray-800"
                :class="{ 'translate-x-0': isSideBarOpen }"
            >
                <div class="h-full px-3 py-4 overflow-y-auto">
                    <MenuUser :check="checkRole(['user'])" />
                    <MenuPanitia v-if="checkRole(['admin', 'panitia'])" />
                    <MenuVerifikasi v-if="checkRole(['admin', 'panitia'])" />
                    <MenuKeuangan v-if="checkRole(['admin', 'keuangan'])" />
                    <MenuAdmin v-if="checkRole(['admin'])" />
                </div>
            </aside>
            <div
                v-show="isSideBarOpen"
                class="fixed inset-0 z-30 bg-gray-500 opacity-50"
                @click="isSideBarOpen = false"
            />
            <main class="p-4 py-20 md:ml-64">
                <slot />
            </main>
            {{ $page.props.alert }}
            <AlertHandler />
        </div>
    </div>
</template>
