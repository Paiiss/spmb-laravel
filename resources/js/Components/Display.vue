<script setup>
defineProps({
    label: {
        type: String,
        required: true,
    },
    value: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <label class="text-gray-500">{{ label }}</label>
    <p class="font-semibold">
        {{ value }}
    </p>
</template>
