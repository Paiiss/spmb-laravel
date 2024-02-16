<script setup>
import ResponsiveSideBar from "@/Components/ResponsiveSideBar.vue";
</script>

<template>
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
