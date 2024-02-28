<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, usePage, useForm, router } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import Combobox from "@/Components/Combobox.vue";
import TextareaInput from "@/Components/TextareaInput.vue";
import Editor from "@tinymce/tinymce-vue";

const APIKEY = import.meta.env.VITE_API_TINYMCE;

defineProps({
    questions: Object,
    exam: Object,
});

const navigateTo = (url) => {
    if (url === null) return;
    return router.visit(url);
};

const form = useForm({
    question: "",
    answer: "",
    option_a: "",
    option_b: "",
    option_c: "",
    option_d: "",
    option_e: "",
}).transform((data) => ({
    ...data,
    question: `${data.question}`,
}));

const showModal = ref(false);
// const modalTitle = ref("");
const dialogIndex = ref(null); // 0 = tambah, 1 = edit, 2 = hapus
const modalItem = ref(null);

const open = (type, item = null) => {
    if (type === 0) {
        form.reset();
    } else if (type === 1) {
        form.question = item.question;
        form.answer = item.answer;
        form.option_a = item.option_a;
        form.option_b = item.option_b;
        form.option_c = item.option_c;
        form.option_d = item.option_d;
        form.option_e = item.option_e;
    }
    dialogIndex.value = type;
    modalItem.value = item;
    showModal.value = true;
};

const close = () => {
    showModal.value = false;
    modalItem.value = null;
    form.reset();
};

const save = () => {
    if (dialogIndex.value === 0) {
        form.post(
            route("admin.exams.questions.store", usePage().props.exam.id),
            {
                preserveScroll: true,
                onSuccess: () => {
                    close();
                },
            }
        );
    } else if (dialogIndex.value === 1) {
        form.patch(
            route("admin.exams.questions.update", [
                usePage().props.exam.id,
                modalItem.value.id,
            ]),
            {
                preserveScroll: true,
                onSuccess: () => {
                    close();
                },
            }
        );
    } else if (dialogIndex.value === 2) {
        form.delete(
            route("admin.exams.questions.destroy", [
                usePage().props.exam.id,
                modalItem.value.id,
            ]),
            {
                preserveScroll: true,
                onSuccess: () => {
                    close();
                },
            }
        );
    }
};

const option = {
    A: "option_a",
    B: "option_b",
    C: "option_c",
    D: "option_d",
    E: "option_e",
};
</script>

