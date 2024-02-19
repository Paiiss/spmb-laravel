<script setup>
import { usePage, router } from "@inertiajs/vue3";
const prop = defineProps({
    pages: {
        type: Array,
        required: true,
    },
    type: {
        type: String,
        default: "visit",
    },
});

const handleAction = (page, t) => {
    if (prop.type === "visit") {
        router.visit(page.url);
    }
};
</script>

<template>
    <nav aria-label="Page navigation example">
        <ul class="inline-flex -space-x-px">
            <li v-for="(link, index) in pages" :key="link.label">
                <button
                    class="flex items-center justify-center px-3 h-8 leading-tight"
                    :class="{
                        'cursor-not-allowed': link.active || link.url === null,
                        'text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white':
                            link.active === false && link.url !== null,
                        'text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white':
                            link.active === true,

                        'ms-0 border border-e-0 rounded-s-lg': index === 0,
                        'me-0 border-e-0 rounded-e-lg':
                            index === pages.length - 1,
                    }"
                    :disabled="link.active || link.url === null"
                    @click.prevent="handleAction(link)"
                >
                    <span v-html="link.label" class="truncate" />
                </button>
            </li>
        </ul>
    </nav>
</template>
