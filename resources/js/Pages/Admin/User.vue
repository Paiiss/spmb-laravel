<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage, router, useForm } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import Multiselect from "@vueform/multiselect";
import Combobox from "@/Components/Combobox.vue";
import Toggel from "@/Components/Toggel.vue";

defineProps({
    users: Object,
});

const search = ref("");
const searchUser = ref(null);
const timeoutId = ref(null);

const formModal = useForm({
    name: "",
    email: "",
    phone: "",
    roles: [],
    is_Banned: false,
}).transform((data) => ({
    ...data,
    is_Banned: data.is_Banned == "1" ? 1 : 0,
}));
const showModal = ref(false);
const idModal = ref(null); // 1 = edit, 2 = delete
const idItemModal = ref(null);

const open = (item, id) => {
    idModal.value = id;
    showModal.value = true;
    idItemModal.value = item.id;

    if (id !== 0) {
        formModal.name = item.name || "";
        formModal.email = item.email || "";
        formModal.phone = item.phone || "";
        formModal.roles = item.roles;
        formModal.is_Banned = item.is_Banned;
    }
};

const close = () => {
    showModal.value = false;
    idModal.value = null;
    idItemModal.value = null;
    formModal.reset();
};

const save = () => {
    if (idModal.value === 1) {
        formModal.patch(route("admin.user.update", idItemModal.value), {
            preserveScroll: true,
            onSuccess: () => {
                close();
            },
        });
    } else {
        formModal.delete(route("admin.user.destroy", idItemModal.value), {
            preserveScroll: true,
            onFinish: () => {
                close();
            },
        });
    }
};

const navigateTo = (url) => {
    if (url === null) return;
    return router.visit(url);
};

const find = () => {
    if (!search.value || search.value == "") return (searchUser.value = null);
    clearTimeout(timeoutId.value);

    timeoutId.value = setTimeout(async () => {
        if (!search.value || search.value == "") return;
        const request = await fetch(
            route("admin.user.search", search.value)
        ).then((response) => response.json());
        searchUser.value = request;
    }, 500);
};

const findPage = async (url) => {
    if (!url) return;
    const request = await fetch(url).then((response) => response.json());
    searchUser.value = request;
};
</script>

<style src="@vueform/multiselect/themes/tailwind.css"></style>

