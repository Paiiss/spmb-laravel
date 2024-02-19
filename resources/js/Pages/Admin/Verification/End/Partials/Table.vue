<script setup>
import Pagination from "@/Components/Pagination.vue";
import IconButton from "@/Components/IconButton.vue";

import { ref } from "vue";

defineProps({
    forms: Object,
    open: Function,
});
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
                            <IconButton
                                icon="fas fa-eye"
                                color="yellow"
                                @click="open(form)"
                            />
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
    </div>
</template>
