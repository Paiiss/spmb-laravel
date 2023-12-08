<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Dashboard Admin" />
    <AuthenticatedLayout>
        <div>
            <h1>Users</h1>
        </div>
    </AuthenticatedLayout>
</template>
