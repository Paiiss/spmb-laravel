<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage, useForm, router } from "@inertiajs/vue3";
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
import Multiselect from "@vueform/multiselect";

defineProps({
    exams: Object,
    prodis: Array,
});

const form = useForm({
    name: "",
    description: "",
    duration: "",
    allowed: [],
    shuffle_question: false,
    shuffle_answer: false,
    show_result: false,
    access_start_time: "",
    access_end_time: "",
    is_active: false,
}).transform((data) => {
    return {
        ...data,
        duration: parseInt(data.duration),
        allowed: JSON.stringify(data.allowed),
        shuffle_question: data.shuffle_question == "true" ? true : false,
        shuffle_answer: data.shuffle_answer == "true" ? true : false,
        show_result: data.show_result == "true" ? true : false,
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
    if (type == 0) {
        form.reset();
    } else if (type == 1) {
        form.name = item.name;
        form.description = item.description;
        form.duration = item.duration;
        form.allowed = JSON.parse(item.allowed);
        form.shuffle_question = item.shuffle_question == 1 ? "true" : "false";
        form.shuffle_answer = item.shuffle_answer == 1 ? "true" : "false";
        form.show_result = item.show_result == 1 ? "true" : "false";
        form.access_start_time = item.access_start_time;
        form.access_end_time = item.access_end_time;
        form.is_active = item.is_active == 1 ? "true" : "false";
    }
};

const close = () => {
    dialog.value = false;
    dialogItem.value = null;
    dialogIndex.value = null;
    form.reset();
};

const save = () => {
    if (dialogIndex.value == 0) {
        form.post(route("admin.exams.store"), {
            preserveScroll: true,
            onSuccess: () => {
                close();
            },
        });
    } else if (dialogIndex.value == 1) {
        form.patch(route("admin.exams.update", dialogItem.value.id), {
            preserveScroll: true,
            onSuccess: () => {
                close();
            },
        });
    } else {
        form.delete(route("admin.exams.destroy", dialogItem.value.id), {
            preserveScroll: true,
            onSuccess: () => {
                close();
            },
        });
    }
};

const navigateTo = (url) => {
    if (url === null) return;
    return router.visit(url);
};

const prodi = computed(() => {
    return usePage().props.prodis.map((item) => ({
        value: item.id,
        label: item.nama_prodi,
    }));
});
</script>

<style src="@vueform/multiselect/themes/tailwind.css"></style>

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
                        <table
                            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                        >
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                            >
                                <tr>
                                    <th scope="col" class="px-3 py-3">NO</th>
                                    <th scope="col" class="px-6 py-3 w-1/2">
                                        Pelajaran
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-center"
                                    >
                                        Soal
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
                                    v-for="(exam, index) in exams.data"
                                    :key="index"
                                >
                                    <td class="w-4 p-4">
                                        {{
                                            index +
                                            exams.per_page *
                                                (exams.current_page - 1) +
                                            1
                                        }}
                                    </td>
                                    <th
                                        scope="row"
                                        class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white"
                                    >
                                        <div>
                                            <div
                                                class="text-base font-semibold"
                                            >
                                                {{ exam.name }}
                                            </div>
                                            <div
                                                class="font-normal text-gray-500"
                                            >
                                                Durasi:
                                                {{ exam.duration }} menit
                                            </div>
                                            <div
                                                class="font-normal text-gray-500"
                                            >
                                                Akses:
                                                {{ exam.access_start_time }}
                                                -
                                                {{ exam.access_end_time }}
                                            </div>

                                            <div
                                                class="font-normal text-gray-500"
                                            >
                                                Pengaturan:
                                                {{
                                                    exam.shuffle_question
                                                        ? "Acak Soal"
                                                        : "Tidak Acak Soal"
                                                }}
                                                ,
                                                {{
                                                    exam.shuffle_answer
                                                        ? "Acak Jawaban"
                                                        : "Tidak Acak Jawaban"
                                                }}
                                                ,
                                                {{
                                                    exam.show_result
                                                        ? "Tampilkan Hasil"
                                                        : "Tidak Tampilkan Hasil"
                                                }}
                                            </div>

                                            <div
                                                class="font-normal text-gray-500"
                                            >
                                                Dapat diakses oleh:

                                                {{
                                                    JSON.parse(exam.allowed)
                                                        ?.length > 0
                                                        ? JSON.parse(
                                                              exam.allowed
                                                          )
                                                              .map((item) => {
                                                                  return prodi.find(
                                                                      (prodi) =>
                                                                          prodi.value ==
                                                                          item
                                                                  )?.label;
                                                              })
                                                              .join(", ")
                                                        : "Tidak ada"
                                                }}
                                            </div>
                                            <div
                                                class="font-normal text-gray-500"
                                            >
                                                {{
                                                    exam.description?.length >
                                                    50
                                                        ? exam.description.substring(
                                                              0,
                                                              50
                                                          ) + "..."
                                                        : exam.description || ""
                                                }}
                                            </div>
                                        </div>
                                    </th>
                                    <td class="px-6 py-4 text-center">
                                        {{ exam.questions_count }} Soal
                                    </td>
                                    <td class="px-6 py-4">
                                        <div
                                            class="flex items-center justify-center"
                                        >
                                            <span
                                                :class="{
                                                    'bg-blue-600 text-white dark:bg-blue-500':
                                                        exam.is_active,
                                                    'bg-red-600 text-white dark:bg-red-500':
                                                        !exam.is_active,
                                                }"
                                                class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium"
                                                >{{
                                                    exam.is_active
                                                        ? "Aktif"
                                                        : "Tidak Aktif"
                                                }}</span
                                            >
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-3">
                                            <button
                                                class="text-gray-600 text-md font-medium hover:text-gray-700"
                                                @click.prevent="
                                                    navigateTo(
                                                        route(
                                                            'admin.exams.questions',
                                                            exam.id
                                                        )
                                                    )
                                                "
                                            >
                                                <i class="fas fa-book"></i>
                                            </button>
                                            <button
                                                class="text-blue-600 text-md font-medium hover:text-blue-700"
                                                @click.prevent="open(1, exam)"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button
                                                class="text-red-600 text-md font-medium hover:text-red-700"
                                                @click.prevent="open(2, exam)"
                                            >
                                                <i class="fas fa-trash"></i>
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
                                type="button"
                                class="min-w-[40px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2.5 text-sm rounded-full disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10"
                                aria-current="page"
                                v-for="link in exams.links"
                                :key="link.label"
                                :disabled="link.active"
                                @click.prevent="navigateTo(link.url || '#')"
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
                        class="mt-6 grid grid-cols-2 gap-4"
                        v-if="dialogIndex !== 2"
                    >
                        <div class="col-span-2">
                            <InputLabel for="ujian">Nama Ujian</InputLabel>
                            <TextInput
                                id="ujian"
                                v-model="form.name"
                                class="mt-1 block w-full"
                                placeholder="Nama Ujian"
                            />
                            <InputError
                                :message="form.errors.name"
                                class="mt-2"
                            />
                        </div>
                        <div class="col-span-2">
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
                        <div class="col-span-2">
                            <InputLabel for="allowed">Akses Ujian</InputLabel>

                            <Multiselect
                                v-model="form.allowed"
                                :options="prodi"
                                mode="multiple"
                                :close-on-select="false"
                                :clear-on-select="false"
                                :preserve-search="true"
                                placeholder="Pilih Prodi"
                                label="label"
                                track-by="label"
                                :preselect-first="true"
                                :hide-selected="false"
                            />

                            <InputError
                                :message="form.errors.allowed"
                                class="mt-2"
                            />
                        </div>
                        <div>
                            <InputLabel for="access_start_time"
                                >Waktu Mulai</InputLabel
                            >
                            <TextInput
                                id="access_start_time"
                                v-model="form.access_start_time"
                                class="mt-1 block w-full"
                                placeholder="Waktu Mulai"
                            />
                            <InputError
                                :message="form.errors.access_start_time"
                                class="mt-2"
                            />
                        </div>
                        <div>
                            <InputLabel for="access_end_time"
                                >Waktu Selesai</InputLabel
                            >
                            <TextInput
                                id="access_end_time"
                                v-model="form.access_end_time"
                                class="mt-1 block w-full"
                                placeholder="Waktu Selesai"
                            />
                            <InputError
                                :message="form.errors.access_end_time"
                                class="mt-2"
                            />
                        </div>
                        <div>
                            <InputLabel for="shuffle_question"
                                >Acak Soal</InputLabel
                            >
                            <Combobox
                                id="shuffle_question"
                                v-model="form.shuffle_question"
                                class="mt-1 block w-full"
                                :option-value="[
                                    { value: true, text: 'Ya' },
                                    { value: false, text: 'Tidak' },
                                ]"
                            />
                            <InputError
                                :message="form.errors.shuffle_question"
                                class="mt-2"
                            />
                        </div>
                        <div>
                            <InputLabel for="shuffle_answer"
                                >Acak Jawaban</InputLabel
                            >
                            <Combobox
                                id="shuffle_answer"
                                v-model="form.shuffle_answer"
                                class="mt-1 block w-full"
                                :option-value="[
                                    { value: true, text: 'Ya' },
                                    { value: false, text: 'Tidak' },
                                ]"
                            />
                            <InputError
                                :message="form.errors.shuffle_answer"
                                class="mt-2"
                            />
                        </div>
                        <div>
                            <InputLabel for="show_result"
                                >Tampilkan Hasil</InputLabel
                            >
                            <Combobox
                                id="show_result"
                                v-model="form.show_result"
                                class="mt-1 block w-full"
                                :option-value="[
                                    { value: true, text: 'Ya' },
                                    { value: false, text: 'Tidak' },
                                ]"
                            />
                            <InputError
                                :message="form.errors.show_result"
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
                        <div class="col-span-2">
                            <InputLabel for="is_active">Status</InputLabel>
                            <Combobox
                                id="is_active"
                                v-model="form.is_active"
                                class="mt-1 block w-full"
                                :option-value="[
                                    { value: true, text: 'Aktif' },
                                    { value: false, text: 'Tidak Aktif' },
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
