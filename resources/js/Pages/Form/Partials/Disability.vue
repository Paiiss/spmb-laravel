<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import Combobox from "@/Components/Combobox.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import TextareaInput from "@/Components/TextareaInput.vue";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form_data = usePage().props.form;

const form = useForm({
    is_color_blind: form_data.is_color_blind ? "true" : "false",
    is_disability: form_data.is_disability ? "true" : "false",
    disability_note: form_data.disability_note || "",
});

const updateDisability = () => {
    form.transform((data) => ({
        is_color_blind: data.is_color_blind == "true" ? true : false,
        is_disability: data.is_disability == "true" ? true : false,
        disability_note:
            data.is_disability == "true" ? data.disability_note : "",
    })).patch(route("form.update"));
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Disabilitas
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Jika anda memiliki disabilitas, silahkan isi form berikut.
            </p>
        </header>

        <form @submit.prevent="updateDisability" class="mt-6 space-y-6">
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-1">
                    <InputLabel for="is_color_blind" value="Buta Warna" />

                    <Combobox
                        id="is_color_blind"
                        class="mt-1 block w-full"
                        v-model="form.is_color_blind"
                        :option-value="[
                            { value: 'true', text: 'Ya' },
                            { value: 'false', text: 'TIdak' },
                        ]"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.is_color_blind"
                    />
                </div>

                <div class="col-span-1">
                    <InputLabel for="is_disability" value="Disabilitas" />

                    <Combobox
                        id="is_disability"
                        class="mt-1 block w-full"
                        v-model="form.is_disability"
                        :option-value="[
                            { value: 'true', text: 'Ya' },
                            { value: 'false', text: 'Tidak' },
                        ]"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.is_disability"
                    />
                </div>

                <div class="col-span-2" v-if="form.is_disability == 'true'">
                    <InputLabel
                        for="disability_note"
                        value="Keterangan Disabilitas "
                    />

                    <TextareaInput
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
            </div>
        </form>
    </section>
</template>
