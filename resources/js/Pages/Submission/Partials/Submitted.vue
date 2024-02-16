<script setup>
defineProps({
    wave: {
        default: null,
        type: String,
    },
});
</script>

<template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <h2 class="font-bold text-left text-black text-2xl capitalize">
                Pendaftaran
            </h2>
            <p class="text-gray-600 dark:text-gray-400">
                Anda sudah mengajukan pendaftaran untuk tahun ajaran
                <span class="font-semibold">{{ wave.tahun_akademik }}</span
                >, silahkan menunggu proses verifikasi dari admin.
            </p>
        </div>
    </div>
</template>
