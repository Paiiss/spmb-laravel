<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
    icon: {
        type: String,
    },
});

const classes = computed(() =>
    props.active
        ? "flex items-center p-2 text-gray-900 bg-gray-200 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group transition duration-150 ease-in-out"
        : "flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group transition duration-150 ease-in-out"
);
</script>

<template>
    <Link :href="href" :class="classes">
        <i :class="icon"></i> <span class="ms-3"><slot /></span>
    </Link>
</template>
