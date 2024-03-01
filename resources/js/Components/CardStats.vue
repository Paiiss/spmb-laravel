<script setup>
import { ref } from "vue";

defineProps({
    label: {
        type: String,
        default: "Label",
    },
    icon: {
        type: String,
        default: "fa-solid fa-question",
    },
    color: {
        type: String,
        default: "gray",
    },
    value: {
        type: Number,
        default: 0,
    },
});
</script>

<template>
    <div
        class="flex items-center justify-between p-4 bg-white rounded-lg shadow-md"
    >
        <div class="p-4 rounded-full mr-4" :class="`bg-${color}-100`">
            <i class="text-4xl" :class="`${icon} text-${color}-500`" />
        </div>
        <div class="flex flex-col justify-center items-center">
            <div
                class="text-2xl font-bold flex w-full justify-end md:justify-center"
            >
                {{ value }}
            </div>
            <div>{{ label }}</div>
        </div>
    </div>
</template>
