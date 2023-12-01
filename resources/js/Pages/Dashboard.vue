<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
defineProps({
    user: {
        type: Object,
    },
    isAdmin: {
        type: Boolean,
    },
    isAlreadyForm: {
        type: Boolean,
    },
});

const goToForm = () => {
    return route("form");
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h1 class="font-bold text-2xl">
                            Selamat Datang, {{ $page.props.user.name }}
                        </h1>

                        <p v-if="!isAlreadyForm">
                            Apakah anda akan mendaftar sebagai mahasiswa baru?
                            silahkan klik tombol dibawah ini.
                        </p>
                        <p v-else>Silahkan lanjut mengisi form pendaftaran.</p>
                        <div class="flex justify-start mt-4">
                            <PrimaryButton @click="goToForm"
                                >{{
                                    isAlreadyForm ? "Lanjut" : "Bikin formulir"
                                }}
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ $page.props.user }}
                        {{ isAlreadyForm }}
                        {{ $page.props.isAdmin }}
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
