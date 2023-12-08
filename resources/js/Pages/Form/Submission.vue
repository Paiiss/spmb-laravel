<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import Personal from "./Partials/Personal.vue";
import Disability from "./Partials/Disability.vue";
import Education from "./Partials/Education.vue";
import Parent from "./Partials/Parent.vue";
import Affiliation from "./Partials/Affiliate.vue";

defineProps();
</script>

<template>
    <Head title="Submission" />

    <AuthenticatedLayout>
        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div
                    class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg"
                ></div>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Dolorum numquam consequatur dolor, omnis est sapiente quis
                    earum aliquid quaerat iste!
                </p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
