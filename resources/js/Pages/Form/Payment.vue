<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref } from "vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
import DateInput from "@/Components/DateInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";
import FileInput from "@/Components/FileInput.vue";
import Combobox from "@/Components/Combobox.vue";

defineProps({
    payment: Object,
});

const dialog = ref(false);
const dialogType = ref(null); // 0 = add, 1 = edit, 2 = delete
const dialogItem = ref(null); // id payment for update or delete

const form = useForm({
    image: null,
    bank: "",
    date: "",
    account_name: "",
    account_number: "",
    amount: "",
    type_payment: "form",
    code: "",
});

const open = (i = 0, item = null) => {
    dialogType.value = i;
    dialog.value = true;
    if (i !== 0) dialogItem.value = item;
    if (i == 1) {
        form.bank = payment.bank;
        form.account_name = payment.account_name;
        form.account_number = payment.account_number;
        form.amount = payment.amount;
        form.date = payment.date;
        form.type_payment = payment.type_payment;
    }
};

const save = () => {
    if (dialogType.value == 0) {
        form.post(route("form.payment.store"), {
            preserveScroll: true,
            onSuccess: () => close(),
            // onFinish: () => form.reset(),
        });
    } else if (dialogType.value == 1) {
        form.put(route("form.payment.update", dialogItem.value));
    } else {
        form.delete(route("form.payment.destroy", dialogItem.value), {
            preserveScroll: true,
            onSuccess: () => close(),
            onFinish: () => form.reset(),
        });
    }
};

const close = () => {
    dialog.value = false;
    dialogType.value = null;
    dialogItem.value = null;
    form.image = null;
    form.reset();
};
</script>

