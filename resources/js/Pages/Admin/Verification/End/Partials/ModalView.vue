<script setup>
import Display from "@/Components/Display.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { ref } from "vue";

defineProps({
    item: Object,
    close: Function,
});
</script>

<template>
    <div class="p-6">
        <h1 class="text-2xl font-semibold">Formulir</h1>
        <div class="mt-4 flex flex-col gap-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <Display label="Nama" :value="item.form.name" />
                </div>
                <div>
                    <Display label="Email" :value="item.form.email" />
                </div>
                <div>
                    <Display label="No. Hp" :value="item.form.phone" />
                </div>
                <div>
                    <Display
                        label="Nomor Pendaftaran"
                        :value="item.form?.no_exam"
                    />
                </div>
                <div>
                    <Display label="Nilai Akhir" :value="item.form.grade" />
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <Display
                        label="Pilihan Prodi"
                        :value="item.prodi?.nama_prodi"
                    />
                </div>
                <div>
                    <Display
                        label="Status Formulir"
                        :value="item.form?.status"
                    />
                </div>
            </div>

            <div
                v-if="item.prodi.tes_kesehatan"
                class="border-2 border-gray-200 dark:border-gray-700 rounded-lg p-4 mt-4"
            >
                <label
                    class="block text-xl font-medium text-gray-700 border-b-2 border-gray-200 dark:text-gray-300"
                >
                    Kesehatan
                </label>
                <div class="flex flex-col gap-3">
                    <div>
                        <Display label="Status" :value="item.health?.status" />
                    </div>
                    <div>
                        <Display
                            label="Catatan Admin"
                            :value="item.health?.admin_note"
                        />
                    </div>
                </div>
            </div>

            <div
                v-if="item.prodi.tes_wawancara"
                class="border-2 border-gray-200 dark:border-gray-700 rounded-lg p-4 mt-4"
            >
                <label
                    class="block text-xl font-medium text-gray-700 border-b-2 border-gray-200 dark:text-gray-300"
                >
                    Inteview
                </label>
                <div class="flex flex-col gap-3">
                    <div>
                        <Display
                            label="Status"
                            :value="item.interview?.status"
                        />
                    </div>
                    <div>
                        <Display
                            label="Catatan Admin"
                            :value="item.interview?.note"
                        />
                    </div>
                </div>
            </div>
            <div
                v-if="item.prodi.tes_ujian"
                class="border-2 border-gray-200 dark:border-gray-700 rounded-lg p-4 mt-4"
            >
                <label
                    class="block text-xl font-medium text-gray-700 border-b-2 border-gray-200 dark:text-gray-300"
                >
                    Ujian
                </label>
                <div class="mt-8">
                    <div class="relative overflow-x-auto">
                        <table
                            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                        >
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                            >
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Nama Ujian
                                    </th>
                                    <th scope="col" class="px-6 py-3">Score</th>
                                </tr>
                            </thead>
                            <tbody
                                v-if="
                                    item.form.grade < item.prodi.nilai_dibawah
                                "
                            >
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                    v-for="(i, index) in item.exam"
                                    :key="index"
                                >
                                    <th
                                        scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    >
                                        {{ i.exam?.name }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ i?.score }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="mt-4">
                            <div
                                v-if="
                                    item.form.grade &&
                                    item.form.grade > item.prodi.nilai_dibawah
                                "
                                class="flex items-center justify-center p-4"
                            >
                                <p class="text-gray-500 dark:text-gray-400">
                                    Nilai diatas batas minimal
                                </p>
                            </div>
                            <div
                                v-else-if="
                                    item.prodi.ujian &&
                                    item.prodi.ujian?.split(',').length >
                                        item.exam.length
                                "
                                class="flex items-center justify-center p-4"
                            >
                                <p class="text-gray-500 dark:text-gray-400">
                                    Ada
                                    {{
                                        item.prodi.ujian?.split(",").length -
                                        item.exam.length
                                    }}
                                    ujian yang belum dikerjakan
                                </p>
                            </div>
                            <div
                                v-else-if="item.exam.length === 0"
                                class="flex items-center justify-center p-4"
                            >
                                <p class="text-gray-500 dark:text-gray-400">
                                    Tidak ada data
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 flex justify-end">
            <SecondaryButton @click="close"> Tutup </SecondaryButton>
        </div>
    </div>
</template>
