<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage, useForm } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import NumberInput from "@/Components/NumberInput.vue";
import Combobox from "@/Components/Combobox.vue";
import TextareaInput from "@/Components/TextareaInput.vue";

defineProps({
    ktp: String,
    foto: String,
    ijazah: String,
    transkrip_nilai: String,
});

const form = useForm({
    ktp: null,
    foto: null,
    ijazah: null,
    transkrip_nilai: null,
});

const file = ref(null);
const url = ref(null);

const form_type = ["ktp", "foto", "ijazah", "transkrip_nilai"];

const dialog = ref(false);
const dialogIndex = ref(null); // 0 = create, 1 = edit, 2 = delete
const dialogItem = ref(null);

const onFileChange = (e) => {
    file.value = e.target.files[0];
    form[dialogItem.value] = e.target.files[0];
    if (file.value) {
        url.value = URL.createObjectURL(file.value);
    } else {
        url.value = null;
    }
};

const open = (type, item = null) => {
    dialogItem.value = item;
    dialog.value = true;
    dialogIndex.value = type;
};

const close = () => {
    dialog.value = false;
    dialogItem.value = null;
    dialogIndex.value = null;
    url.value = null;
    file.value = null;
    form.reset();
};

const save = () => {
    form.post(route("documents.update"), {
        onSuccess: () => {
            close();
        },
    });
};
</script>

<template>
    <Head title="Dashboard Admin" />
    <AuthenticatedLayout>
        <div>
            <div class="max-w-7xl mx-auto">
                <div class="bg-white p-4 shadow-md rounded-lg">
                    <div
                        class="flex flex-column sm:flex-row flex-wrap items-center justify-between pb-4"
                    >
                        <header>
                            <h2
                                class="text-lg font-bold text-gray-900 dark:text-gray-100"
                            >
                                Dokumen Pendaftaran
                            </h2>
                        </header>
                        <!-- <PrimaryButton @click="open(0)"> create </PrimaryButton> -->
                    </div>
                    <div
                        class="relative overflow-x-auto shadow-md sm:rounded-lg"
                    >
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4">
                            <div
                                class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4"
                                v-for="(document, index) in form_type"
                                :key="index"
                            >
                                <header>
                                    <h3
                                        class="font-semibold text-gray-900 dark:text-gray-100 capitalize"
                                    >
                                        {{ document.replace("_", " ") }}
                                    </h3>
                                </header>
                                <button
                                    class="mt-4 h-40 w-full hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg overflow-hidden"
                                    @click="open(1, document)"
                                >
                                    <img
                                        v-if="$page.props[document]"
                                        :src="$page.props[document]"
                                        :alt="document"
                                        class="overflow-hidden object-cover w-full h-full rounded-lg"
                                    />

                                    <div
                                        v-else
                                        class="flex items-center justify-center h-full"
                                    >
                                        <p class="text-gray-400">
                                            Belum ada
                                            {{ document.replace("_", " ") }}
                                            yang diunggah
                                        </p>
                                    </div>
                                </button>

                                <!-- <div class="mt-4">
                                    <PrimaryButton @click="open(0, document)">
                                        Edit
                                    </PrimaryButton>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <Modal :show="dialog" @close="close()">
                <div class="p-6">
                    <h2
                        class="text-lg font-semibold text-gray-900 dark:text-gray-100 capitalize"
                    >
                        Edit {{ dialogItem.replace("_", " ") }}
                    </h2>
                    <div class="mt-6 grid grid-cols-1 gap-4">
                        <div>
                            <InputLabel class="capitalize" for="name">{{
                                dialogItem.replace("_", " ")
                            }}</InputLabel>
                            <div
                                class="flex items-center justify-center w-full"
                            >
                                <label
                                    for="dropzone-file"
                                    class="flex flex-col items-center justify-center w-full h-auto border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600"
                                >
                                    <div
                                        class="flex flex-col items-center justify-center pt-5 pb-6"
                                        v-if="!url"
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
                                            :src="url"
                                            :alt="dialogItem"
                                            class="object-contain w-full h-full"
                                        />
                                        <!-- <iframe
                                            v-else
                                            :src="url"
                                            :alt="dialogItem"
                                            class="object-contain w-full h-full"
                                        /> -->
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
                                :message="form.errors[dialogItem]"
                                class="mt-2"
                            />
                        </div>
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
