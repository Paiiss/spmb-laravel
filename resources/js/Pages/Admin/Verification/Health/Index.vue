<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage, router, useForm } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import Modal from "@/Components/Modal.vue";
import Combobox from "@/Components/Combobox.vue";
import TextareaInput from "@/Components/TextareaInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";

defineProps({
    health: Object,
});

const navigateTo = (url) => {
    if (url === null) return;
    return router.visit(url);
};
const form = useForm({
    status: null,
    admin_note: null,
});

const modalStatus = ref(false);
const modalItem = ref(null);

const open = (item) => {
    modalStatus.value = true;
    modalItem.value = item;
    form.status = item.status;
    form.admin_note = item.admin_note || ``;
};

const close = () => {
    modalStatus.value = false;
    modalItem.value = null;
    form.reset();
};

const save = () => {
    form.post(route("admin.health-verification.update", modalItem.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            close();
        },
    });
};
</script>

<template>
    <Head title="Validasi Kesehatan" />
    <AuthenticatedLayout>
        <div>
            <div class="max-w-7xl mx-auto">
                <div
                    class="bg-white p-4 sm:p-8 shadow-md sm:shadow-lg rounded-lg"
                >
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
                                    <th scope="col" class="px-6 py-3">Nama</th>

                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-center"
                                    >
                                        No Hp
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
                                    v-for="item in health.data"
                                    :key="item.id"
                                >
                                    <th
                                        scope="row"
                                        class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white"
                                    >
                                        <div>
                                            <div
                                                class="text-base font-semibold"
                                            >
                                                {{ item.user }}
                                            </div>
                                            <div
                                                class="text-sm text-gray-500 font-semibold"
                                            >
                                                {{ item.email }}
                                            </div>
                                        </div>
                                    </th>
                                    <td
                                        class="px-6 py-4 capitalize truncate text-center"
                                    >
                                        {{ item.phone }}
                                    </td>

                                    <td
                                        class="px-6 py-4 capitalize truncate text-center"
                                    >
                                        {{ item.status }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex justify-center">
                                            <button
                                                type="button"
                                                class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                                                @click.prevent="open(item)"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div
                            v-if="health.data.length === 0"
                            class="flex items-center justify-center p-4"
                        >
                            <p class="text-gray-500 dark:text-gray-400">
                                Tidak ada yang perlu divalidasi
                            </p>
                        </div>
                    </div>
                    <div class="py-1 px-4">
                        <nav class="flex items-center space-x-1">
                            <button
                                type="button"
                                class="min-w-[40px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2.5 text-sm rounded-full disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10"
                                aria-current="page"
                                v-for="link in health.links"
                                :key="link.label"
                                :disabled="link.active"
                                @click.prevent="navigateTo(link.url)"
                            >
                                <span v-html="link.label" class="truncate">
                                </span>
                            </button>
                        </nav>
                    </div>
                </div>
            </div>
            <Modal
                :show="modalStatus"
                maxWidth="4xl"
                @close="modalStatus = false"
            >
                <div class="p-6">
                    <h2
                        class="text-xl font-semibold text-gray-800 dark:text-gray-100"
                    >
                        <i class="fas fa-edit"></i> Edit Status
                    </h2>

                    <div class="mt-4">
                        <div class="flex flex-col items-center justify-between">
                            <div>
                                <img
                                    :src="modalItem.image"
                                    alt=""
                                    class="max-h-96 rounded-lg object-cover"
                                />
                            </div>
                            <div>
                                <div
                                    class="grid grid-cols-2 md:grid-cols-4 gap-4"
                                >
                                    <div>
                                        <InputLabel
                                            for="height"
                                            value="Tinggi"
                                        />
                                        <TextInput
                                            type="number"
                                            v-model="modalItem.height"
                                            disabled
                                            class="mt-1 block w-full"
                                        />
                                    </div>
                                    <div>
                                        <InputLabel
                                            for="weight"
                                            value="Berat"
                                        />
                                        <TextInput
                                            type="number"
                                            v-model="modalItem.weight"
                                            disabled
                                            class="mt-1 block w-full"
                                        />
                                    </div>
                                    <div>
                                        <InputLabel
                                            for="blood_type"
                                            value="Tekanan Darah"
                                        />
                                        <TextInput
                                            type="text"
                                            v-model="modalItem.blood_pressure"
                                            disabled
                                            class="mt-1 block w-full"
                                        />
                                    </div>

                                    <div>
                                        <InputLabel
                                            for="blood_type"
                                            value="Golongan Darah"
                                        />
                                        <TextInput
                                            type="text"
                                            v-model="modalItem.blood_type"
                                            disabled
                                            class="mt-1 block w-full"
                                        />
                                    </div>
                                    <div>
                                        <InputLabel
                                            for="blood_sugar"
                                            value="Gula Darah"
                                        />
                                        <TextInput
                                            type="text"
                                            v-model="modalItem.blood_sugar"
                                            disabled
                                            class="mt-1 block w-full"
                                        />
                                    </div>

                                    <div>
                                        <InputLabel
                                            for="is_smoking"
                                            value="Perokok"
                                        />
                                        <TextInput
                                            type="text"
                                            v-model="modalItem.is_smoking"
                                            disabled
                                            class="mt-1 block w-full"
                                        />
                                    </div>
                                    <div>
                                        <InputLabel
                                            for="color_blind"
                                            value="Buta Warna"
                                        />
                                        <TextInput
                                            type="text"
                                            v-model="modalItem.color_blind"
                                            disabled
                                            class="mt-1 block w-full"
                                        />
                                    </div>
                                    <div>
                                        <InputLabel
                                            for="is_disability"
                                            value="Disabilitas"
                                        />
                                        <TextInput
                                            type="text"
                                            v-model="modalItem.is_disability"
                                            disabled
                                            class="mt-1 block w-full"
                                        />
                                    </div>
                                    <div class="col-span-2 md:col-span-4">
                                        <InputLabel
                                            for="note"
                                            value="Cacatan Disabilitas"
                                        />
                                        <TextareaInput
                                            type="text"
                                            v-model="modalItem.note"
                                            disabled
                                            class="mt-1 block w-full"
                                        />
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="status" value="Status" />
                                    <Combobox
                                        v-model="form.status"
                                        :option-value="[
                                            {
                                                text: 'Waiting',
                                                value: 'waiting',
                                            },
                                            {
                                                text: 'Submitted',
                                                value: 'submitted',
                                            },
                                            {
                                                text: 'Approved',
                                                value: 'approved',
                                            },
                                            {
                                                text: 'Rejected',
                                                value: 'rejected',
                                            },
                                        ]"
                                        class="mt-1 block w-full"
                                    />
                                    <InputError :message="form.errors.status" />
                                </div>

                                <div class="mt-4">
                                    <InputLabel
                                        for="admin_note"
                                        value="Catatan"
                                    />
                                    <TextareaInput
                                        v-model="form.admin_note"
                                        class="mt-1 block w-full"
                                    />
                                    <InputError
                                        :message="form.errors.admin_note"
                                    />
                                </div>

                                <div class="mt-4 flex gap-3">
                                    <PrimaryButton @click="save">
                                        Simpan
                                    </PrimaryButton>
                                    <SecondaryButton @click="close">
                                        Batal
                                    </SecondaryButton>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>