<template>
    <Head title="Dashboard Admin" />
    <AuthenticatedLayout>
        <div>
            <div class="max-w-7xl mx-auto">
                <div class="shadow-md sm:shadow-lg p-4 sm:p-8 bg-white">
                    <div
                        class="flex items-center justify-end flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900"
                    >
                        <label for="table-search" class="sr-only">Search</label>
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
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <th scope="col" class="px-6 py-3">Phone</th>
                                    <th scope="col" class="px-6 py-3">Role</th>
                                    <th scope="col" class="px-6 py-3">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                    v-for="user in searchUser
                                        ? searchUser.data
                                        : users.data"
                                    :key="user.id"
                                >
                                    <th
                                        scope="row"
                                        class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white"
                                    >
                                        <div>
                                            <div
                                                class="text-base font-semibold"
                                            >
                                                {{ user.name || "N/A" }}
                                            </div>
                                            <div
                                                class="font-normal text-gray-500"
                                            >
                                                {{ user.email }}
                                            </div>
                                        </div>
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ user.phone || "N/A" }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ user.roles.join(", ") }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                            :class="{
                                                'bg-green-100 text-green-800':
                                                    user.email_verified_at &&
                                                    !user.is_Banned,
                                                'bg-red-100 text-red-800':
                                                    user.is_Banned,
                                                'bg-yellow-100 text-yellow-800':
                                                    !user.email_verified_at &&
                                                    !user.is_Banned,
                                            }"
                                        >
                                            {{
                                                user.is_Banned
                                                    ? "Banned"
                                                    : user.email_verified_at
                                                    ? "Active"
                                                    : "Inactive"
                                            }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex gap-2">
                                            <button
                                                class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-600"
                                                @click="open(user, 1)"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <!-- <button
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600"
                                                @click="open(user, 2)"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button> -->
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="py-1 px-4">
                        <nav class="flex items-center space-x-1">
                            <button
                                class="min-w-[40px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2.5 text-sm rounded-full disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10"
                                :class="{
                                    'cursor-not-allowed opacity-50':
                                        link.active || !link.url,
                                }"
                                v-for="link in searchUser?.links
                                    ? searchUser.links
                                    : users.links"
                                :key="link.label"
                                :href="link.url || ''"
                                :disabled="link.active"
                                @click.prevent="
                                    searchUser
                                        ? findPage(link.url)
                                        : navigateTo(link.url)
                                "
                            >
                                <span v-html="link.label" class="truncate">
                                </span>
                            </button>
                        </nav>
                    </div>
                </div>
            </div>

            <Modal @close="close" :show="showModal">
                <div class="p-8">
                    <h2
                        class="text-lg font-semibold text-gray-700 dark:text-white"
                    >
                        {{ idModal === 1 ? "Edit" : "Delete" }} User
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{
                            idModal === 1
                                ? "Edit data user " + formModal.name
                                : `Apakah anda yakin ingin menghapus user ${formModal.name}?`
                        }}
                    </p>

                    <div class="mt-4 grid grid-cols-1" v-if="idModal === 1">
                        <div>
                            <InputLabel for="name">Name</InputLabel>
                            <TextInput
                                id="name"
                                class="mt-1 block w-full"
                                v-model="formModal.name"
                                :error="formModal.errors.name"
                            />
                            <InputError :error="formModal.errors.name" />
                        </div>
                        <div>
                            <InputLabel for="email">Email</InputLabel>
                            <TextInput
                                id="email"
                                class="mt-1 block w-full"
                                v-model="formModal.email"
                                :error="formModal.errors.email"
                            />
                            <InputError :error="formModal.errors.email" />
                        </div>
                        <div>
                            <InputLabel for="phone">Phone</InputLabel>
                            <TextInput
                                id="phone"
                                class="mt-1 block w-full"
                                v-model="formModal.phone"
                                :error="formModal.errors.phone"
                            />
                            <InputError :error="formModal.errors.phone" />
                        </div>
                        <div>
                            <InputLabel for="roles">Roles</InputLabel>
                            <Multiselect
                                id="roles"
                                v-model="formModal.roles"
                                mode="multiple"
                                :close-on-select="false"
                                class="mt-1 block w-full"
                                :clear-on-select="false"
                                :preserve-search="true"
                                label="label"
                                track-by="label"
                                :preselect-first="true"
                                :hide-selected="false"
                                :options="[
                                    { value: 'admin', label: 'Admin' },
                                    { value: 'user', label: 'User' },
                                    { value: 'keuangan', label: 'Keuangan' },
                                    { value: 'panitia', label: 'Panitia' },
                                ]"
                                :error="formModal.errors.roles"
                            />
                            <InputError :error="formModal.errors.roles" />
                        </div>
                        <div>
                            <InputLabel for="is_Banned">Banned</InputLabel>
                            <Combobox
                                id="is_Banned"
                                v-model="formModal.is_Banned"
                                class="mt-1 block w-full"
                                placeholder="Select an option"
                                :option-value="[
                                    { value: 1, text: 'Yes' },
                                    { value: 0, text: 'No' },
                                ]"
                                :error="formModal.errors.is_Banned"
                            />
                            <InputError :error="formModal.errors.is_Banned" />
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end space-x-4 items-start">
                        <SecondaryButton @click="close">Cancel</SecondaryButton>
                        <PrimaryButton @click="save">
                            {{ idModal === 1 ? "Update" : "Delete" }}
                        </PrimaryButton>
                    </div>
                </div>
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>
