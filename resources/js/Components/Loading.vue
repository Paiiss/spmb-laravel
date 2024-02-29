<script setup>
import { DotLottieVue } from "@lottiefiles/dotlottie-vue";

defineProps({
    loading: {
        type: Boolean,
        default: true,
    },
    remove: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <div
        v-if="!remove"
        class="fixed top-0 z-50 h-screen w-screen flex justify-center items-center bg-white opacity-100 transition-opacity duration-1000 ease-in-out cursor-progress"
        :class="{ 'opacity-5': !loading }"
    >
        <DotLottieVue
            style="height: 250px; width: 250px"
            autoplay
            loop
            src="/assets/lottie/loading.lottie"
        />
    </div>
</template>
