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
import DateInput from "@/Components/DateInput.vue";

defineProps({
    interviews: Object,
});

const navigateTo = (url) => {
    if (url === null) return;
    return router.visit(url);
};
const form = useForm({
    status: null,
    note: null,
    interview_date: null,
});

const modalStatus = ref(false);
const modalItem = ref(null);
const search = ref("");
const timeoutId = ref(null);
const interview = ref(usePage().props.interviews);

const open = (item) => {
    modalStatus.value = true;
    modalItem.value = item;
    form.status = item.status;
    form.note = item.note || ``;
    form.interview_date = item.interview_date || ``;
};

const close = () => {
    modalStatus.value = false;
    modalItem.value = null;
    form.reset();
};

const save = () => {
    form.post(route("admin.interview.update", modalItem.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            close();
        },
    });
};

const find = async () => {
    if (search.value === "") {
        return (interview.value = usePage().props.interviews);
    }

    if (timeoutId.value) {
        clearTimeout(timeoutId.value);
    }

    timeoutId.value = setTimeout(() => {
        fetch(route("admin.interview.search", { search: search.value }))
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                return (interview.value = data);
            });
    }, 1000);

    return usePage().props.interviews;
};
</script>

<template>
    <Head title="Validasi Interview" />
    <AuthenticatedLayout>
        <div>
            <div class="max-w-7xl mx-auto">
                <div
                    class="bg-white p-4 sm:p-8 shadow-md sm:shadow-lg rounded-lg"
                >
                    <header>
                        <div
                            class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900"
                        >
                            <h2
                                class="text-lg font-semibold text-gray-900 dark:text-white"
                            >
                                Validasi Interview

                                <span
                                    class="text-sm text-gray-500 dark:text-gray-400"
                                >
                                    ({{ interviews.data.length }})
                                </span>
                            </h2>

                            <label for="table-search" class="sr-only"
                                >Search</label
                            >
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none"
                                >
                                    <svg
                                        class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            stroke="currentColor"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                                        />
                                    </svg>
                                </div>
                                <input
                                    type="text"
                                    id="table-search-users"
                                    v-model="search"
                                    class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Search for users"
                                    @keyup="find"
                                />
                            </div>
                        </div>
                    </header>
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
                                    <th scope="col" class="px-6 py-3">
                                        Kandidat
                                    </th>

                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-center"
                                    >
                                        No Ujian
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-center"
                                    >
                                        Tanggal
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
                                    v-for="item in interviews.data"
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
                                                {{ item.user.name }}
                                            </div>
                                            <div
                                                class="text-sm text-gray-500 font-semibold"
                                            >
                                                Email: {{ item.user.email }}
                                            </div>
                                            <div
                                                class="text-sm text-gray-500 font-semibold"
                                            >
                                                No. Hp: {{ item.user.phone }}
                                            </div>
                                        </div>
                                    </th>

                                    <td class="px-6 py-4 text-center">
                                        {{ item.no_exam }}
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        {{
                                            item.interview_date
                                                ? new Date(
                                                      item.interview_date
                                                  ).toLocaleDateString()
                                                : "-"
                                        }}
                                    </td>

                                    <td
                                        class="px-6 py-4 capitalize truncate text-center"
                                    >
                                        <span
                                            class="px-2 py-1 rounded-full"
                                            :class="{
                                                'bg-green-100 text-green-800 dark:bg-green-500 dark:text-green-100':
                                                    item.status === 'approved',
                                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-500 dark:text-yellow-100':
                                                    item.status === 'pending',
                                                'bg-red-100 text-red-800 dark:bg-red-500 dark:text-red-100':
                                                    item.status === 'rejected',
                                            }"
                                        >
                                            {{ item.status }}
                                        </span>
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
                            v-if="interviews.data.length === 0"
                            class="flex items-center justify-center p-4"
                        >
                            <p
                                class="text-gray-500 dark:text-gray-400 text-xs md:text-base"
                            >
                                Tidak ada yang mengajukan interview
                            </p>
                        </div>
                    </div>
                    <div class="py-1 px-4">
                        <nav class="flex items-center space-x-1">
                            <button
                                type="button"
                                class="min-w-[40px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2.5 text-sm rounded-full disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10"
                                aria-current="page"
                                v-for="link in interviews.links"
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
            <Modal :show="modalStatus" @close="close">
                <div class="p-6">
                    <header>
                        <h2
                            class="text-lg font-semibold text-gray-900 dark:text-white"
                        >
                            Update Status Interview
                        </h2>
                    </header>
                    <div class="mt-4 grid grid-cols-1 gap-4">
                        <div>
                            <InputLabel for="status" value="Status" />
                            <Combobox
                                v-model="form.status"
                                class="w-full"
                                :option-value="[
                                    { label: 'Pending', text: 'pending' },
                                    { label: 'Approved', text: 'approved' },
                                    { label: 'Rejected', text: 'rejected' },
                                ]"
                            />
                            <InputError :message="form.errors.status" />
                        </div>

                        <div>
                            <InputLabel
                                for="interview_date"
                                value="Waktu interview"
                            />

                            <DateInput
                                id="interview_date"
                                class="mt-1 block w-full"
                                v-model="form.interview_date"
                                type="datetime-local"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.interview_date"
                            />
                        </div>

                        <div>
                            <InputLabel for="note" value="Catatan Admin" />
                            <TextareaInput v-model="form.note" class="w-full" />
                            <InputError :message="form.errors.note" />
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end gap-3">
                        <SecondaryButton @click="close">
                            Batal
                        </SecondaryButton>
                        <PrimaryButton
                            @click="save"
                            :disabled="form.processing"
                        >
                            Simpan
                        </PrimaryButton>
                    </div>
                </div>
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>
