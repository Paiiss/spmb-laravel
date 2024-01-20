<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

// const user = usePage().props.auth.user;

const form = useForm({
    affiliate_id: "",
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Referral code
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                If you have a referral code, please enter it
            </p>
        </header>

        <form @submit.prevent="form.patch(route(''))" class="mt-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="col-span-2">
                    <InputLabel for="affiliate_id" value="Referral code" />

                    <TextInput
                        id="affiliate_id"
                        class="mt-1 block w-full"
                        type="text"
                        v-model="form.affiliate_id"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.affiliate_id"
                    />
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
            </div>
        </form>
    </section>
</template>
