<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import Combobox from "@/Components/Combobox.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import TextareaInput from "@/Components/TextareaInput.vue";
import NumberInput from "@/Components/NumberInput.vue";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form_data = usePage().props.form;
// ['address', 'city', 'province', 'subdistrict', 'country', 'postal_code', 'rt', 'rw', 'phone_number', 'phone_number_alt']
const form = useForm({
    address: form_data.address || ``,
    city: form_data.city || ``,
    province: form_data.province || ``,
    subdistrict: form_data.subdistrict || ``,
    country: form_data.country || ``,
    postal_code: form_data.postal_code || ``,
    rt: form_data.rt || ``,
    rw: form_data.rw || ``,
    phone_number: form_data.phone_number || ``,
    phone_number_alt: form_data.phone_number_alt || "",
});

const updateDisability = () => {
    form.patch(route("form.update"), {
        preserveScroll: true,
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Alamat
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Isi alamat sesuai dengan KTP anda.
            </p>
        </header>
        <form @submit.prevent="updateDisability" class="mt-6 space-y-6">
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <InputLabel for="address" value="Alamat" />

                    <TextareaInput
                        id="address"
                        class="mt-1 block w-full"
                        type="text"
                        v-model="form.address"
                    />

                    <InputError class="mt-2" :message="form.errors.address" />
                </div>

                <div class="col-span-1">
                    <InputLabel for="city" value="Kota" />

                    <TextInput
                        id="city"
                        class="mt-1 block w-full"
                        type="text"
                        v-model="form.city"
                    />

                    <InputError class="mt-2" :message="form.errors.city" />
                </div>

                <div class="col-span-1">
                    <InputLabel for="province" value="Provinsi" />

                    <TextInput
                        id="province"
                        class="mt-1 block w-full"
                        type="text"
                        v-model="form.province"
                    />

                    <InputError class="mt-2" :message="form.errors.province" />
                </div>

                <div class="col-span-1">
                    <InputLabel for="subdistrict" value="Kecamatan" />

                    <TextInput
                        id="subdistrict"
                        class="mt-1 block w-full"
                        type="text"
                        v-model="form.subdistrict"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.subdistrict"
                    />
                </div>

                <div class="col-span-1">
                    <InputLabel for="country" value="Negara" />

                    <TextInput
                        id="country"
                        class="mt-1 block w-full"
                        type="text"
                        v-model="form.country"
                    />

                    <InputError class="mt-2" :message="form.errors.country" />
                </div>

                <div class="col-span-1">
                    <InputLabel for="postal_code" value="Kode Pos" />

                    <NumberInput
                        id="postal_code"
                        class="mt-1 block w-full"
                        v-model="form.postal_code"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.postal_code"
                    />
                </div>

                <div class="col-span-1">
                    <InputLabel for="rt" value="RT" />

                    <TextInput
                        id="rt"
                        class="mt-1 block w-full"
                        v-model="form.rt"
                    />

                    <InputError class="mt-2" :message="form.errors.rt" />
                </div>

                <div class="col-span-1">
                    <InputLabel for="rw" value="RW" />

                    <TextInput
                        id="rw"
                        class="mt-1 block w-full"
                        v-model="form.rw"
                    />

                    <InputError class="mt-2" :message="form.errors.rw" />
                </div>

                <div class="col-span-1">
                    <InputLabel for="phone_number" value="Nomor Telepon" />

                    <TextInput
                        id="phone_number"
                        class="mt-1 block w-full"
                        type="text"
                        v-model="form.phone_number"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.phone_number"
                    />
                </div>

                <div class="col-span-1">
                    <InputLabel
                        for="phone_number_alt"
                        value="Nomor Telepon Alternatif"
                    />

                    <TextInput
                        id="phone_number_alt"
                        class="mt-1 block w-full"
                        type="text"
                        v-model="form.phone_number_alt"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.phone_number_alt"
                    />
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
            </div>
        </form>
    </section>
</template>
