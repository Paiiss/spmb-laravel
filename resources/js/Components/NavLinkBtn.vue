<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Link
        :href="href"
        class="inline-flex items-center px-1 py-2 font-medium text-gray-100 leading-5 hover:bg-gray-500 rounded-lg transition duration-150 ease-in-out"
    >
        <slot />
    </Link>
    <!-- md:inline-flex items-center gap-1 px-3 py-2 rounded-lg font-medium text-gray-100 hover:bg-teal-700 focus:ring-2 focus:ring-teal-500 -->
</template>
