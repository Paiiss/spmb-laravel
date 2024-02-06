<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage, useForm } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

defineProps({
    interview: {
        type: Object,
        default: {} || null,
    },
    auth: {
        type: Object,
        default: {} || null,
    },
});
</script>

<template>
    <Head title="Wawancara peserta" />
    <AuthenticatedLayout>
        <div>
            <div class="max-w-7xl mx-auto">
                <div
                    class="bg-white dark:bg-gray-800 p-4 sm:p-8 shadow-md rounded-lg sm:shadow-lg"
                >
                    <div
                        class="flex flex-column sm:flex-row flex-wrap items-center justify-between pb-4"
                    >
                        <header>
                            <h2
                                class="text-2xl font-bold text-gray-900 dark:text-gray-100 capitalize"
                            >
                                Wawancara peserta
                            </h2>
                            <p class="text-sm text-gray-400">
                                Wawancara peserta adalah tes yang bertujuan
                                untuk mengukur seberapa jauh pengetahuan
                                seseorang terhadap suatu hal.
                            </p>
                        </header>
                    </div>

                    <div class="flex flex-col gap-4">
                        <div>
                            <div class="capitalize">
                                No Peserta :
                                <span class="font-bold text-baase">{{
                                    interview.no_exam
                                }}</span>
                            </div>

                            <div class="capitalize">
                                Nama Peserta :
                                <span class="font-bold text-baase">{{
                                    auth.user.name
                                }}</span>
                            </div>

                            <div class="capitalize">
                                Email Peserta :
                                <span class="font-bold text-baase">{{
                                    auth.user.email
                                }}</span>
                            </div>
                        </div>

                        <div>
                            <div class="capitalize">
                                status wawancara :
                                <span
                                    :class="{
                                        'text-green-500':
                                            interview.status === 'accepted',
                                        'text-yellow-500':
                                            interview.status === 'pending',
                                        'text-red-500':
                                            interview.status === 'rejected',
                                    }"
                                    class="font-bold text-lg"
                                    >{{ interview.status }}</span
                                >
                            </div>

                            <template v-if="interview.status !== 'pending'">
                                <div class="capitalize">
                                    Tanggal Wawancara :
                                    <span class="font-bold text-baase">{{
                                        interview.interview_date
                                    }}</span>
                                </div>

                                <div class="capitalize">
                                    Di wawancara oleh :
                                    <span class="font-bold text-baase">{{
                                        interview.interviewed_by || ''
                                    }}</span>
                                </div>
                            </template>
                        </div>
                        <div>
                            <header>
                                <h2
                                    class="text-lg font-bold text-gray-500   capitalize"
                                >
                                    Panduan Wawancara
                                </h2>
                                <p class="text-sm text-gray-400">
                                    Berikut adalah panduan wawancara yang harus
                                    diikuti oleh peserta.
                                </p>
                            </header>

                            <div class="mt-4">
                                <p class="text-sm text-gray-400">
                                    <ul
                                        class="list-disc list-inside text-gray-400"
                                    >
                                        <li>
                                            Peserta wajib mengikuti wawancara
                                            sesuai dengan jadwal yang telah
                                            ditentukan.
                                        </li>
                                        <li>
                                            Peserta wajib mengikuti wawancara
                                            dengan sopan dan santun.
                                        </li>
                                        <li>
                                            Peserta wajib mengikuti wawancara
                                            dengan penuh kejujuran.
                                        </li>
                                    </ul>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
