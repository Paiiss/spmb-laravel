<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Modal from "@/Components/Modal.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { nextTick, ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import NumberInput from "@/Components/NumberInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import Combobox from "@/Components/Combobox.vue";
import Multiselect from "@vueform/multiselect";

defineProps({
    prodi: {
        type: Object,
    },
    knowledges: {
        type: Array,
    },
});

const form = useForm({
    nama_prodi: "",
    jenjang: "",
    fakultas: "",
    akreditasi: "",
    tes_ujian: false,
    ujian: [],
    tes_wawancara: false,
    tes_kesehatan: false,
    biaya_registrasi: 0,
    nilai_dibawah: 0,
    status: false,
}).transform((x) => ({
    ...x,
    tes_ujian: x.tes_ujian == "true" ? true : false,
    ujian: x.tes_ujian == "true" ? x.ujian?.join(",") : null,
    tes_wawancara: x.tes_wawancara == "true" ? true : false,
    tes_kesehatan: x.tes_kesehatan == "true" ? true : false,
    biaya_registrasi: parseInt(x.biaya_registrasi),
    nilai_dibawah: parseInt(x.nilai_dibawah) || 0,
    status: x.status == "true" ? true : false,
}));

const dialogCreateProdi = ref(false);
const dialogEditProdi = ref(false);
const itemProdi = ref(null);
const dialogDeleteProdi = ref(false);

const createProdi = () => {
    if (dialogCreateProdi.value) {
        form.post(route("admin.prodi.store"), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onError: () => nama_prodiInput.value.focus(),
            onFinish: () => form.reset(),
        });
    } else {
        dialogCreateProdi.value = true;
    }
};

const editProdi = (item = null) => {
    if (dialogEditProdi.value) {
        form.patch(route("admin.prodi.update", { id: item }), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onError: () => nama_prodiInput.value.focus(),
            onFinish: () => form.reset(),
        });
    } else {
        dialogEditProdi.value = true;
        itemProdi.value = item;
        let findProdi = usePage().props.prodi.find(
            (item) => item.id == itemProdi.value
        );

        form.akreditasi = findProdi.akreditasi;
        form.fakultas = findProdi.fakultas;
        form.jenjang = findProdi.jenjang;
        form.nama_prodi = findProdi.nama_prodi;
        form.tes_kesehatan = findProdi.tes_kesehatan == 1 ? "true" : "false";
        form.tes_ujian = findProdi.tes_ujian == 1 ? "true" : "false";
        form.ujian = findProdi.ujian?.split(",") || [];
        form.tes_wawancara = findProdi.tes_wawancara == 1 ? "true" : "false";
        form.biaya_registrasi = findProdi.biaya_registrasi;
        form.nilai_dibawah = findProdi.nilai_dibawah || 0;
        form.status = findProdi.status == 1 ? "true" : "false";
    }
};

const deleteProdi = (item = null) => {
    if (dialogDeleteProdi.value) {
        form.delete(route("admin.prodi.destroy", { id: item }), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onError: () => nama_prodiInput.value.focus(),
            onFinish: () => form.reset(),
        });
    } else {
        dialogDeleteProdi.value = true;
        itemProdi.value = item;
    }
};

const closeModal = () => {
    dialogCreateProdi.value = false;
    dialogEditProdi.value = false;
    dialogDeleteProdi.value = false;
    itemProdi.value = null;
    form.reset();
};
</script>

