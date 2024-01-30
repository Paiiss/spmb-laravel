<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div class="min-h-screen">
        <nav class="bg-white sticky top-0 shadow-md">
            <div
                class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between"
            >
                <div class="flex flex-row">
                    <div class="flex-shrink-0 flex items-center gap-3">
                        <Link href="/">
                            <ApplicationLogo class="block h-9 w-auto" />
                        </Link>
                        <h1
                            class="border-l-2 text-lg inline-flex items-center font-bold text-black px-3 leading-relaxed capitalize"
                        >
                            {{ $page.props.web_settings.title_exam }}
                        </h1>
                    </div>
                </div>
            </div>
        </nav>
        <main class="p-4 py-10">
            <slot />
        </main>
    </div>
</template>
