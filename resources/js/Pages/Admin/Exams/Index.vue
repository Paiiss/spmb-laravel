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
    exams: Object,
});

const form = useForm({
    name: "",
    description: "",
    duration: "",
    is_active: "false",
}).transform((data) => {
    return {
        ...data,
        is_active: data.is_active == "true" ? true : false,
    };
});

const dialog = ref(false);
const dialogIndex = ref(null); // 0 = create, 1 = edit, 2 = delete
const dialogItem = ref(null);

const open = (type, item = null) => {
    dialogItem.value = item;
    dialog.value = true;
    dialogIndex.value = type;
};

const close = () => {
    dialog.value = false;
    dialogItem.value = null;
    dialogIndex.value = null;
    form.reset();
};

const save = () => {
    console.log(dialogIndex.value);
    if (dialogIndex.value == 0) {
        form.post(route("admin.exams.store"), {
            preserveScroll: true,
            onSuccess: () => {
                close();
            },
        });
    } else if (dialogIndex.value == 1) {
        form.patch(route("admin.exams.update", dialogItem.value.id));
    } else {
        form.delete(route("admin.exams.destroy", dialogItem.value.id), {
            preserveScroll: true,
            onSuccess: () => {
                close();
            },
        });
    }
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
                                Kelola Soal Ujian
                            </h2>
                        </header>
                        <PrimaryButton @click="open(0)"> create </PrimaryButton>
                    </div>
                    <div
                        class="relative overflow-x-auto shadow-md sm:rounded-lg"
                    >
                        <div
                            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 p-4"
                        >
                            <div v-for="item in exams" :key="item.id">
                                <div
                                    class="bg-white border shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-700 dark:shadow-slate-700 h-full"
                                >
                                    <div
                                        class="h-full p-4 md:p-5 flex flex-col justify-between"
                                    >
                                        <div>
                                            <h3
                                                class="text-lg font-bold text-gray-800 dark:text-white"
                                            >
                                                {{ item.name }}
                                            </h3>
                                            <p
                                                class="mt-2 text-gray-500 dark:text-gray-400"
                                            >
                                                durasi:
                                                <span class="font-semibold">{{
                                                    item.duration
                                                }}</span>
                                                menit
                                            </p>
                                        </div>
                                        <div>
                                            <button
                                                class="mt-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                                            >
                                                Edit
                                                <svg
                                                    class="flex-shrink-0 w-4 h-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="24"
                                                    height="24"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                >
                                                    <path d="m9 18 6-6-6-6" />
                                                </svg>
                                            </button>
                                            <button
                                                @click="open(2, item)"
                                                class="mt-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent text-red-600 hover:text-red-800 disabled:opacity-50 disabled:pointer-events-none dark:text-red-500 dark:hover:text-red -400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                                            >
                                                delete
                                                <i
                                                    class="fas fa-trash text-xs"
                                                ></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <Modal :show="dialog" @close="close()">
                <div class="p-6">
                    <h2
                        class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                    >
                        {{
                            dialogIndex == 0
                                ? "Create"
                                : dialogIndex == 1
                                ? "Edit"
                                : "Delete"
                        }}
                    </h2>
                    <div
                        class="mt-6 grid grid-cols-1 gap-4"
                        v-if="dialogIndex !== 2"
                    >
                        <div>
                            <InputLabel for="name">Nama Ujian</InputLabel>
                            <TextInput
                                id="name"
                                v-model="form.name"
                                class="mt-1 block w-full"
                                placeholder="Nama Ujian"
                            />
                            <InputError
                                :message="form.errors.name"
                                class="mt-2"
                            />
                        </div>
                        <div>
                            <InputLabel for="description"
                                >Deskripsi Ujian</InputLabel
                            >
                            <TextareaInput
                                id="description"
                                v-model="form.description"
                                class="mt-1 block w-full"
                                placeholder="Deskripsi Ujian"
                            />
                            <InputError
                                :message="form.errors.description"
                                class="mt-2"
                            />
                        </div>
                        <div>
                            <InputLabel for="duration"
                                >Durasi Ujian / menit</InputLabel
                            >
                            <NumberInput
                                id="duration"
                                v-model="form.duration"
                                class="mt-1 block w-full"
                                placeholder="Durasi Ujian"
                                type="number"
                            />
                            <InputError
                                :message="form.errors.duration"
                                class="mt-2"
                            />
                        </div>
                        <div>
                            <InputLabel for="is_active">Status</InputLabel>
                            <Combobox
                                id="is_active"
                                v-model="form.is_active"
                                class="mt-1 block w-full"
                                :option-value="[
                                    { value: 'true', text: 'Aktif' },
                                    { value: 'false', text: 'Tidak Aktif' },
                                ]"
                            />
                            <InputError
                                :message="form.errors.is_active"
                                class="mt-2"
                            />
                        </div>
                    </div>
                    <div class="mt-6" v-else>
                        <p>
                            Apakah anda yakin ingin menghapus data ini? Data
                            yang sudah dihapus tidak dapat dikembalikan.
                        </p>
                    </div>
                    <div class="mt-6">
                        <div class="flex justify-end">
                            <SecondaryButton @click="close()">
                                Cancel
                            </SecondaryButton>
                            <PrimaryButton class="ml-2" @click="save()">
                                {{
                                    dialogIndex == 0
                                        ? "Create"
                                        : dialogIndex == 1
                                        ? "Edit"
                                        : "Delete"
                                }}
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>
