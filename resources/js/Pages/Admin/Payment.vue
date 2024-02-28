<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Modal from "@/Components/Modal.vue";
import { Head, Link, useForm, usePage, router } from "@inertiajs/vue3";
import { nextTick, ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import DateInput from "@/Components/DateInput.vue";
import Combobox from "@/Components/Combobox.vue";
import TextareaInput from "@/Components/TextareaInput.vue";
import Grid from "@/Components/Grid.vue";
import Display from "@/Components/Display.vue";

defineProps({
    payment: {
        type: Object,
    },
});

const form = useForm({
    status: "", // approved, pending, rejected
    note: "",
});

const dialogIndex = ref(null); // 0 = create, 1 = edit, 2 = delete
const dialog = ref(false);
const dialogItem = ref(null);

const open = (index, item = null) => {
    dialogIndex.value = index;
    dialogItem.value = item;
    dialog.value = true;
    if (index == 1) {
        form.status = item.status;
        form.note = item.note;
    }
};

const close = () => {
    dialog.value = false;
    dialogIndex.value = null;
    dialogItem.value = null;
};

const save = () => {
    if (dialogIndex.value == 0) {
        // create
        // form.post(route("admin.payment.store"));
    } else if (dialogIndex.value == 1) {
        // edit
        form.patch(route("admin.payment.update", dialogItem.value.id), {
            preserveScroll: true,
            onSuccess: () => {
                close();
            },
        });
    } else if (dialogIndex.value == 2) {
        // delete
        form.delete(route("admin.payment.destroy", dialogItem.value.id), {
            preserveScroll: true,
            onSuccess: () => {
                close();
            },
        });
    }
};
</script>

<template>
    <Head title="Setting Prodi" />
    <AuthenticatedLayout>
        <div>
            <div class="max-w-7xl mx-auto">
                <div class="shadow-md sm:shadow-lg p-4 sm:p-8 bg-white">
                    <div
                        class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4"
                    >
                        <header>
                            <h2
                                class="text-lg font-bold text-gray-900 dark:text-gray-100"
                            >
                                Kelola Pembayaran
                            </h2>
                        </header>
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
                                        Nama Rekening
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nomor Rekening
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Jumlah
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Tanggal
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Status
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                    v-for="item in payment.data"
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
                                            new Intl.NumberFormat("id-ID", {
                                                style: "currency",
                                                currency: "IDR",
                                            }).format(item.amount) || 0
                                        }}
                                    </td>
                                    <td class="px-6 py-4 truncate">
                                        {{ item.date }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <i
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
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex gap-2">
                                            <button
                                                @click="open(1, item)"
                                                class="text-indigo-600 hover:text-indigo-900"
                                            >
                                                <i
                                                    class="fa-solid fa-pencil"
                                                ></i>
                                            </button>
                                            <button
                                                @click="open(2, item)"
                                                class="text-red-600 hover:text-red-900"
                                            >
                                                <i
                                                    class="fa-solid fa-trash"
                                                ></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="py-1 px-4">
                        <nav class="flex items-center space-x-1">
                            <button
                                class="min-w-[40px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2.5 text-sm rounded-full disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10"
                                :class="{
                                    'cursor-not-allowed opacity-50':
                                        link.active || !link.url,
                                }"
                                v-for="link in payment.links"
                                :key="link.label"
                                :href="link.url || ''"
                                :disabled="link.active"
                                @click.prevent="router.visit(link.url)"
                            >
                                <span v-html="link.label" class="truncate">
                                </span>
                            </button>
                        </nav>
                    </div>
                </div>
            </div>
            <Modal :show="dialog" @close="close()">
                <div class="p-6">
                    <h2
                        class="text-lg font-medium text-gray-900 dark:text-gray-100"
                    >
                        {{
                            dialogIndex == 0
                                ? "Create"
                                : dialogIndex == 1
                                ? "Kelola Pembayaran"
                                : "Hapus Pembayaran"
                        }}
                    </h2>

                    <div
                        class="mt-6 grid grid-cols-1 gap-4"
                        v-if="dialogIndex != 2"
                    >
                        <div class="col-span-1">
                            <img
                                :src="dialogItem.image"
                                :alt="`Bukti pembayaran ${dialogItem.user_id}`"
                                class="w-full"
                            />
                        </div>

                        <Grid col="2" class="mt-4 mb-6">
                            <Display
                                label="Pilihan Prodi"
                                :value="dialogItem?.prodi.nama_prodi"
                            />
                            <Display
                                label="Pilihan Fakultas"
                                :value="dialogItem?.prodi.fakultas"
                            />
                            <Display
                                label="Biaya Registrasi Prodi"
                                :value="
                                    new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR',
                                    }).format(
                                        dialogItem?.prodi.biaya_registrasi
                                    )
                                "
                            />
                        </Grid>

                        <div class="col-span-1">
                            <InputLabel for="status">Status</InputLabel>
                            <Combobox
                                v-model="form.status"
                                id="status"
                                class="mt-1 block w-full"
                                :option-value="[
                                    { value: 'approved', text: 'Approved' },
                                    { value: 'pending', text: 'Pending' },
                                    { value: 'rejected', text: 'Rejected' },
                                ]"
                            />
                            <InputError
                                :message="form.errors.status"
                            ></InputError>
                        </div>

                        <div class="col-span-1">
                            <InputLabel for="note">Catatan</InputLabel>
                            <TextareaInput
                                v-model="form.note"
                                id="note"
                                class="mt-1 block w-full"
                            />
                            <InputError
                                :message="form.errors.note"
                            ></InputError>
                        </div>
                    </div>
                    <div v-else>
                        <h2
                            class="text-lg font-medium text-gray-900 dark:text-gray-100"
                        >
                            Anda yakin ingin menghapus pembayaran ini?
                        </h2>
                    </div>
                    <div class="mt-6">
                        <PrimaryButton @click="save()">
                            {{
                                dialogIndex == 0
                                    ? "Create"
                                    : dialogIndex == 1
                                    ? "Edit"
                                    : "Delete"
                            }}
                        </PrimaryButton>
                        <SecondaryButton @click="close" class="ml-2">
                            Cancel
                        </SecondaryButton>
                    </div>
                </div>
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>