<style src="@vueform/multiselect/themes/tailwind.css"></style>

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
                                Program studi
                            </h2>
                        </header>
                        <PrimaryButton @click="createProdi"
                            >Create</PrimaryButton
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
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <th scope="col" class="px-6 py-3">
                                        Jenjang
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Fakultas
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Akreditasi
                                    </th>
                                    <th scope="col" class="px-6 py-3">Ujian</th>
                                    <th scope="col" class="px-6 py-3">
                                        Tes Wawancara
                                    </th>

                                    <th scope="col" class="px-6 py-3">
                                        Tes Kesehatan
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Biaya Registrasi
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                    v-for="prodi in prodi"
                                    :key="prodi.id"
                                >
                                    <th
                                        scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    >
                                        {{ prodi.nama_prodi }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ prodi.jenjang }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ prodi.fakultas }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ prodi.akreditasi }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ prodi.tes_ujian ? "Ya" : "Tidak" }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{
                                            prodi.tes_wawancara ? "Ya" : "Tidak"
                                        }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{
                                            prodi.tes_kesehatan ? "Ya" : "Tidak"
                                        }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{
                                            new Intl.NumberFormat("id-ID", {
                                                style: "currency",
                                                currency: "IDR",
                                            }).format(
                                                prodi.biaya_registrasi || 0
                                            )
                                        }}
                                    </td>
                                    <td class="px-6 py-4 flex gap-2">
                                        <button
                                            @click="editProdi(prodi.id)"
                                            class="text-indigo-600 hover:text-indigo-900"
                                        >
                                            <i class="fa-solid fa-pencil"></i>
                                        </button>
                                        <button
                                            @click="deleteProdi(prodi.id)"
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
            <Modal
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
                            <InputLabel for="nama_prodi" value="Name" />
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
                            <InputLabel for="jenjang" value="Jenjang" />
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
                            <InputLabel for="fakultas" value="Fakultas" />
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
                            <InputLabel for="akreditasi" value="Akreditasi" />
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
                        <div>
                            <InputLabel for="tes_ujian" value="Tes Ujian" />
                            <Combobox
                                id="tes_ujian"
                                ref="tes_ujianInput"
                                v-model="form.tes_ujian"
                                class="mt-1 block w-full"
                                placeholder="Tes Ujian"
                                :option-value="[
                                    {
                                        value: true,
                                        text: 'Ya',
                                    },
                                    {
                                        value: false,
                                        text: 'Tidak',
                                    },
                                ]"
                            />
                            <InputError
                                :message="form.errors.tes_ujian"
                                class="mt-2"
                            />
                        </div>

                        <div v-if="form.tes_ujian == 'true'">
                            <InputLabel for="ujian" value="Ujian" />
                            <Multiselect
                                id="ujian"
                                ref="ujianInput"
                                v-model="form.ujian"
                                class="mt-1 block w-full"
                                placeholder="Ujian"
                                :options="knowledges"
                                mode="multiple"
                                :close-on-select="false"
                                :clear-on-select="false"
                                :preserve-search="true"
                                label="label"
                                track-by="label"
                                :preselect-first="true"
                                :hide-selected="false"
                            />
                            <InputError
                                :message="form.errors.ujian"
                                class="mt-2"
                            />
                        </div>

                        <div v-if="form.tes_ujian == 'true'">
                            <InputLabel
                                for="nilai_dibawah"
                                value="Nilai Dibawah"
                            />
                            <NumberInput
                                id="nilai_dibawah"
                                ref="nilai_dibawahInput"
                                v-model="form.nilai_dibawah"
                                class="mt-1 block w-full"
                                placeholder="Nilai Dibawah"
                            />
                            <InputError
                                :message="form.errors.nilai_dibawah"
                                class="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel
                                for="tes_wawancara"
                                value="Tes Wawancara"
                            />

                            <Combobox
                                id="tes_wawancara"
                                ref="tes_wawancaraInput"
                                v-model="form.tes_wawancara"
                                class="mt-1 block w-full"
                                placeholder="Tes Wawancara"
                                :option-value="[
                                    {
                                        value: true,
                                        text: 'Ya',
                                    },
                                    {
                                        value: false,
                                        text: 'Tidak',
                                    },
                                ]"
                            />

                            <InputError
                                :message="form.errors.tes_wawancara"
                                class="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel
                                for="tes_kesehatan"
                                value="Tes Kesehatan"
                            />
                            <Combobox
                                id="tes_kesehatan"
                                ref="tes_kesehatanInput"
                                v-model="form.tes_kesehatan"
                                class="mt-1 block w-full"
                                placeholder="Tes Kesehatan"
                                :option-value="[
                                    {
                                        value: true,
                                        text: 'Ya',
                                    },
                                    {
                                        value: false,
                                        text: 'Tidak',
                                    },
                                ]"
                            />
                            <InputError
                                :message="form.errors.tes_kesehatan"
                                class="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel
                                for="biaya_registrasi"
                                value="Biaya Registrasi"
                            />
                            <TextInput
                                id="biaya_registrasi"
                                ref="biaya_registrasiInput"
                                v-model="form.biaya_registrasi"
                                type="number"
                                class="mt-1 block w-full"
                                placeholder="Biaya Registrasi"
                            />
                            <InputError
                                :message="form.errors.biaya_registrasi"
                                class="mt-2"
                            />
                        </div>

                        <div>
                            <InputLabel for="status" value="Status" />
                            <Combobox
                                id="status"
                                ref="statusInput"
                                v-model="form.status"
                                class="mt-1 block w-full"
                                placeholder="Status"
                                :option-value="[
                                    {
                                        value: 'true',
                                        text: 'Aktif',
                                    },
                                    {
                                        value: 'false',
                                        text: 'Tidak Aktif',
                                    },
                                ]"
                            />
                            <InputError
                                :message="form.errors.status"
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
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>
