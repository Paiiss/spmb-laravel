<script setup>
defineProps({
    icon: {
        type: String,
        default: "fas fa-plus",
    },
    color: {
        type: String,
        default: "blue",
    },
});
</script>

<template>
    <button
        class="flex items-center justify-center w-8 h-8 rounded-full"
        :class="`text-${color}-500 dark:bg-${color}-500/10 dark:text-${color}-400`"
    >
        <i :class="`${icon}`"></i>
    </button>
</template>
