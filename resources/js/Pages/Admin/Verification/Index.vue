<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage, router } from "@inertiajs/vue3";
import { ref, computed } from "vue";

defineProps({
    forms: Object,
});

const navigateTo = (url) => {
    if (url === null) return;
    return router.visit(url);
};
</script>

<template>
    <Head title="Validasi Formulir" />
    <AuthenticatedLayout>
        <div>
            <div class="max-w-7xl mx-auto">
                <div
                    class="bg-white p-4 sm:p-8 shadow-md sm:shadow-lg rounded-lg"
                >
                    <div class="flex justify-between items-center">
                        <h1 class="text-2xl font-semibold">
                            Validasi Formulir
                        </h1>
                    </div>
                    <div
                        class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4"
                    >
                        <table
                            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                        >
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                            >
                                <tr>
                                    <th scope="col" class="px-3 py-3">No</th>
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-center"
                                    >
                                        Pilihan Prodi
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-center"
                                    >
                                        Mengajukan
                                    </th>
                                    <th scope="col" class="px-6 py-3">
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
                                    v-for="(form, index) in forms.data"
                                    :key="form.id"
                                >
                                    <td class="w-4 p-4">
                                        {{
                                            index +
                                            1 +
                                            (forms.current_page - 1) *
                                                forms.per_page
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
                                                {{ form.user.name }}
                                            </div>
                                            <div
                                                class="font-normal text-gray-500"
                                            >
                                                {{ form.user.email }}
                                            </div>
                                        </div>
                                    </th>
                                    <td
                                        class="px-6 py-4 capitalize truncate text-center"
                                    >
                                        {{ form.option.nama_prodi }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div
                                            class="flex items-center justify-center"
                                        >
                                            <span
                                                :class="{
                                                    'bg-blue-600 text-white dark:bg-blue-500':
                                                        form.is_submitted,
                                                    'bg-red-600 text-white dark:bg-red-500':
                                                        !form.is_submitted,
                                                }"
                                                class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium"
                                                >{{
                                                    form.is_submitted
                                                        ? "Ya"
                                                        : "Tidak"
                                                }}</span
                                            >
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 uppercase text-xs">
                                        {{ form.status }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center">
                                            <button
                                                type="button"
                                                class="inline-block rounded bg-blue-600 px-4 py-2 text-xs font-medium text-white hover:bg-blue-700"
                                                @click.prevent="
                                                    navigateTo(
                                                        route(
                                                            'admin.verification.user',
                                                            form.id
                                                        )
                                                    )
                                                "
                                            >
                                                View
                                            </button>
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
                                Tidak ada yang perlu divalidasi
                            </p>
                        </div>
                    </div>
                    <div class="py-1 px-4">
                        <nav class="flex items-center space-x-1">
                            <button
                                type="button"
                                class="min-w-[40px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2.5 text-sm rounded-full disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10"
                                aria-current="page"
                                v-for="link in forms.links"
                                :key="link.label"
                                :disabled="link.active || link.url === null"
                                @click.prevent="navigateTo(link.url)"
                            >
                                <span v-html="link.label" class="truncate">
                                </span>
                            </button>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
