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
import Determination from "./Partials/Determination.vue";

defineProps({
    form: {
        default: null,
        type: Object,
    },
    percent: Object,
});
</script>

<template>
    <Head title="Pendaftaran" />

    <AuthenticatedLayout>
        <div class="flex flex-col gap-3">
            <ChooseStudyProgram v-if="!form.prodi && !form.wave" />
            <MakePayment
                v-else-if="form.status && !form.is_paid_registration"
                :amount="form.amount"
                :wave="form.wave"
                :code="form.code"
            />
            <Guide
                v-else-if="
                    form.status &&
                    (form.status == 'waiting' || form.status == 'rejected') &&
                    form.is_paid_registration
                "
                :wave="form.wave"
                :percent="percent"
                :status="form.status"
                :note="form.note"
            />
            <Submitted
                v-else-if="form.status == 'submitted'"
                :wave="form.wave"
            />
            <ApprovedForm
                v-else-if="
                    form.status == 'approved' && form.end_status == 'pending'
                "
                :form="form"
            />
            <Determination
                v-else-if="form.end_status !== 'pending'"
                :form="form"
            />
        </div>
    </AuthenticatedLayout>
</template>
