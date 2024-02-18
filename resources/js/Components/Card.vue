<script setup>
defineProps({
    title: {
        type: String,
        default: null,
    },
    description: {
        type: String,
        default: null,
    },
});
</script>

<template>
    <div
        class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex flex-col gap-4"
    >
        <div v-if="title">
            <h1 class="font-bold text-left text-black text-2xl capitalize">
                {{ title }}
            </h1>

            <p v-if="description" class="text-gray-500 dark:text-gray-300">
                {{ description }}
            </p>
        </div>
        <div>
            <slot />
        </div>
    </div>
</template>
