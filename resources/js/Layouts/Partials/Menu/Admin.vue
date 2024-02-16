<script setup>
import ResponsiveSideBar from "@/Components/ResponsiveSideBar.vue";
</script>

<template>
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
                    :href="route('admin.user')"
                    :active="route().current('admin.user')"
                    icon="fa-solid fa-users"
                >
                    User
                </ResponsiveSideBar>
            </li>
            <li>
                <ResponsiveSideBar
                    :href="route('admin.web-setting')"
                    :active="route().current('admin.web-setting')"
                    icon="fa-solid fa-cog"
                >
                    Web Setting
                </ResponsiveSideBar>
            </li>
        </ul>
    </div>
</template>
