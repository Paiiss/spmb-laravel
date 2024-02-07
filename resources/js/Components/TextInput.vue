<script setup>
import { onMounted, ref } from "vue";

defineProps({
    modelValue: {
        type: String,
        required: true,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});

defineEmits(["update:modelValue"]);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        :disabled="disabled"
        :class="{
            'cursor-not-allowed': disabled,
            'bg-gray-100 rounded-md shadow-sm': disabled,
            'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm hover:bg-gray-50 dark:hover:bg-gray-950':
                !disabled,
        }"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        ref="input"
    />
</template>
