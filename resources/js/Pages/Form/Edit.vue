<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import Personal from "./Partials/Personal.vue";
import Disability from "./Partials/Disability.vue";
import Education from "./Partials/Education.vue";
import Parent from "./Partials/Parent.vue";
import Affiliation from "./Partials/Affiliate.vue";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Form
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div
                    class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg"
                >
                    <Personal
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                    />
                </div>

                <div
                    class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg"
                >
                    <Disability
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                    />
                </div>

                <div
                    class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg"
                >
                    <Education
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                    />
                </div>

                <div
                    class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg"
                >
                    <Parent
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                    />
                </div>

                <div
                    class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg"
                >
                    <Affiliation
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
