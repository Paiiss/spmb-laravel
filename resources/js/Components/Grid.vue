<script setup>
import { computed } from "vue";

const props = defineProps({
    col: {
        type: String,
        default: "1",
    },
    sm: {
        type: String,
        default: null,
    },
    md: {
        type: String,
        default: null,
    },
    lg: {
        type: String,
        default: null,
    },
    xl: {
        type: String,
        default: null,
    },
    gap: {
        type: String,
        default: "4",
    },
});

const className = computed(() => {
    return [
        "grid",
        `grid-cols-${props.col}`,
        props.sm ? `sm:grid-cols-${props.sm}` : "",
        props.md ? `md:grid-cols-${props.md}` : "",
        props.lg ? `lg:grid-cols-${props.lg}` : "",
        props.xl ? `xl:grid-cols-${props.xl}` : "",
        `gap-${props.gap}`,
    ];
});
</script>

<template>
    <div :class="className">
        <slot />
    </div>
</template>
