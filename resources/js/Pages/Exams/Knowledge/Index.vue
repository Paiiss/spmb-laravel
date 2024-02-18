<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage, useForm } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import TextInput from "@/Components/TextInput.vue";
import NumberInput from "@/Components/NumberInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Combobox from "@/Components/Combobox.vue";
import TextareaInput from "@/Components/TextareaInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";

defineProps({
    ujian: Array,
    perlu_ujian: {
        type: Boolean,
        default: false,
    },
});

const confirmStartExam = ref(false);

const form = useForm({});
const items = ref(null);

const checkTime = (exam) => {
    const now = new Date();
    const startTime = new Date(
        now.getFullYear(),
        now.getMonth(),
        now.getDate(),
        exam.access_start_time.split(":")[0],
        exam.access_start_time.split(":")[1]
    );
    const endTime = new Date(
        now.getFullYear(),
        now.getMonth(),
        now.getDate(),
        exam.access_end_time.split(":")[0],
        exam.access_end_time.split(":")[1]
    );
    return now >= startTime && now <= endTime;
};

const open = (exam) => {
    confirmStartExam.value = true;
    items.value = exam;
};

const start = (exam) => {
    confirmStartExam.value = true;
    form.post(route("exams.knowledge.start", exam.id), {
        preserveScroll: true,
        onSuccess: () => {},
    });
};

const close = () => {
    confirmStartExam.value = false;
    items.value = null;
};
</script>

<template>
    <Head title="Tes Pengetahuan" />
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
                                Tes Pengetahuan
                            </h2>
                            <p class="text-sm text-gray-400">
                                Tes pengetahuan adalah tes yang bertujuan untuk
                                mengukur seberapa jauh pengetahuan seseorang
                                terhadap suatu hal.
                            </p>
                        </header>
                    </div>
                    <div
                        class="relative overflow-x-auto shadow-md sm:rounded-lg"
                    >
                        <table
                            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                        >
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                            >
                                <tr>
                                    <th scope="col" class="px-3 py-3">NO</th>
                                    <th scope="col" class="px-6 py-3 w-1/2">
                                        Pelajaran
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-center"
                                    >
                                        Status
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-center"
                                    >
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                    v-for="(exam, index) in ujian"
                                    :key="index"
                                >
                                    <td class="w-4 p-4">
                                        {{ index + 1 }}
                                    </td>
                                    <th
                                        scope="row"
                                        class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white"
                                    >
                                        <div>
                                            <div class="text-sm font-medium">
                                                {{ exam.name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ exam.description }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                jumlah soal:
                                                {{ exam.questions_count }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                waktu:
                                                {{ exam.duration }} menit
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                waktu akses:
                                                {{ exam.access_start_time }} -
                                                {{ exam.access_end_time }}
                                            </div>
                                            <div
                                                v-if="exam.score"
                                                class="text-xs text-gray-500"
                                            >
                                                Nilai: {{ exam.score }}
                                            </div>
                                        </div>
                                    </th>
                                    <td class="px-6 py-4">
                                        <div
                                            class="flex items-center justify-center"
                                        >
                                            <span
                                                :class="{
                                                    'bg-blue-600 text-white dark:bg-blue-500':
                                                        exam.is_end,
                                                    'bg-red-600 text-white dark:bg-red-500':
                                                        !exam.is_end,
                                                }"
                                                class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium whitespace-nowrap"
                                                >{{
                                                    exam.is_end
                                                        ? "SELESAI"
                                                        : "BELUM DI KERJAKAN"
                                                }}</span
                                            >
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-3">
                                            <button
                                                class="inline-block rounded px-4 py-2 text-xs font-medium text-white whitespace-nowrap"
                                                :disabled="
                                                    !checkTime(exam) ||
                                                    !exam.can_start
                                                "
                                                :class="{
                                                    'bg-blue-600 hover:bg-blue-700':
                                                        checkTime(exam) &&
                                                        exam.can_start,
                                                    'bg-gray-400 cursor-not-allowed':
                                                        !checkTime(exam) ||
                                                        !exam.can_start,
                                                }"
                                                @click="
                                                    checkTime(exam)
                                                        ? open(exam)
                                                        : null
                                                "
                                            >
                                                {{
                                                    exam.is_end
                                                        ? "SELESAI"
                                                        : checkTime(exam)
                                                        ? "MULAI"
                                                        : "BELUM WAKTU"
                                                }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div
                        v-if="ujian.length === 0"
                        class="flex items-center justify-center p-4"
                    >
                        <p
                            class="text-gray-500 dark:text-gray-400"
                            v-if="!perlu_ujian"
                        >
                            Anda merupakan siswa berprestasi, tidak perlu
                            mengerjakan ujian
                        </p>
                        <p class="text-gray-500 dark:text-gray-400" v-else>
                            Tidak ada ujian yang perlu dikerjakan
                        </p>
                    </div>
                </div>
            </div>
            <Modal :show="confirmStartExam" @close="close()">
                <div class="p-6">
                    <h2
                        class="text-xl font-medium text-gray-900 dark:text-gray-100"
                    >
                        Konfirmasi Mulai Tes
                    </h2>

                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        Apakah anda yakin ingin memulai tes ini?
                    </p>

                    <div class="mt-4 flex justify-end gap-2">
                        <PrimaryButton @click="start(items)">
                            Mulai
                        </PrimaryButton>
                        <SecondaryButton @click="close()">
                            Batal
                        </SecondaryButton>
                    </div>
                </div>
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>