<template>
    <Head title="Bukti Pembayaran" />

    <AuthenticatedLayout>
        <div>
            <div
                class="max-w-7xl mx-auto bg-white shadow-md sm:shadow-lg p-4 sm:p-8"
            >
                <div
                    class="flex flex-column sm:flex-grow flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4"
                >
                    <header
                        class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                    >
                        Bukti pembayaran
                    </header>
                    <PrimaryButton @click="open()">Upload</PrimaryButton>
                </div>
                <div class="relative overflow-x-auto">
                    <table
                        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                    >
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                        >
                            <tr>
                                <th scope="col" class="px-6 py-3">Bank</th>
                                <th scope="col" class="px-6 py-3">
                                    Pemilik Rekening
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nomor Rekening
                                </th>
                                <th scope="col" class="px-6 py-3">Jumlah</th>
                                <th scope="col" class="px-6 py-3">Tanggal</th>
                                <th scope="col" class="px-6 py-3">Jenis</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                v-for="item in payment"
                                :key="item.id"
                            >
                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                >
                                    {{ item.bank }}
                                </th>

                                <td class="px-6 py-4 truncate">
                                    {{ item.account_name }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ item.account_number }}
                                </td>
                                <td class="px-6 py-4">
                                    {{
                                        item.amount == "-"
                                            ? "-"
                                            : new Intl.NumberFormat("id-ID", {
                                                  style: "currency",
                                                  currency: "IDR",
                                              }).format(item.amount)
                                    }}
                                </td>
                                <td class="px-6 py-4 truncate">
                                    {{ item.date }}
                                </td>
                                <td class="px-6 py-4 truncate">
                                    <span v-if="item.type_payment !== '-'">
                                        {{
                                            item.type_payment == "form"
                                                ? "Formulir"
                                                : "Pendaftaran"
                                        }}
                                    </span>
                                    <span v-else>-</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div
                                        class="flex items-center justify-center"
                                    >
                                        <i
                                            v-if="item.status !== '-'"
                                            class="fas fa-circle"
                                            :class="{
                                                'text-green-500':
                                                    item.status == 'approved',
                                                'text-yellow-500':
                                                    item.status == 'pending',
                                                'text-red-500':
                                                    item.status == 'rejected',
                                            }"
                                        >
                                        </i>
                                        <span v-else>-</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4" v-if="item.bank !== '-'">
                                    <button
                                        v-if="item.status == 'pending'"
                                        @click="open(2, item.id)"
                                        class="text-red-600 hover:text-red-900"
                                    >
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                    <button
                                        v-else
                                        @click="open(4, item)"
                                        class="text-blue-600 hover:text-blue-900"
                                    >
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </td>
                                <td class="px-6 py-4 flex gap-2" v-else>-</td>
                            </tr>
                        </tbody>
                    </table>
                    <div
                        v-if="payment.length === 0"
                        class="flex items-center justify-center p-4"
                    >
                        <p
                            class="text-gray-500 dark:text-gray-400 text-xs md:text-base"
                        >
                            Kamu belum mengupload bukti pembayaran
                        </p>
                    </div>
                </div>
                <Modal :show="dialog" @close="close">
                    <div class="p-6">
                        <h2
                            class="text-lg font-medium text-gray-900 dark:text-gray-100"
                        >
                            {{
                                dialogType == 0
                                    ? "Upload"
                                    : dialogType == 1
                                    ? "Edit"
                                    : dialogType == 2
                                    ? "Hapus"
                                    : "Detail"
                            }}
                            bukti pembayaran
                        </h2>
                        <div class="py-2">
                            <p class="text-gray-500">
                                {{
                                    dialogType == 0
                                        ? "Silahkan upload bukti pembayaran dibawah ini."
                                        : dialogType == 1
                                        ? "Silahkan edit bukti pembayaran dibawah ini."
                                        : dialogType == 2
                                        ? "Apakah anda yakin ingin menghapus bukti pembayaran ini?"
                                        : "Berikut adalah detail bukti pembayaran."
                                }}
                            </p>
                        </div>

                        <div class="mt-6 space-y-6">
                            <div
                                class="grid grid-cols-2 md:grid-cols-4 gap-4"
                                v-if="dialogType !== 2 && dialogType !== 4"
                            >
                                <div class="col-span-1 md:col-span-2">
                                    <InputLabel for="bank" value="Bank" />

                                    <TextInput
                                        id="bank"
                                        class="mt-1 block w-full"
                                        v-model="form.bank"
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.bank"
                                    />
                                </div>

                                <div class="col-span-1 md:col-span-2">
                                    <InputLabel
                                        for="account_number"
                                        value="Nomor rekening"
                                    />

                                    <TextInput
                                        id="account_number"
                                        class="mt-1 block w-full"
                                        v-model="form.account_number"
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.account_number"
                                    />
                                </div>

                                <div class="col-span-2 md:col-span-4">
                                    <InputLabel
                                        for="account_name"
                                        value="Nama pemilik rekening"
                                    />

                                    <TextInput
                                        id="account_name"
                                        class="mt-1 block w-full"
                                        v-model="form.account_name"
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.account_name"
                                    />
                                </div>

                                <div class="col-span-1 md:col-span-2">
                                    <InputLabel
                                        for="date"
                                        value="Tanggal pembayaran"
                                    />

                                    <DateInput
                                        id="date"
                                        ref="date"
                                        v-model="form.date"
                                        class="mt-1 block w-full"
                                        placeholder="Tanggal pembayaran"
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.date"
                                    />
                                </div>
                                <div class="col-span-1 md:col-span-2">
                                    <InputLabel
                                        for="amount"
                                        value="Nominal pembayaran"
                                        class="overflow-x-hidden"
                                    />

                                    <TextInput
                                        id="amount"
                                        class="mt-1 block w-full [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                        type="number"
                                        v-model="form.amount"
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.amount"
                                    />
                                </div>
                                <div class="col-span-1 md:col-span-2">
                                    <InputLabel
                                        for="code"
                                        value="Kode pembayaran"
                                    />

                                    <TextInput
                                        id="code"
                                        class="mt-1 block w-full"
                                        v-model="form.code"
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.code"
                                    />
                                </div>
                                <div class="col-span-1 md:col-span-2">
                                    <InputLabel
                                        for="type_payment"
                                        value="Jenis pembayaran"
                                    />

                                    <Combobox
                                        id="type_payment"
                                        class="mt-1 block w-full"
                                        v-model="form.type_payment"
                                        placeholder="Pilih Jenis Pembayaran"
                                        :option-value="[
                                            {
                                                value: 'form',
                                                text: 'Formulir',
                                            },
                                            {
                                                value: 'registration',
                                                text: 'Registrasi',
                                            },
                                        ]"
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.type_payment"
                                    />
                                </div>
                                <div class="col-span-2 md:col-span-4">
                                    <InputLabel
                                        for="image"
                                        value="Bukti pembayaran"
                                    />
                                    <FileInput
                                        id="image"
                                        class="my-2 block w-full text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                        v-model="form.image"
                                        accept="image/*"
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.image"
                                    />
                                </div>
                            </div>

                            <div
                                class="grid grid-cols-1"
                                v-else-if="dialogType !== 2"
                            >
                                <div class="flex items-center justify-center">
                                    <img
                                        :src="dialogItem.image"
                                        alt=""
                                        class="max-h-60"
                                    />
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <p class="text-gray-500">
                                        <span class="font-semibold"
                                            >Status:</span
                                        >
                                        {{
                                            dialogItem.status == "approved"
                                                ? "Disetujui"
                                                : dialogItem.status == "pending"
                                                ? "Menunggu"
                                                : "Ditolak"
                                        }}
                                    </p>
                                    <p class="text-gray-500">
                                        <span class="font-semibold">Kode:</span>
                                        {{ dialogItem.code }}
                                    </p>
                                    <p
                                        class="text-gray-500"
                                        v-if="dialogItem.note"
                                    >
                                        <span class="font-semibold"
                                            >Catatan:</span
                                        >
                                        {{ dialogItem.note }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex justify-end gap-4">
                                <SecondaryButton @click="close" class="ml-2">
                                    close
                                </SecondaryButton>
                                <PrimaryButton
                                    v-if="dialogType !== 4"
                                    @click="save()"
                                    >{{
                                        dialogType == 0
                                            ? "create"
                                            : dialogType == 1
                                            ? "update"
                                            : "delete"
                                    }}</PrimaryButton
                                >
                            </div>
                        </div>
                    </div>
                </Modal>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
