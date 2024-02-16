<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, Link, usePage } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Combobox from "@/Components/Combobox.vue";
import Modal from "@/Components/Modal.vue";

// Partials
import ChooseStudyProgram from "./Partials/ChooseStudyProgram.vue";
import MakePayment from "./Partials/MakePayment.vue";
import Guide from "./Partials/Guide.vue";
import Submitted from "./Partials/Submitted.vue";
import ApprovedForm from "./Partials/ApprovedForm.vue";

defineProps({
    wave: {
        default: null,
    },
    form_status: {
        type: Boolean,
        default: false,
    },
    amount: {
        type: Number,
        default: 0,
    },
    is_paid_registration: {
        default: null,
    },
    code: {
        default: null,
    },
    percent: Object,
    is_lock: null,
    is_submitted: null,
    status: {
        default: null,
        type: String,
    },
    note: {
        default: null,
        type: String,
    },
});
</script>

<template>
    <Head title="Pendaftaran" />

    <AuthenticatedLayout>
        <div class="flex flex-col gap-3">
            <template v-if="status == 'approved'">
                <ApprovedForm :wave="wave" />
            </template>
            <template v-else-if="status == 'submitted'">
                <Submitted :wave="wave" />
            </template>
            <template
                v-else-if="
                    (form_status || status == 'waiting') && is_paid_registration
                "
            >
                <Guide
                    :wave="wave"
                    :percent="percent"
                    :status="status"
                    :note="note"
                />
            </template>
            <template v-else-if="form_status && !is_paid_registration">
                <MakePayment :amount="amount" :wave="wave" :code="code" />
            </template>
            <template v-else>
                <ChooseStudyProgram />
            </template>
        </div>
    </AuthenticatedLayout>
</template>
