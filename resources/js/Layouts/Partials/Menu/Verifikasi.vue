<script setup>
import ResponsiveSideBar from "@/Components/ResponsiveSideBar.vue";
</script>

<template>
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
                    :active="route().current('admin.verification')"
                    icon="fa-solid fa-book-open"
                >
                    Formulir
                </ResponsiveSideBar>
            </li>
            <li>
                <ResponsiveSideBar
                    :href="route('admin.health-verification')"
                    :active="route().current('admin.health-verification')"
                    icon="fa-solid fa-kit-medical"
                >
                    Kesehatan
                </ResponsiveSideBar>
            </li>
            <li>
                <ResponsiveSideBar
                    :href="route('admin.interview')"
                    :active="route().current('admin.interview')"
                    icon="fa-solid fa-microphone"
                >
                    Wawancara
                </ResponsiveSideBar>
            </li>
            <li>
                <ResponsiveSideBar
                    :href="route('admin.end-validation')"
                    :active="route().current('admin.end-validation')"
                    icon="fa-solid fa-check"
                >
                    Penentuan
                </ResponsiveSideBar>
            </li>
        </ul>
    </div>
</template>
