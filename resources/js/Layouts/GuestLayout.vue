<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div
        class="min-h-screen flex flex-col items-center justify-center pt-6 bg-gray-100 dark:bg-gray-900"
    >
        <div>
            <Link href="/" class="flex flex-col items-center gap-2">
                <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
                <span class="text-2xl font-bold leading-9 text-center">
                    {{ $page.props.web_settings.institution_name }}
                </span>
            </Link>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
