<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage, useForm, router } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import TextInput from "@/Components/TextInput.vue";
import NumberInput from "@/Components/NumberInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Combobox from "@/Components/Combobox.vue";
import TextareaInput from "@/Components/TextareaInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";

defineProps({
    user: {
        type: Object,
        default: () => {},
    },
    image: String,
});

const form_data = usePage().props.user;
const form = useForm({
    height: form_data.height || ``,
    weight: form_data.weight || ``,
    blood_type: form_data.blood_type || "",
    blood_pressure: form_data.blood_pressure || "",
    blood_sugar: form_data.blood_sugar || "",
    is_smoking: form_data.is_smoking == 1 ? true : false,
    color_blind: form_data.color_blind == 1 ? true : false,
    is_disability: form_data.is_disability == 1 ? true : false,
    note: form_data.note || ``,
    image: null,
}).transform((data) => ({
    ...data,
    height: data.height ? parseInt(data.height) : null,
    weight: data.weight ? parseInt(data.weight) : null,
    is_smoking: data.is_smoking ? true : false,
    color_blind: data.color_blind ? true : false,
    is_disability: data.is_disability ? true : false,
}));

const modal = ref(false);
const open = () => {
    modal.value = true;
};

const close = () => {
    modal.value = false;
};

const save = () => {
    form.post(route("exams.health.update"), {
        preserveScroll: true,
        onFinish: () => {
            close();
        },
        onSuccess: () => {
            close();
        },
    });
};

const url = ref(null);

const onFileChange = (e) => {
    form.image = e.target.files[0];
    if (form.image) {
        url.value = URL.createObjectURL(form.image);
    } else {
        url.value = null;
    }
};
</script>

