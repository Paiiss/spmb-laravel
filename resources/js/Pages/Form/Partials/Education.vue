<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import NumberInput from "@/Components/NumberInput.vue";
import Combobox from "@/Components/Combobox.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";

const from_data = usePage().props.form;
const form = useForm({
    last_education: from_data.last_education || "",
    education_number: from_data.education_number || "",
    education_name: from_data.education_name || "",
    education_city: from_data.education_city || "",
    education_province: from_data.education_province || "",
    education_subdistrict: from_data.education_subdistrict || "",
    education_country: from_data.education_country || "",
    education_postal_code: `${from_data.education_postal_code || ""}`,
    education_graduation_year: from_data.education_graduation_year || "",
    education_major: from_data.education_major || "",
    education_grade: from_data.education_grade || "",
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Pendidikan
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Update data pendidikan anda.
            </p>
        </header>

        <form
            @submit.prevent="form.patch(route('form.update'))"
            class="mt-6 space-y-6"
        >
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="col-span-1">
                    <InputLabel
                        for="last_education"
                        value="Pendidikan Terakhir"
                    />

                    <TextInput
                        id="last_education"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.last_education"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.last_education"
                    />
                </div>

                <div class="col-span-1">
                    <InputLabel
                        for="education_number"
                        value="Nomor Edukasi (NIS/NIM)"
                    />

                    <TextInput
                        id="education_number"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.education_number"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.education_number"
                    />
                </div>

                <div class="col-span-1">
                    <InputLabel
                        for="education_name"
                        value="Nama Tempat Pendidikan"
                    />

                    <TextInput
                        id="education_name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.education_name"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.education_name"
                    />
                </div>

                <div class="col-span-1">
                    <InputLabel for="education_city" value="Kota" />

                    <TextInput
                        id="education_city"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.education_city"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.education_city"
                    />
                </div>

                <div class="col-span-1">
                    <InputLabel for="education_province" value="Provinsi" />

                    <TextInput
                        id="education_province"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.education_province"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.education_province"
                    />
                </div>

                <div class="col-span-1">
                    <InputLabel for="education_subdistrict" value="Kecamatan" />

                    <TextInput
                        id="education_subdistrict"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.education_subdistrict"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.education_subdistrict"
                    />
                </div>

                <div class="col-span-1">
                    <InputLabel for="education_country" value="Negara" />

                    <TextInput
                        id="education_country"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.education_country"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.education_country"
                    />
                </div>

                <div class="col-span-1">
                    <InputLabel for="education_postal_code" value="Nomor Pos" />

                    <TextInput
                        id="education_postal_code"
                        type="number"
                        class="mt-1 block w-full"
                        v-model="form.education_postal_code"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.education_postal_code"
                    />
                </div>

                <div class="col-span-1">
                    <InputLabel
                        for="education_graduation_year"
                        value="Tahun Kelulusan"
                    />

                    <TextInput
                        id="education_graduation_year"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.education_graduation_year"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.education_graduation_year"
                    />
                </div>

                <div class="col-span-1">
                    <InputLabel for="education_major" value="Tingkatan" />

                    <TextInput
                        id="education_major"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.education_major"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.education_major"
                    />
                </div>

                <div class="col-span-1">
                    <InputLabel for="education_grade" value="Nilai" />

                    <NumberInput
                        id="education_grade"
                        class="mt-1 block w-full"
                        v-model="form.education_grade"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.education_grade"
                    />
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
            </div>
        </form>
    </section>
</template>
