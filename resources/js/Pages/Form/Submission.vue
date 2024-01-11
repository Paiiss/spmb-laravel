<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, Link } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Combobox from "@/Components/Combobox.vue";
import axios from "axios";

defineProps({
    wave: {
        default: null,
    },
    form_status: {
        type: Boolean,
        default: false,
    },
    amount: {
        type: Number,
        default: 0,
    },
    is_paid_registration: {
        default: false,
    },
});
const form = useForm({
    wave: "",
    option: "",
    option_2: "",
}).transform((data) => ({
    wave: data.wave ? parseInt(data.wave) : "",
    option: data.option ? parseInt(data.option) : "",
    option_2: data.option_2 ? parseInt(data.option_2) : null,
}));

const choices = ref([]);
const choicesProdi = ref([]);
onMounted(() => {
    axios
        .get("/api/gelombang")
        .then((response) => {
            choices.value = response.data.data.map((item) => ({
                value: `${item.id}`,
                text: item.gelombang,
            }));
            choices.value.unshift({
                value: "",
                text: "Pilih Gelombang",
            });
        })
        .catch((error) => {
            console.log(error);
        });

    axios.get("/api/program-studi").then((response) => {
        choicesProdi.value = response.data.data.map((item) => ({
            value: `${item.id}`,
            text: item.nama_prodi,
        }));
        choicesProdi.value.unshift({
            value: "",
            text: "Pilih Prodi",
        });
    });
});

const submit = () => {
    form.post(route("form.submission.store"), {
        preserveScroll: true,
        onSuccess: () => {
            // form.reset();
        },
    });
};

const copyToClipboard = (text) => {
    const elem = document.createElement("textarea");
    elem.value = text;
    document.body.appendChild(elem);
    elem.select();
    document.execCommand("copy");
    document.body.removeChild(elem);
    statusCopy.value = true;
    setTimeout(() => {
        statusCopy.value = false;
    }, 3000);
};
const statusCopy = ref(false);
</script>

