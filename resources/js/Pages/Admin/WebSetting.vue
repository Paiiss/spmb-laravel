<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Modal from "@/Components/Modal.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { nextTick, ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import DateInput from "@/Components/DateInput.vue";
import Combobox from "@/Components/Combobox.vue";

defineProps({});

const form = useForm({
    send_email: "false",
    email: "",
}).transform((data) => ({
    ...data,
    send_email: data.send_email == "true" ? true : false,
}));
</script>

<template>
    <Head title="Web Setting" />
    <AuthenticatedLayout>
        <div>
            <header
                class="max-w-7xl mx-auto shadow-md sm:shadow-lg p-4 sm:p-4 bg-white"
            >
                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                    Web Setting
                </h2>
            </header>
            <div class="pt-8">
                <div class="max-w-7xl mx-auto">
                    <div class="shadow-md sm:shadow-lg p-4 sm:p-8 bg-white">
                        <div
                            class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between"
                        >
                            <header>
                                <h2
                                    class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                                >
                                    Backup Project
                                </h2>
                            </header>
                        </div>
                        <form
                            @submit.prevent="
                                form.patch(route('admin.web-setting.backup'))
                            "
                            class="mt-6 space-y-6"
                        >
                            <div class="flex justify-start">
                                <PrimaryButton
                                    type="submit"
                                    class="mt-4"
                                    :disabled="form.processing"
                                >
                                    <span v-if="form.processing">
                                        Processing
                                    </span>
                                    <span v-else>backup sekarang</span>
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
