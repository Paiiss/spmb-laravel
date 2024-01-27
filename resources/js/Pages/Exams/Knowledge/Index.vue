<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage, useForm } from "@inertiajs/vue3";
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
    exams: {
        type: Array,
        default: [] || null,
    },
});
</script>

<template>
    <Head title="Tes Pengetahuan" />
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
                                Tes Pengetahuan
                            </h2>
                            <p class="text-sm text-gray-400">
                                Tes pengetahuan adalah tes yang bertujuan untuk
                                mengukur seberapa jauh pengetahuan seseorang
                                terhadap suatu hal.
                            </p>
                        </header>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
