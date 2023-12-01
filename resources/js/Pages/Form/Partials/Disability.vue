<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import Combobox from "@/Components/Combobox.vue";
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
    is_color_blind: "Select",
    is_disability: "Select",
    disability_note: "",
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Disability
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Update your disability information.
            </p>
        </header>

        <form @submit.prevent="form.patch(route(''))" class="mt-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="col-span-2">
                    <InputLabel for="is_color_blind" value="Color blind" />

                    <Combobox
                        id="is_color_blind"
                        class="mt-1 block w-full"
                        v-model="form.is_color_blind"
                        :option-value="[
                            { value: true, text: 'Yes' },
                            { value: false, text: 'No' },
                            { value: null, text: 'Select' },
                        ]"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.is_color_blind"
                    />
                </div>

                <div class="col-span-2">
                    <InputLabel for="is_disability" value="Disability" />

                    <Combobox
                        id="is_disability"
                        class="mt-1 block w-full"
                        v-model="form.is_disability"
                        :option-value="[
                            { value: true, text: 'Yes' },
                            { value: false, text: 'No' },
                            { value: null, text: 'Select' },
                        ]"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.is_disability"
                    />
                </div>

                <div class="col-span-4" v-if="form.is_disability == 'true'">
                    <InputLabel for="disability_note" value="Disability note" />

                    <TextInput
                        id="disability_note"
                        class="mt-1 block w-full"
                        type="text"
                        v-model="form.disability_note"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.disability_note"
                    />
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600 dark:text-gray-400"
                    >
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
