<script setup>
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Link, useForm } from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import Container from "@/Components/Container.vue";
import Card from "@/Components/Card.vue";

defineProps({
    wave: {
        default: null,
    },
    percent: Object,
    status: {
        default: null,
        type: String,
    },
    note: {
        default: null,
        type: String,
    },
});

const modal = ref(false);

const progressName = {
    personal: "Data Diri",
    address: "Alamat Rumah",
    education: "Pendidikan",
    parent: "Orang Tua",
    document: "Dokumen",
};

const form = useForm({});

const verification = () => {
    form.post(route("form.validation"), {
        preserveScroll: true,
        onFinish: () => {
            modal.value = false;
        },
    });
};
</script>

<template>
    <Container>
        <Card
            title="Pendaftaran"
            description="Anda sudah mendapatkan akses form pendaftaran tahun ajaran, silahkan melakukan pendaftaran dengan mengisi form pendaftaran."
        >
            <div class="pt-8 flex flex-col gap-5">
                <div
                    class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg"
                >
                    <h3
                        class="font-semibold text-gray-900 dark:text-white capitalize text-left text-xl"
                    >
                        Panduan Pendaftaran
                    </h3>
                    <ol
                        class="relative border-s border-gray-200 dark:border-gray-700"
                    >
                        <li class="mb-10 ms-4">
                            <div
                                class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"
                            ></div>
                            <time
                                class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500"
                                >Langkah pertama</time
                            >
                            <h3
                                class="text-lg font-semibold text-gray-900 dark:text-white"
                            >
                                Isi data diri
                            </h3>
                            <p
                                class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400"
                            >
                                Lengkapi data diri anda pada menu
                                <Link
                                    :href="
                                        route('form.edit', {
                                            id: 'personal',
                                        })
                                    "
                                    class="text-blue-600 hover:underline"
                                    >data diri</Link
                                >, isi sesuai dengan identitas diri anda.
                            </p>
                        </li>
                        <li class="mb-10 ms-4">
                            <div
                                class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"
                            ></div>
                            <time
                                class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500"
                                >Langkah kedua</time
                            >
                            <h3
                                class="text-lg font-semibold text-gray-900 dark:text-white"
                            >
                                Isi form disabilitas
                            </h3>
                            <p
                                class="text-base font-normal text-gray-500 dark:text-gray-400"
                            >
                                Lengkapi data kesehatan pada menu
                                <Link
                                    :href="
                                        route('form.edit', {
                                            id: 'disability',
                                        })
                                    "
                                    class="text-blue-600 hover:underline"
                                    >disabilitas</Link
                                >, isi sesuai dengan kondisi disabilitas anda.
                            </p>
                        </li>
                        <li class="mb-10 ms-4">
                            <div
                                class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"
                            ></div>
                            <time
                                class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500"
                                >Langkah ketiga</time
                            >
                            <h3
                                class="text-lg font-semibold text-gray-900 dark:text-white"
                            >
                                Isi data pendidikan terakhir
                            </h3>
                            <p
                                class="text-base font-normal text-gray-500 dark:text-gray-400"
                            >
                                Lengkapi data pendidikan terakhir pada menu
                                <Link
                                    :href="
                                        route('form.edit', {
                                            id: 'education',
                                        })
                                    "
                                    class="text-blue-600 hover:underline"
                                    >pendidikan</Link
                                >, isi sesuai dengan data pendidikan terakhir
                                anda.
                            </p>
                        </li>
                        <li class="ms-4">
                            <div
                                class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"
                            ></div>
                            <time
                                class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500"
                                >Langkah keempat</time
                            >
                            <h3
                                class="text-lg font-semibold text-gray-900 dark:text-white"
                            >
                                Isi data orang tua
                            </h3>
                            <p
                                class="text-base font-normal text-gray-500 dark:text-gray-400"
                            >
                                Lengkapi data orang tua pada menu
                                <Link
                                    :href="
                                        route('form.edit', {
                                            id: 'parent',
                                        })
                                    "
                                    class="text-blue-600 hover:underline"
                                    >orang tua</Link
                                >, isi sesuai dengan data orang tua anda.
                            </p>
                        </li>
                    </ol>
                </div>
            </div>
        </Card>

        <Card
            title="Progres Pendaftaran"
            description="Jika anda sudah mengisi semua data yang dibutuhkan untuk pendaftaran, silahkan mengajukan verifikasi dengan mengklik tombol dibawah ini."
        >
            <div
                v-if="status == 'rejected' && note"
                class="bg-yellow-50 dark:bg-yellow-800 border-l-4 border-yellow-400 p-4 rounded-lg my-4"
            >
                <h4
                    class="flex items-center text-lg font-semibold text-yellow-600 dark:text-yellow-400"
                >
                    <i
                        class="fa-solid fa-exclamation-triangle text-yellow-400"
                    ></i>
                    <span class="ml-2">Perhatian</span>
                </h4>

                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    {{ note }}
                </p>
            </div>

            <div class="pt-8 flex flex-col gap-3">
                <div v-for="(value, key) in percent" :key="key">
                    <div class="mb-2 flex justify-between items-center">
                        <h3
                            class="text-sm font-semibold text-gray-800 dark:text-white capitalize"
                        >
                            {{ progressName[key] }}
                        </h3>
                        <span class="text-sm text-gray-800 dark:text-white"
                            >{{ value.toFixed(0) }}%</span
                        >
                    </div>
                    <div
                        class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-gray-700"
                        role="progressbar"
                    >
                        <div
                            class="flex flex-col justify-center rounded-full overflow-hidden bg-teal-600 text-xs text-white text-center whitespace-nowrap transition duration-500 dark:bg-teal-500"
                            :style="`width: ${value}%`"
                        ></div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-8">
                <PrimaryButton @click="modal = true"
                    >Ajukan Verifikasi</PrimaryButton
                >
            </div>
        </Card>

        <Modal :show="modal" @close="modal = false">
            <div class="p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                    Ajukan Verifikasi
                </h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Sebelum mengajukan verifikasi, pastikan bahwa data yang Anda
                    isi sudah benar dan sesuai dengan data diri Anda. Jika sudah
                    yakin, silakan klik tombol di bawah ini.
                </p>

                <p
                    class="mt-4 text-red-500 dark:text-red-400 text-sm font-semibold"
                >
                    Harap dicatat bahwa setelah Anda mengumpulkan, Anda tidak
                    akan dapat mengganti data yang sudah diserahkan.
                </p>

                <div class="flex justify-end gap-4">
                    <SecondaryButton @click="modal = false" class="ml-2">
                        tutup
                    </SecondaryButton>
                    <PrimaryButton @click="verification">
                        Ajukan Verifikasi
                    </PrimaryButton>
                </div>
            </div>
        </Modal>
    </Container>
</template>
