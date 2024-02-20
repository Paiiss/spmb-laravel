<script setup>
defineProps({
    label: {
        type: String,
        required: true,
    },
    value: {
        type: String,
        required: false,
    },
});
</script>

<template>
    <div>
        <label class="text-gray-500">{{ label }}</label>
        <p v-if="value" class="font-semibold">
            <span v-if="value">{{ value }}</span>
            <span v-else><slot /></span>
        </p>
    </div>
</template>
