<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Modal from "@/Components/Modal.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { nextTick, ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import DateInput from "@/Components/DateInput.vue";
import Combobox from "@/Components/Combobox.vue";

defineProps({
    payment: {
        type: Object,
    },
});

const form = useForm({
    gelombang: "",
    tahun_akademik: "",
    awal_daftar: "",
    akhir_daftar: "",
    tes_tulis: "",
    tes_kesehatan: "",
    wawancara: "",
    active: "false",
}).transform((data) => ({
    ...data,
    active: data.active == "true" ? true : false,
}));

const dialogIndex = ref(null); // 0 = create, 1 = edit, 2 = delete
const dialog = ref(false);
const dialogItem = ref(null);
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
                                class="text-lg font-medium text-gray-900 dark:text-gray-100"
                            >
                                Payment
                            </h2>
                        </header>
                        <PrimaryButton @click="openDialog(0)">
                            Create</PrimaryButton
                        >
                    </div>
                    {{ payment }}
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
                                    <td class="px-6 py-4">
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
                                    <td class="px-6 py-4">
                                        {{ item.date }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <i
                                            class="fas fa-circle"
                                            :class="{
                                                'text-green-500':
                                                    item.status == 'success',
                                                'text-yellow-500':
                                                    item.status == 'pending',
                                                'text-red-500':
                                                    item.status == 'failed',
                                            }"
                                        >
                                        </i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <Modal :show="dialog" @close="close()">
                <div class="p-6">
                    <h2
                        class="text-lg font-medium text-gray-900 dark:text-gray-100"
                    >
                        {{
                            itemIndex == 0
                                ? "Create"
                                : itemIndex == 1
                                ? "Edit"
                                : "Delete"
                        }}
                    </h2>

                    <div
                        class="mt-6 grid grid-cols-1 gap-4"
                        v-if="itemIndex != 2"
                    >
                        <!-- <div>
                            <InputLabel for="gelombang" value="Gelombang" />
                            <TextInput
                                id="gelombang"
                                ref="gelombangInput"
                                v-model="form.gelombang"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Gelombang"
                            />
                            <InputError
                                :message="form.errors.gelombang"
                                class="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel
                                for="tahun_akademik"
                                value="Tahun Akademik"
                            />
                            <TextInput
                                id="tahun_akademik"
                                ref="tahun_akademikInput"
                                v-model="form.tahun_akademik"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Tahun Akademik"
                            />
                            <InputError
                                :message="form.errors.tahun_akademik"
                                class="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel for="awal_daftar" value="Awal Daftar" />
                            <DateInput
                                id="awal_daftar"
                                ref="awal_daftarInput"
                                v-model="form.awal_daftar"
                                class="mt-1 block w-full"
                                placeholder="Awal Daftar"
                            />
                            <InputError
                                :message="form.errors.awal_daftar"
                                class="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel
                                for="akhir_daftar"
                                value="Akhir Daftar"
                            />
                            <DateInput
                                id="akhir_daftar"
                                v-model="form.akhir_daftar"
                                class="mt -1 block w-full"
                            />
                            <InputError
                                :message="form.errors.akhir_daftar"
                                class="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel for="tes_tulis" value="Tes Tulis" />
                            <DateInput
                                id="tes_tulis"
                                v-model="form.tes_tulis"
                                class="mt-1 block w-full"
                                placeholder="Tes Tulis"
                            />
                            <InputError
                                :message="form.errors.tes_tulis"
                                class="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel
                                for="tes_kesehatan"
                                value="Tes Kesehatan"
                            />
                            <DateInput
                                id="tes_kesehatan"
                                v-model="form.tes_kesehatan"
                                class="mt-1 block w-full"
                                placeholder="Tes Kesehatan"
                            />
                            <InputError
                                :message="form.errors.tes_kesehatan"
                                class="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel for="wawancara" value="Wawancara" />
                            <DateInput
                                id="wawancara"
                                ref="wawancaraInput"
                                v-model="form.wawancara"
                                class="mt-1 block w-full"
                                placeholder="Wawancara"
                            />
                            <InputError
                                :message="form.errors.wawancara"
                                class="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel for="active" value="Active" />
                            <Combobox
                                id="active"
                                v-model="form.active"
                                class="mt-1 block w-full"
                                :option-value="[
                                    { value: 'true', text: 'Yes' },
                                    { value: 'false', text: 'No' },
                                    { value: 'null', text: 'Select' },
                                ]"
                            />
                            <InputError
                                :message="form.errors.active"
                                class="mt-2"
                            />
                        </div> -->
                    </div>
                    <div v-else>
                        <h2
                            class="text-lg font-medium text-gray-900 dark:text-gray-100"
                        >
                            Are you sure you want to delete this payment?
                        </h2>
                    </div>
                    <div class="mt-6">
                        <PrimaryButton @click="save()">
                            {{
                                itemIndex == 0
                                    ? "Create"
                                    : itemIndex == 1
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