<template>
    <Head title="Pemeriksaan Kesehatan" />
    <AuthenticatedLayout>
        <div>
            <div class="max-w-7xl mx-auto">
                <div
                    class="bg-white dark:bg-gray-800 p-4 sm:p-8 shadow-md rounded-lg sm:shadow-lg"
                >
                    <div
                        class="flex flex-column sm:flex-row flex-wrap items-center justify-between pb-4"
                    >
                        <header>
                            <h2
                                class="text-2xl font-bold text-gray-900 dark:text-gray-100 capitalize"
                            >
                                Tes Kesehatan
                            </h2>
                            <p class="text-sm text-gray-400">
                                Pemeriksaan kesehatan calon mahasiswa baru
                            </p>
                        </header>
                    </div>
                    <template
                        v-if="
                            user.status !== 'submitted' &&
                            user.status !== 'approved'
                        "
                    >
                        <div
                            v-if="user.status === 'rejected' && user.admin_note"
                            class="bg-yellow-50 dark:bg-yellow-800 border-l-4 border-yellow-400 p-4 rounded-lg"
                        >
                            <h4
                                class="flex items-center text-lg font-semibold text-yellow-600 dark:text-yellow-400"
                            >
                                <i
                                    class="fa-solid fa-exclamation-triangle text-yellow-400"
                                ></i>
                                <span class="ml-2">Perhatian</span>
                            </h4>

                            <p
                                class="mt-2 text-sm text-gray-500 dark:text-gray-400"
                            >
                                {{ user.admin_note }}
                            </p>
                        </div>
                        <form
                            @submit.prevent="open()"
                            class="mt-6 grid grid-cols-1 gap-y-6 md:grid-cols-4 md:gap-x-8"
                        >
                            <div>
                                <InputLabel for="height" value="Tinggi Badan" />
                                <NumberInput
                                    id="height"
                                    class="mt-1 block w-full"
                                    v-model="form.height"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.height"
                                />
                                <p class="mt-2 text-sm text-gray-400">
                                    Satuan dalam sentimeter (cm)
                                </p>
                            </div>
                            <div>
                                <InputLabel for="weight" value="Berat Badan" />
                                <NumberInput
                                    id="weight"
                                    class="mt-1 block w-full"
                                    v-model="form.weight"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.weight"
                                />

                                <p class="mt-2 text-sm text-gray-400">
                                    Satuan dalam kilogram (kg)
                                </p>
                            </div>
                            <div>
                                <InputLabel
                                    for="blood_type"
                                    value="Gol. Darah"
                                />
                                <Combobox
                                    id="blood_type"
                                    class="mt-1 block w-full"
                                    v-model="form.blood_type"
                                    autocomplete="blood_type"
                                    :option-value="[
                                        { value: 'A', text: 'A' },
                                        { value: 'B', text: 'B' },
                                        { value: 'AB', text: 'AB' },
                                        { value: 'O', text: 'O' },
                                        { value: '', text: 'Silahkan Pilih' },
                                    ]"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.blood_type"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    for="blood_pressure"
                                    value="Tekanan Darah"
                                />
                                <TextInput
                                    id="blood_pressure"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.blood_pressure"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.blood_pressure"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    for="blood_sugar"
                                    value="Gula Darah"
                                />
                                <TextInput
                                    id="blood_sugar"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.blood_sugar"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.blood_sugar"
                                />
                            </div>

                            <div>
                                <InputLabel for="is_smoking" value="Merokok" />

                                <Combobox
                                    id="is_smoking"
                                    class="mt-1 block w-full"
                                    v-model="form.is_smoking"
                                    autocomplete="is_smoking"
                                    :option-value="[
                                        { value: true, text: 'Ya' },
                                        { value: false, text: 'Tidak' },
                                    ]"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.is_smoking"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    for="color_blind"
                                    value="Buta Warna"
                                />
                                <Combobox
                                    id="color_blind"
                                    class="mt-1 block w-full"
                                    v-model="form.color_blind"
                                    autocomplete="color_blind"
                                    :option-value="[
                                        { value: true, text: 'Ya' },
                                        { value: false, text: 'Tidak' },
                                    ]"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.color_blind"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    for="is_disability"
                                    value="Disabilitas"
                                />
                                <Combobox
                                    id="is_disability"
                                    class="mt-1 block w-full"
                                    v-model="form.is_disability"
                                    autocomplete="is_disability"
                                    :option-value="[
                                        { value: true, text: 'Ya' },
                                        { value: false, text: 'Tidak' },
                                    ]"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.is_disability"
                                />
                            </div>
                            <div class="col-span-1 md:col-span-4">
                                <InputLabel for="note" value="Catatan" />
                                <TextareaInput
                                    id="note"
                                    class="mt-1 block w-full"
                                    v-model="form.note"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.note"
                                />
                            </div>
                            <div class="col-span-1 md:col-span-4">
                                <InputLabel for="image" value="Foto" />
                                <div
                                    class="flex items-center justify-center w-full"
                                >
                                    <label
                                        for="dropzone-file"
                                        class="flex flex-col items-center justify-center w-full h-auto border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600"
                                    >
                                        <div
                                            class="flex flex-col items-center justify-center pt-5 pb-6"
                                            v-if="!form.image && !image"
                                        >
                                            <i
                                                class="fa-solid fa-cloud-arrow-up text-lg"
                                            ></i>
                                            <p
                                                class="mb-2 text-sm text-gray-500 dark:text-gray-400"
                                            >
                                                <span class="font-semibold"
                                                    >Click to upload</span
                                                >
                                                or drag and drop
                                            </p>
                                            <p
                                                class="text-xs text-gray-500 dark:text-gray-400"
                                            >
                                                PNG, JPG (MAX. 800x400px)
                                            </p>
                                        </div>
                                        <div
                                            class="flex flex-col items-center justify-center pt-5 pb-6"
                                            v-else
                                        >
                                            <img
                                                :src="url || image"
                                                alt="Bukti tes kesehatan"
                                                class="object-contain w-full max-h-40"
                                            />
                                        </div>
                                        <input
                                            id="dropzone-file"
                                            type="file"
                                            class="hidden"
                                            accept="image/*"
                                            @change="onFileChange"
                                        />
                                    </label>
                                </div>
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.image"
                                />
                            </div>

                            <div
                                class="mt-6 text-sm text-gray-400 col-span-1 md:col-span-4"
                            >
                                <p>
                                    <span class="font-semibold">Catatan:</span>
                                    Data yang di inputkan akan di verifikasi
                                    oleh admin. Jika data yang di inputkan tidak
                                    sesuai dengan kriteria yang di tentukan maka
                                    data akan di tolak.
                                </p>
                            </div>

                            <div class="col-span-1 md:col-span-4">
                                <div class="flex justify-end">
                                    <PrimaryButton type="submit">
                                        Simpan
                                    </PrimaryButton>
                                </div>
                            </div>
                        </form>
                    </template>
                    <template v-else-if="user.status == 'submitted'">
                        <div class="mt-6">
                            <p>
                                Anda sudah mengirimkan data pemeriksaan
                                kesehatan. mohon tunggu hingga data di
                                verifikasi
                            </p>
                        </div>
                    </template>
                    <template v-else-if="user.status == 'approved'">
                        <div class="mt-6">
                            <p>
                                Selamat data pemeriksaan kesehatan anda sudah di
                                verifikasi oleh admin dan diterima
                            </p>
                        </div>
                    </template>
                </div>
            </div>
            <Modal :show="modal" @close="close()">
                <div class="p-6">
                    <div
                        class="flex flex-column sm:flex-row flex-wrap items-center justify-between pb-4"
                    >
                        <header>
                            <h2
                                class="text-2xl font-bold text-gray-900 dark:text-gray-100 capitalize"
                            >
                                Submit
                            </h2>
                            <p class="text-sm text-gray-400">
                                Anda yakin ingin menyimpan data ini? Data akan
                                di verifikasi oleh admin.
                            </p>
                        </header>
                    </div>
                    <div class="mt-6">
                        <div class="flex justify-end">
                            <SecondaryButton @click="close()">
                                Cancel
                            </SecondaryButton>
                            <PrimaryButton class="ml-2" @click="save()">
                                save
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>
