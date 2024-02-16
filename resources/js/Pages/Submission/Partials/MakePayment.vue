<script setup>
import { ref, onMounted } from "vue";
import { usePage, Link } from "@inertiajs/vue3";

import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps({
    wave: Object,
    amount: Number,
    code: String,
});

const copyToClipboard = (text) => {
    const elem = document.createElement("textarea");
    elem.value = text.replace(/ |-/g, "");
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
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <h2 class="font-bold text-left text-black text-2xl capitalize">
                Pembayaran formulir pendaftaran
            </h2>
            <p>
                Anda sudah mengajukan pendaftaran untuk tahun ajaran
                <span class="font-semibold">{{ wave.tahun_akademik }}</span
                >, silahkan melakukan pembayaran formulir untuk melanjutkan
                proses pendaftaran
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
                        <p class="font-semibold text-lg">
                            {{ $page.props.web_settings.payment_bank }}
                        </p>

                        <div class="inline-flex items-center gap-x-3">
                            <div
                                class="text-sm font-medium text-gray-800 dark:text-white"
                            >
                                {{ $page.props.web_settings.payment_account }}
                            </div>

                            <button
                                type="button"
                                class="p-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                                @click="
                                    copyToClipboard(
                                        $page.props.web_settings.payment_account
                                    )
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
                        <p>A.n YAYASAN HANG TUAH</p>
                        <p class="mt-4">
                            <span class="font-semibold text-base"
                                >Kode Pembayaran:
                            </span>
                            <span class="font-semibold text-blue-700">{{
                                code
                            }}</span>
                        </p>
                        <div class="flex justify-end gap-4 mt-8">
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
                                Apabila pembayaran melalui setor tunai ke BANK
                                BTN ataupun beda BANK, anda harus menuliskan
                                kode pembayaran pada kolom "catatan" atau
                                "berita untuk penerima" pada slip setoran
                            </li>
                            <li>
                                Untuk pembayaran melalui mesin ATM harus
                                mengupload struk transfer dengan menuliskan kode
                                pembayaran pada struk tersebut
                            </li>
                            <li>
                                Pembayaran dengan SMS BANKING tidak akan
                                diverifikasi
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
