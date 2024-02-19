<script setup>
import Pagination from "@/Components/Pagination.vue";
import IconButton from "@/Components/IconButton.vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextareaInput from "@/Components/TextareaInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

defineProps({
    forms: Object,
    open: Function,
});

const modal = ref(false);
const type = ref(null);

const form = useForm({
    id: "",
    status: "",
    reason: "",
}).transform((fields) => {
    return {
        ...fields,
        reason: fields.reason || null,
    };
});

const openModal = (f, t) => {
    modal.value = true;
    type.value = t;
    form.status = t;
    form.id = f.id;
};

const closeModal = () => {
    modal.value = false;
    type.value = null;
    form.reset();
};

const save = () => {
    console.log("save");
    form.patch(route("admin.end-validation.update", form.id), {
        onSuccess: () => {
            closeModal();
        },
        onFinish: () => {
            closeModal();
        },
    });
};
</script>

<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
        <table
            class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
        >
            <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
            >
                <tr>
                    <th scope="col" class="px-3 py-3">No.</th>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3 text-center">
                        Nomor Pendaftaran
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        Pilihan Prodi
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        Status Formulir
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                    v-for="(form, index) in forms.data"
                    :key="form.id"
                >
                    <td class="w-4 p-4">
                        {{
                            index +
                            1 +
                            (forms.current_page - 1) * forms.per_page
                        }}
                    </td>
                    <th
                        scope="row"
                        class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white"
                    >
                        <div>
                            <div class="text-base font-semibold">
                                {{ form.name }}
                            </div>
                            <div class="font-normal text-gray-500">
                                {{ form.email }}
                            </div>
                        </div>
                    </th>
                    <td class="px-6 py-4 uppercase text-center">
                        {{ form.no_exam }}
                    </td>
                    <td class="px-6 py-4 capitalize truncate text-center">
                        {{ form.prodi }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        {{ form.status }}
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex justify-center">
                            <div>
                                <IconButton
                                    icon="fas fa-check"
                                    color="green"
                                    @click="openModal(form, 'approved')"
                                />
                            </div>
                            <div>
                                <IconButton
                                    icon="fas fa-eye"
                                    color="yellow"
                                    @click="open(form)"
                                />
                            </div>
                            <div>
                                <IconButton
                                    icon="fas fa-times"
                                    color="red"
                                    @click="openModal(form, 'rejected')"
                                />
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <div
            v-if="forms.data.length === 0"
            class="flex items-center justify-center p-4"
        >
            <p class="text-gray-500 dark:text-gray-400">
                Tidak ada yang mengajukan pendaftaran
            </p>
        </div>
        <Modal :show="modal" @close="closeModal">
            <div class="p-4">
                <h2 class="text-xl font-semibold text-gray-700 dark:text-white">
                    Konfirmasi
                </h2>
                <p class="text-gray-500 dark:text-gray-400">
                    Apakah anda yakin ingin
                    {{ type === "approved" ? "menerima" : "menolak" }}
                    pendaftaran ini?, data yang sudah diinput tidak dapat
                    dikembalikan
                </p>
                <div
                    v-if="form.status == 'rejected'"
                    class="mt-4 w-full dark:text-white"
                >
                    <InputLabel> Alasan Penolakan </InputLabel>
                    <TextareaInput
                        v-model="form.reason"
                        label="Alasan Penolakan"
                    />
                </div>
                <div class="mt-4 flex gap-2 justify-end">
                    <SecondaryButton @click="closeModal">
                        Tidak
                    </SecondaryButton>
                    <PrimaryButton
                        @click="save"
                        :disabled="form.status == 'rejected' && !form.reason"
                    >
                        Ya
                    </PrimaryButton>
                </div>
            </div>
        </Modal>
    </div>
</template>
