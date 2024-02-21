<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import Personal from "./Partials/Personal.vue";
import Address from "./Partials/Address.vue";
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
    id: {
        type: String,
    },
});
</script>

<template>
    <Head title="Personal Data" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Form
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div
                    v-if="id === 'personal'"
                    class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-md sm:shadow-lg sm:rounded-lg"
                >
                    <Personal
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                    />
                </div>
                <div
                    v-if="id === 'address'"
                    class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-md sm:shadow-lg sm:rounded-lg"
                >
                    <Address
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                    />
                </div>

                <div
                    v-if="id === 'disability'"
                    class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-md sm:shadow-lg sm:rounded-lg"
                >
                    <Disability
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                    />
                </div>

                <div
                    v-if="id === 'education'"
                    class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-md sm:shadow-lg sm:rounded-lg"
                >
                    <Education
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                    />
                </div>

                <div
                    v-if="id === 'parent'"
                    class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-md sm:shadow-lg sm:rounded-lg"
                >
                    <Parent
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                    />
                </div>

                <div
                    v-if="id === 'affiliate'"
                    class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-md sm:shadow-lg sm:rounded-lg"
                >
                    <!-- <Affiliation
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                    /> -->
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