<template>
    <Head title="Dashboard Admin" />
    <AuthenticatedLayout>
        <div>
            <div class="max-w-7xl mx-auto">
                <div class="bg-white p-4 shadow-md rounded-lg">
                    <div
                        class="flex flex-col sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4"
                    >
                        <header>
                            <h2
                                class="text-lg font-bold text-gray-900 dark:text-gray-100"
                            >
                                Kelola Soal {{ exam.name }}
                            </h2>
                        </header>

                        <div class="flex space-x-2">
                            <PrimaryButton @click="open(0)">
                                <i class="fas fa-plus"></i>
                            </PrimaryButton>
                            <PrimaryButton>
                                <i class="fas fa-file-import"></i>
                            </PrimaryButton>
                        </div>
                    </div>

                    <div
                        class="relative overflow-x-auto shadow-md sm:rounded-lg"
                    >
                        <!-- Untuk list soal -->
                        <table
                            class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                        >
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                            >
                                <tr>
                                    <th scope="col " class="px-3 py-3">No</th>
                                    <th scope="col" class="px-6 py-3">Soal</th>
                                    <th scope="col" class="px-6 py-3 text-end">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                    v-for="(item, index) in questions.data"
                                    :key="index"
                                >
                                    <th
                                        scope="row"
                                        class="px-3 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    >
                                        {{
                                            index +
                                            1 +
                                            (questions.current_page - 1) *
                                                questions.per_page
                                        }}
                                    </th>

                                    <td class="px-6 py-4 break-all w-2/3">
                                        <div v-html="item.question"></div>
                                        <br />
                                        <span
                                            v-for="(value, key) in Object.keys(
                                                option
                                            )"
                                            :key="key"
                                            :class="{
                                                'font-bold text-green-400':
                                                    item.answer == value,
                                            }"
                                        >
                                            <span
                                                v-if="
                                                    item[option[value]] !=
                                                        null ||
                                                    item[option[value]] != ''
                                                "
                                            >
                                                {{ value }}.
                                                <span
                                                    v-html="item[option[value]]"
                                                ></span
                                                ><br />
                                            </span>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-end gap-2">
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
                        <div class="py-1 px-4">
                            <nav class="flex items-center space-x-1">
                                <button
                                    type="button"
                                    class="min-w-[40px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2.5 text-sm rounded-full disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10"
                                    aria-current="page"
                                    v-for="link in questions.links"
                                    :key="link.label"
                                    :disabled="link.active"
                                    @click.prevent="navigateTo(link.url)"
                                >
                                    <span v-html="link.label"> </span>
                                </button>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <Modal :show="showModal" @close="close()">
                <div class="p-6">
                    <h2
                        class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                    >
                        {{
                            dialogIndex == 0
                                ? "Tambah"
                                : dialogIndex == 1
                                ? "Edit"
                                : "Hapus"
                        }}
                    </h2>
                    <form @submit.prevent="save()" class="mt-4">
                        <div
                            class="grid grid-cols-1 gap-6"
                            v-if="dialogIndex != 2"
                        >
                            <div>
                                <InputLabel for="question">
                                    Pertanyaan
                                </InputLabel>
                                <Editor
                                    :api-key="APIKEY"
                                    v-model="form.question"
                                    :init="{
                                        height: 500,
                                        menubar: false,
                                        plugins: [
                                            'advlist autolink lists link image charmap print preview anchor',
                                            'searchreplace visualblocks code fullscreen',
                                            'insertdatetime media table paste code help wordcount',
                                        ],
                                        toolbar:
                                            'undo redo | formatselect | ' +
                                            'bold italic backcolor | alignleft aligncenter ' +
                                            'alignright alignjustify | bullist numlist outdent indent | ' +
                                            'removeformat | help',
                                    }"
                                />
                                <InputError :message="form.errors.question" />
                            </div>
                            <div>
                                <InputLabel for="answer">
                                    Kunci Jawaban
                                </InputLabel>
                                <Combobox
                                    v-model="form.answer"
                                    id="answer"
                                    class="mt-1 block w-full"
                                    :option-value="[
                                        {
                                            value: '',
                                            text: '--PILIH JAWABAN--',
                                        },
                                        { value: 'A', text: 'A' },
                                        { value: 'B', text: 'B' },
                                        { value: 'C', text: 'C' },
                                        { value: 'D', text: 'D' },
                                        { value: 'E', text: 'E' },
                                    ]"
                                />
                                <InputError :message="form.errors.answer" />
                            </div>
                            <div>
                                <InputLabel for="option_a">
                                    Pilihan A
                                </InputLabel>
                                <TextareaInput
                                    v-model="form.option_a"
                                    id="option_a"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.option_a" />
                            </div>
                            <div>
                                <InputLabel for="option_b">
                                    Pilihan B
                                </InputLabel>
                                <TextareaInput
                                    v-model="form.option_b"
                                    id="option_b"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.option_b" />
                            </div>
                            <div>
                                <InputLabel for="option_c">
                                    Pilihan C
                                </InputLabel>
                                <TextareaInput
                                    v-model="form.option_c"
                                    id="option_c"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.option_c" />
                            </div>
                            <div>
                                <InputLabel for="option_d">
                                    Pilihan D
                                </InputLabel>
                                <TextareaInput
                                    v-model="form.option_d"
                                    id="option_d"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.option_d" />
                            </div>
                            <div>
                                <InputLabel for="option_e">
                                    Pilihan E
                                </InputLabel>
                                <TextareaInput
                                    v-model="form.option_e"
                                    id="option_e"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.option_e" />
                            </div>

                            <div class="flex justify-end mt-6">
                                <SecondaryButton
                                    type="button"
                                    @click="close()"
                                    class="mr-2"
                                >
                                    Batal
                                </SecondaryButton>
                                <PrimaryButton type="submit">
                                    Simpan
                                </PrimaryButton>
                            </div>
                        </div>
                        <div v-else>
                            <p>Apakah anda yakin ingin menghapus soal ini?</p>
                            <div class="flex justify-end mt-6">
                                <SecondaryButton
                                    type="button"
                                    @click="close()"
                                    class="mr-2"
                                >
                                    Batal
                                </SecondaryButton>
                                <PrimaryButton type="submit">
                                    Hapus
                                </PrimaryButton>
                            </div>
                        </div>
                    </form>
                </div>
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>
