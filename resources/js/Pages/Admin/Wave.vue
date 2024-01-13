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
    wave: {
        type: Object,
    },
});

const form = useForm({
    code: "",
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

const itemIndex = ref(null); // 0 = create, 1 = edit, 2 = delete
const dialog = ref(false);
const dialogItem = ref(null);

const save = () => {
    if (dialog.value) {
        if (itemIndex.value == 0) {
            form.post(route("admin.wave.store"), {
                preserveScroll: true,
                onSuccess: () => close(),
                onError: () => gelombangInput.value.focus(),
                // onFinish: () => form.reset(),
            });
        } else if (itemIndex.value == 1) {
            form.patch(route("admin.wave.update", { id: dialogItem.value }), {
                preserveScroll: true,
                onSuccess: () => close(),
                onError: () => gelombangInput.value.focus(),
                onFinish: () => form.reset(),
            });
        } else if (itemIndex.value == 2) {
            form.delete(route("admin.wave.destroy", { id: dialogItem.value }), {
                preserveScroll: true,
                onSuccess: () => close(),
                onError: () => gelombangInput.value.focus(),
                onFinish: () => form.reset(),
            });
        }
    } else {
        dialog.value = true;
    }
};

const openDialog = (index, item = null) => {
    itemIndex.value = index;
    if (itemIndex.value == 0) {
        form.reset();
    } else if (itemIndex.value == 1) {
        dialogItem.value = item.id;
        form.code = item.code;
        form.gelombang = item.gelombang;
        form.tahun_akademik = item.tahun_akademik;
        form.awal_daftar = item.awal_daftar;
        form.akhir_daftar = item.akhir_daftar;
        form.tes_tulis = item.tes_tulis;
        form.tes_kesehatan = item.tes_kesehatan;
        form.wawancara = item.wawancara;
        form.active = item.active ? "true" : "false";
    } else if (itemIndex.value == 2) {
        dialogItem.value = item.id;
    }
    dialog.value = true;
};

const close = () => {
    dialog.value = false;
    itemIndex.value = null;
    dialogItem.value = null;

    form.reset();
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
                                class="text-lg font-medium text-gray-900 dark:text-gray-100"
                            >
                                Gelombang
                            </h2>
                        </header>
                        <PrimaryButton @click="openDialog(0)">
                            Create</PrimaryButton
                        >
                    </div>
                    <div class="relative overflow-x-auto">
                        <table
                            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                        >
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                            >
                                <tr>
                                    <th scope="col" class="px-6 py-3">Code</th>
                                    <th scope="col" class="px-6 py-3">
                                        Gelombang
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Tahun Akademik
                                    </th>

                                    <th scope="col" class="px-6 py-3">
                                        Awal Pendaftaran
                                    </th>

                                    <th scope="col" class="px-6 py-3">
                                        Akhir Pendaftaran
                                    </th>

                                    <th scope="col" class="px-6 py-3">
                                        Tes Tulis
                                    </th>

                                    <th scope="col" class="px-6 py-3">
                                        Tes Kesehatan
                                    </th>

                                    <th scope="col" class="px-6 py-3">
                                        Wawancara
                                    </th>

                                    <th scope="col" class="px-6 py-3">
                                        Active
                                    </th>

                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                    v-for="item in wave"
                                    :key="item.id"
                                >
                                    <th
                                        scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    >
                                        {{ item.code }}
                                    </th>
                                    <td class="px-6 py-4 truncate">
                                        {{ item.gelombang }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ item.tahun_akademik }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ item.awal_daftar }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ item.akhir_daftar }}
                                    </td>
                                    <td class="px-6 py-4 truncate">
                                        {{ item.tes_tulis }}
                                    </td>
                                    <td class="px-6 py-4 truncate">
                                        {{ item.tes_kesehatan }}
                                    </td>
                                    <td class="px-6 py-4 truncate">
                                        {{ item.wawancara }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <i
                                            v-if="item.active"
                                            class="fas fa-check text-green-500"
                                        ></i>
                                        <i
                                            v-else
                                            class="fas fa-times text-red-500"
                                        ></i>
                                    </td>
                                    <td class="px-6 py-4 flex gap-2">
                                        <button
                                            @click="openDialog(1, item)"
                                            class="text-indigo-600 hover:text-indigo-900"
                                        >
                                            <i class="fa-solid fa-pencil"></i>
                                        </button>
                                        <button
                                            @click="openDialog(2, item)"
                                            class="text-red-600 hover:text-red-900"
                                        >
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
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
                        <div>
                            <InputLabel for="code" value="Code" />
                            <TextInput
                                id="code"
                                ref="codeInput"
                                v-model="form.code"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Code"
                            />
                            <InputError
                                :message="form.errors.code"
                                class="mt-2"
                            />
                        </div>
                        <div>
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
                        </div>
                    </div>
                    <div v-else>
                        <h2
                            class="text-lg font-medium text-gray-900 dark:text-gray-100"
                        >
                            Are you sure you want to delete this wave?
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
            <!-- <Modal
                :show="
                    dialogCreateProdi || dialogEditProdi || dialogDeleteProdi
                "
                @close="closeModal"
            >
                <div class="p-6">
                    <h2
                        class="text-lg font-medium text-gray-900 dark:text-gray-100"
                    >
                        {{ dialogCreateProdi ? "Create" : "Edit" }}
                    </h2>

                    <div
                        class="mt-6 grid grid-cols-1 gap-4"
                        v-if="!dialogDeleteProdi"
                    >
                        <div>
                            <InputLabel
                                for="nama_prodi"
                                value="Name"
                                class="sr-only"
                            />
                            <TextInput
                                id="nama_prodi"
                                ref="nameInput"
                                v-model="form.nama_prodi"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Name"
                            />
                            <InputError
                                :message="form.errors.nama_prodi"
                                class="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel
                                for="jenjang"
                                value="Jenjang"
                                class="sr-only"
                            />
                            <TextInput
                                id="jenjang"
                                ref="jenjangInput"
                                v-model="form.jenjang"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Jenjang"
                            />
                            <InputError
                                :message="form.errors.jenjang"
                                class="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel
                                for="fakultas"
                                value="Fakultas"
                                class="sr-only"
                            />
                            <TextInput
                                id="fakultas"
                                ref="fakultasInput"
                                v-model="form.fakultas"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Fakultas"
                            />
                            <InputError
                                :message="form.errors.fakultas"
                                class="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel
                                for="akreditasi"
                                value="Akreditasi"
                                class="sr-only"
                            />
                            <TextInput
                                id="akreditasi"
                                ref="akreditasiInput"
                                v-model="form.akreditasi"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Akreditasi"
                            />
                            <InputError
                                :message="form.errors.akreditasi"
                                class="mt-2"
                            />
                        </div>

                        <div class="mt-6">
                            <PrimaryButton
                                @click="createProdi"
                                v-if="dialogCreateProdi"
                                >Create</PrimaryButton
                            >
                            <PrimaryButton
                                @click="editProdi(itemProdi)"
                                v-if="dialogEditProdi"
                                >Edit</PrimaryButton
                            >

                            <SecondaryButton @click="closeModal" class="ml-2">
                                Cancel
                            </SecondaryButton>
                        </div>
                    </div>

                    <div v-else>
                        <h2
                            class="text-lg font-medium text-gray-900 dark:text-gray-100"
                        >
                            Are you sure you want to delete this prodi?
                        </h2>

                        <div class="mt-6">
                            <PrimaryButton
                                @click="deleteProdi(itemProdi)"
                                v-if="dialogDeleteProdi"
                                >Delete</PrimaryButton
                            >

                            <SecondaryButton @click="closeModal" class="ml-2">
                                Cancel
                            </SecondaryButton>
                        </div>
                    </div>
                </div>
            </Modal> -->
        </div>
    </AuthenticatedLayout>
</template>
