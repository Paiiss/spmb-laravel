<script setup>
import { AtomSpinner } from "epic-spinners";
import { ref, onMounted } from "vue";

const loading = ref(true);

onMounted(() => {
    setTimeout(() => {
        loading.value = false;
    }, 3000);
});
</script>

<template>
    <div
        class="fixed top-0 z-50 h-screen w-screen flex justify-center items-center bg-white transition-opacity duration-1000 ease-in-out"
        :class="{ 'opacity-0': !loading }"
    >
        <atom-spinner :animation-duration="1000" :size="60" color="#21B1A1" />
    </div>
</template>