<template>
    <Head title="Submission" />

    <AuthenticatedLayout>
        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div
                    class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg"
                    v-if="form_status && !is_paid_registration"
                >
                    <h2
                        class="font-bold text-left text-black text-2xl capitalize"
                    >
                        Pembayaran formulir pendaftaran
                    </h2>
                    <p>
                        Anda sudah mengajukan pendaftaran, silahkan melakukan
                        pembayaran formulir untuk melanjutkan proses pendaftaran
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
                        <div class="shadow-md sm:shadow-lg p-4 sm:p-8">
                            <h3
                                class="font-semibold text-left text-black text-xl capitalize"
                            >
                                Informasi Pembayaran
                            </h3>

                            <p>
                                Lakukan pembayaran sebesar
                                <span class="font-semibold text-blue-700">{{
                                    new Intl.NumberFormat("id-ID", {
                                        style: "currency",
                                        currency: "IDR",
                                    }).format(amount)
                                }}</span>
                                ke rekening berikut:
                            </p>

                            <div class="mt-4">
                                <p class="font-semibold text-lg">Bank BTN</p>
                                <p>
                                    <!-- No. Rekening: <span>00323-01-30-000028-7</span> -->
                                </p>

                                <div class="inline-flex items-center gap-x-3">
                                    <div
                                        class="text-sm font-medium text-gray-800 dark:text-white"
                                    >
                                        00323-01-30-000028-7
                                    </div>

                                    <button
                                        type="button"
                                        class="p-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                                        @click="
                                            copyToClipboard('0032301300000287')
                                        "
                                    >
                                        <svg
                                            class="w-4 h-4 group-hover:rotate-6 transition"
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            :class="{
                                                'hidden ': statusCopy,
                                            }"
                                        >
                                            <rect
                                                width="8"
                                                height="4"
                                                x="8"
                                                y="2"
                                                rx="1"
                                                ry="1"
                                            />
                                            <path
                                                d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"
                                            />
                                        </svg>

                                        <svg
                                            class="w-4 h-4 text-blue-600"
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            :class="{
                                                'block ': statusCopy,
                                                hidden: !statusCopy,
                                            }"
                                        >
                                            <polyline points="20 6 9 17 4 12" />
                                        </svg>
                                    </button>
                                </div>
                                <!-- </p> -->
                                <p>A.n YAYASAN HANG TUAH</p>
                            </div>
                        </div>
                        <div class="shadow-md sm:shadow-lg p-4 sm:p-8">
                            <h3
                                class="font-semibold text-left text-black text-xl capitalize"
                            >
                                Catatan Sebelum melakukan pembayaran
                            </h3>

                            <div class="mt-4">
                                <ul
                                    class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400"
                                >
                                    <li>
                                        Apabila pembayaran melalui setor tunai
                                        ke BANK BTN ataupun beda BANK, anda
                                        harus menuliskan kode pembayaran pada
                                        kolom "catatan" atau "berita untuk
                                        penerima" pada slip setoran
                                    </li>
                                    <li>
                                        Untuk pembayaran melalui mesin ATM harus
                                        mengupload struk transfer dengan
                                        menuliskan kode pembayaran pada struk
                                        tersebut
                                    </li>
                                    <li>
                                        Pembayaran dengan SMS BANKING tidak akan
                                        diverifikasi
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end gap-4 mt-4">
                        <Link
                            :href="route('form.payment')"
                            as="button"
                            type="button"
                        >
                            <PrimaryButton
                                >Upload Bukti Pembayaran</PrimaryButton
                            >
                        </Link>
                    </div>
                </div>
                <div
                    class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg"
                    v-else-if="form_status && is_paid_registration"
                >
                    <h2
                        class="font-bold text-gray-900 dark:text-white capitalize text-left text-2xl"
                    >
                        Pendaftaran
                    </h2>
                    <p>
                        Anda sudah mendapatkan akses form pendaftaran, silahkan
                        melakukan pendaftaran dengan mengisi form pendaftaran.
                    </p>
                    <div class="pt-8">
                        <!-- Bikinkan judul untuk panduan pendaftaran -->
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
                                    >, isi sesuai dengan kondisi disabilitas
                                    anda.
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
                                    >, isi sesuai dengan data pendidikan
                                    terakhir anda.
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
                <div
                    class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg"
                    v-else
                >
                    <h2 class="font-bold text-left text-black text-2xl">
                        Pendaftaran
                    </h2>
                    <p>
                        Ajukan pendaftaran untuk mendaftar di gelombang yang
                        tersedia
                    </p>
                    <div class="pt-8">
                        <form @submit.prevent="submit" class="mt-6 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <InputLabel
                                        for="gelombang"
                                        value="Gelombang"
                                    />

                                    <Combobox
                                        id="gelombang"
                                        class="mt-1 block w-full"
                                        v-model="form.wave"
                                        :option-value="choices"
                                        :placeholder="'Pilih Gelombang'"
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.wave"
                                    />
                                </div>
                                <div>
                                    <InputLabel
                                        for="pilihan_1"
                                        value="Pilihan 1"
                                    />

                                    <Combobox
                                        id="pilihan_1"
                                        class="mt-1 block w-full"
                                        v-model="form.option"
                                        :option-value="choicesProdi"
                                        :placeholder="'Pilih Prodi'"
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.option"
                                    />
                                </div>
                                <div>
                                    <InputLabel
                                        for="pilihan_2"
                                        value="Pilihan 2"
                                    />

                                    <Combobox
                                        id="pilihan_2"
                                        class="mt-1 block w-full"
                                        v-model="form.option_2"
                                        :option-value="choicesProdi"
                                        :placeholder="'Pilih Prodi'"
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.option_2"
                                    />
                                </div>
                            </div>
                            <div class="flex justify-end gap-4">
                                <Transition
                                    enter-active-class="transition ease-in-out"
                                    enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out"
                                    leave-to-class="opacity-0"
                                >
                                    <p
                                        v-if="form.recentlySuccessful"
                                        class="text-sm text-gray-600 dark:text-gray-400 items-center flex gap-2"
                                    >
                                        Berhasil mengajukan
                                    </p>
                                </Transition>
                                {{ form }}
                                <PrimaryButton :disabled="form.processing"
                                    >Daftar</PrimaryButton
                                >
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
