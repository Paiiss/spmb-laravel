<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage, router } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import Modal from "@/Components/Modal.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextareaInput from "@/Components/TextareaInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

defineProps({
    form: Object,
    user: Object,
    prodi: Object,
    wave: Object,
    image: Object,
});

const navigateTo = (url) => {
    if (url === null) return;
    return router.visit(url);
};

const modalDocument = ref(false);
const modalItem = ref(null);
const modalType = ref(null);
const open = (type, item = null) => {
    modalDocument.value = true;
    modalItem.value = item;
    modalType.value = type;
};
const close = () => {
    modalDocument.value = false;
    modalItem.value = null;
    modalType.value = null;
};
</script>

<template>
    <Head title="Validasi Formulir" />
    <AuthenticatedLayout>
        <div>
            <div class="max-w-6xl mx-auto">
                <div class="flex justify-between pb-5">
                    <div class="flex items-center justify-start">
                        <button
                            class="inline-flex justify-center items-center w-12 h-12 rounded-full bg-white text-black dark:bg-slate-900/70 dark:text-white mr-3"
                            @click="navigateTo(route('admin.verification'))"
                        >
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <h1 class="text-xl leading-tight font-semibold">
                            {{ user.name }}
                        </h1>
                    </div>
                </div>
                <div
                    class="bg-white p-4 sm:p-8 shadow-md sm:shadow-lg rounded-lg"
                >
                    <div class="flex flex-col gap-4">
                        <div>
                            <header>
                                <h2 class="font-bold text-lg">Data Pribadi</h2>
                            </header>

                            <div class="pt-8 grid grid-cols-4 gap-3">
                                <div class="col-span-4 md:col-span-2">
                                    <InputLabel for="name">Nama</InputLabel>
                                    <TextInput
                                        type="text"
                                        :value="user.name"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-4 md:col-span-2">
                                    <InputLabel for="email" value="Email" />
                                    <TextInput
                                        type="text"
                                        :value="user.email"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel for="phone" value="No. HP" />
                                    <TextInput
                                        type="text"
                                        :value="user.phone"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel
                                        for="national_id"
                                        value="Nomor penduduk"
                                    />
                                    <TextInput
                                        type="text"
                                        :value="form.national_id"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel
                                        for="gender"
                                        value="Jenis kelamin"
                                    />
                                    <TextInput
                                        type="text"
                                        :value="form.gender"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel for="religion" value="Agama" />
                                    <TextInput
                                        type="text"
                                        :value="form.religion"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel
                                        for="birth_date"
                                        value="Tanggal Lahir"
                                    />
                                    <TextInput
                                        type="text"
                                        :value="form.birth_date"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel
                                        for="birth_place_city"
                                        value="Kota kelahiran"
                                    />
                                    <TextInput
                                        type="text"
                                        :value="form.birth_place_city"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel
                                        for="birth_place_province"
                                        value="Provinsi kelahiran"
                                    />
                                    <TextInput
                                        type="text"
                                        :value="form.birth_place_province"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel
                                        for="birth_place_country"
                                        value="Negara kelahiran"
                                    />
                                    <TextInput
                                        type="text"
                                        :value="form.birth_place_country"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                            </div>
                        </div>
                        <div>
                            <header>
                                <h2 class="font-bold text-lg">Alamat</h2>
                            </header>
                            <div class="pt-8 grid grid-cols-4 gap-3">
                                <div class="col-span-4">
                                    <InputLabel for="address" value="Alamat" />
                                    <TextareaInput
                                        type="text"
                                        :value="
                                            form.address ? form.address : '-'
                                        "
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel for="city" value="Kota" />
                                    <TextInput
                                        type="text"
                                        :value="form.city"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel
                                        for="province"
                                        value="Provinsi"
                                    />
                                    <TextInput
                                        type="text"
                                        :value="form.province"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel
                                        for="subdistrict"
                                        value="Kecamatan"
                                    />
                                    <TextInput
                                        type="text"
                                        :value="form.subdistrict"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel for="country" value="Negara" />
                                    <TextInput
                                        type="text"
                                        :value="form.country"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel
                                        for="province"
                                        value="Provinsi"
                                    />
                                    <TextInput
                                        type="text"
                                        :value="form.province"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel
                                        for="postal_code"
                                        value="Kode pos"
                                    />
                                    <TextInput
                                        type="text"
                                        :value="form.postal_code"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel for="rt" value="Rt" />
                                    <TextInput
                                        type="text"
                                        :value="form.rt"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel for="rw" value="rw" />
                                    <TextInput
                                        type="text"
                                        :value="form.rw"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel
                                        for="phone_number"
                                        value="No. HP"
                                    />
                                    <TextInput
                                        type="text"
                                        :value="form.phone_number"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel
                                        for="phone_number_alt"
                                        value="No. HP alternatif"
                                    />
                                    <TextInput
                                        type="text"
                                        :value="form.phone_number_alt"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                            </div>
                        </div>
                        <div>
                            <header>
                                <h2 class="font-bold text-lg">Kesehatan</h2>
                            </header>

                            <div class="pt-8 grid grid-cols-4 gap-3">
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel
                                        for="is_color_blind"
                                        value="Buta warna"
                                    />
                                    <TextInput
                                        type="text"
                                        :value="
                                            form.is_color_blind ? 'Ya' : 'Tidak'
                                        "
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel
                                        for="is_disability"
                                        value="Disabilitas"
                                    />
                                    <TextInput
                                        type="text"
                                        :value="
                                            form.is_disability ? 'Ya' : 'Tidak'
                                        "
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-4 md:col-span-4">
                                    <InputLabel
                                        for="disability_note"
                                        value="Catatan disabilitas"
                                    />
                                    <TextareaInput
                                        type="text"
                                        :value="
                                            form.disability_note
                                                ? form.disability_note
                                                : '-'
                                        "
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                            </div>
                        </div>
                        <div>
                            <header>
                                <h2 class="font-bold text-lg">Pendidikan</h2>
                            </header>

                            <div class="pt-8 grid grid-cols-4 gap-3">
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel
                                        for="last_education"
                                        value="Pendidikan terakhir"
                                    />
                                    <TextInput
                                        type="text"
                                        :value="form.last_education"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel
                                        for="education_number"
                                        value="Nomor siswa / mahasiswa"
                                    />
                                    <TextInput
                                        type="text"
                                        :value="form.education_number"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>

                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel
                                        for="education_name"
                                        value="Nama sekolah / perguruan tinggi"
                                    />
                                    <TextInput
                                        type="text"
                                        :value="form.education_name"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel
                                        for="education_graduation_year"
                                        value="Tahun lulus"
                                    />
                                    <TextInput
                                        type="text"
                                        :value="form.education_graduation_year"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel
                                        for="education_city"
                                        value="Kota"
                                    />
                                    <TextInput
                                        type="text"
                                        :value="form.education_city"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel
                                        for="education_province"
                                        value="Provinsi"
                                    />
                                    <TextInput
                                        type="text"
                                        :value="form.education_province"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel
                                        for="education_subdistrict"
                                        value="Kecamatan"
                                    />
                                    <TextInput
                                        type="text"
                                        :value="form.education_subdistrict"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel
                                        for="education_country"
                                        value="Negara"
                                    />
                                    <TextInput
                                        type="text"
                                        :value="form.education_country"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel
                                        for="education_postal_code"
                                        value="Kode pos"
                                    />
                                    <TextInput
                                        type="text"
                                        :value="form.education_postal_code"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>

                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel
                                        for="education_major"
                                        value="Jurusan"
                                    />
                                    <TextInput
                                        type="text"
                                        :value="form.education_major"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <InputLabel
                                        for="education_grade"
                                        value="Nilai akhir"
                                    />
                                    <TextInput
                                        type="text"
                                        :value="form.education_grade"
                                        disabled
                                        class="mt-1 block w-full"
                                    />
                                </div>
                            </div>
                        </div>
                        <div>
                            <header>
                                <h2 class="font-bold text-lg">
                                    Orang Tua/Wali
                                </h2>
                            </header>
                            <div class="flex flex-col gap-4 pt-8">
                                <div>
                                    <header>
                                        <h2 class="font-semibold text-base">
                                            Ayah
                                        </h2>
                                    </header>
                                    <div class="pt-3 grid grid-cols-4 gap-3">
                                        <div class="col-span-4 md:col-span-2">
                                            <InputLabel
                                                for="father_name"
                                                value="Nama"
                                            />
                                            <TextInput
                                                type="text"
                                                :value="form.father_name"
                                                disabled
                                                class="mt-1 block w-full"
                                            />
                                        </div>
                                        <div class="col-span-2 md:col-span-1">
                                            <InputLabel
                                                for="father_birth_date"
                                                value="Tanggal lahir"
                                            />
                                            <TextInput
                                                type="text"
                                                :value="form.father_birth_date"
                                                disabled
                                                class="mt-1 block w-full"
                                            />
                                        </div>
                                        <div class="col-span-2 md:col-span-1">
                                            <InputLabel
                                                for="father_place"
                                                value="Tempat lahir"
                                            />
                                            <TextInput
                                                type="text"
                                                :value="form.father_place"
                                                disabled
                                                class="mt-1 block w-full"
                                            />
                                        </div>
                                        <div class="col-span-2 md:col-span-1">
                                            <InputLabel
                                                for="father_last_education"
                                                value="Pendidikan terakhir"
                                            />
                                            <TextInput
                                                type="text"
                                                :value="
                                                    form.father_last_education
                                                "
                                                disabled
                                                class="mt-1 block w-full"
                                            />
                                        </div>
                                        <div class="col-span-2 md:col-span-1">
                                            <InputLabel
                                                for="father_job"
                                                value="Pekerjaan"
                                            />
                                            <TextInput
                                                type="text"
                                                :value="form.father_job"
                                                disabled
                                                class="mt-1 block w-full"
                                            />
                                        </div>
                                        <div class="col-span-2 md:col-span-1">
                                            <InputLabel
                                                for="father_phone"
                                                value="No. HP"
                                            />
                                            <TextInput
                                                type="text"
                                                :value="form.father_phone"
                                                disabled
                                                class="mt-1 block w-full"
                                            />
                                        </div>
                                        <div class="col-span-2 md:col-span-1">
                                            <InputLabel
                                                for="father_email"
                                                value="Email"
                                            />
                                            <TextInput
                                                type="text"
                                                :value="form.father_email"
                                                disabled
                                                class="mt-1 block w-full"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <header>
                                        <h2 class="font-semibold text-base">
                                            Ibu
                                        </h2>
                                    </header>
                                    <div class="pt-3 grid grid-cols-4 gap-3">
                                        <div class="col-span-4 md:col-span-2">
                                            <InputLabel
                                                for="mother_name"
                                                value="Nama"
                                            />
                                            <TextInput
                                                type="text"
                                                :value="form.mother_name"
                                                disabled
                                                class="mt-1 block w-full"
                                            />
                                        </div>
                                        <div class="col-span-2 md:col-span-1">
                                            <InputLabel
                                                for="mother_birth_date"
                                                value="Tanggal lahir"
                                            />
                                            <TextInput
                                                type="text"
                                                :value="form.mother_birth_date"
                                                disabled
                                                class="mt-1 block w-full"
                                            />
                                        </div>
                                        <div class="col-span-2 md:col-span-1">
                                            <InputLabel
                                                for="mother_place"
                                                value="Tempat lahir"
                                            />
                                            <TextInput
                                                type="text"
                                                :value="form.mother_place"
                                                disabled
                                                class="mt-1 block w-full"
                                            />
                                        </div>
                                        <div class="col-span-2 md:col-span-1">
                                            <InputLabel
                                                for="mother_last_education"
                                                value="Pendidikan terakhir"
                                            />
                                            <TextInput
                                                type="text"
                                                :value="
                                                    form.mother_last_education
                                                "
                                                disabled
                                                class="mt-1 block w-full"
                                            />
                                        </div>
                                        <div class="col-span-2 md:col-span-1">
                                            <InputLabel
                                                for="mother_job"
                                                value="Pekerjaan"
                                            />
                                            <TextInput
                                                type="text"
                                                :value="form.mother_job"
                                                disabled
                                                class="mt-1 block w-full"
                                            />
                                        </div>
                                        <div class="col-span-2 md:col-span-1">
                                            <InputLabel
                                                for="mother_phone"
                                                value="No. HP"
                                            />
                                            <TextInput
                                                type="text"
                                                :value="form.mother_phone"
                                                disabled
                                                class="mt-1 block w-full"
                                            />
                                        </div>
                                        <div class="col-span-2 md:col-span-1">
                                            <InputLabel
                                                for="mother_email"
                                                value="Email"
                                            />
                                            <TextInput
                                                type="text"
                                                :value="form.mother_email"
                                                disabled
                                                class="mt-1 block w-full"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <header>
                                        <h2 class="font-semibold text-base">
                                            Wali
                                        </h2>
                                    </header>
                                    <div class="pt-3 grid grid-cols-4 gap-3">
                                        <div class="col-span-4 md:col-span-2">
                                            <InputLabel
                                                for="guardian_name"
                                                value="Nama"
                                            />
                                            <TextInput
                                                type="text"
                                                :value="form.guardian_name"
                                                disabled
                                                class="mt-1 block w-full"
                                            />
                                        </div>
                                        <div class="col-span-2 md:col-span-1">
                                            <InputLabel
                                                for="guardian_birth_date"
                                                value="Tanggal lahir"
                                            />
                                            <TextInput
                                                type="text"
                                                :value="
                                                    form.guardian_birth_date
                                                "
                                                disabled
                                                class="mt-1 block w-full"
                                            />
                                        </div>
                                        <div class="col-span-2 md:col-span-1">
                                            <InputLabel
                                                for="guardian_place"
                                                value="Tempat lahir"
                                            />
                                            <TextInput
                                                type="text"
                                                :value="form.guardian_place"
                                                disabled
                                                class="mt-1 block w-full"
                                            />
                                        </div>
                                        <div class="col-span-2 md:col-span-1">
                                            <InputLabel
                                                for="guardian_last_education"
                                                value="Pendidikan terakhir"
                                            />
                                            <TextInput
                                                type="text"
                                                :value="
                                                    form.guardian_last_education
                                                "
                                                disabled
                                                class="mt-1 block w-full"
                                            />
                                        </div>
                                        <div class="col-span-2 md:col-span-1">
                                            <InputLabel
                                                for="guardian_job"
                                                value="Pekerjaan"
                                            />
                                            <TextInput
                                                type="text"
                                                :value="form.guardian_job"
                                                disabled
                                                class="mt-1 block w-full"
                                            />
                                        </div>
                                        <div class="col-span-2 md:col-span-1">
                                            <InputLabel
                                                for="guardian_phone"
                                                value="No. HP"
                                            />
                                            <TextInput
                                                type="text"
                                                :value="form.guardian_phone"
                                                disabled
                                                class="mt-1 block w-full"
                                            />
                                        </div>
                                        <div class="col-span-2 md:col-span-1">
                                            <InputLabel
                                                for="guardian_email"
                                                value="Email"
                                            />
                                            <TextInput
                                                type="text"
                                                :value="form.guardian_email"
                                                disabled
                                                class="mt-1 block w-full"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <header>
                                <h2 class="font-bold text-lg">Dokument</h2>
                            </header>
                            <div class="pt-8 grid grid-cols-2 gap-3">
                                <div
                                    class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4"
                                    v-for="(document, index) in image"
                                    :key="index"
                                >
                                    <header>
                                        <h3
                                            class="font-semibold text-gray-900 dark:text-gray-100 capitalize"
                                        >
                                            {{ index.replace("_", " ") }}
                                        </h3>
                                    </header>
                                    <button
                                        class="mt-4 h-40 w-full hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg overflow-hidden"
                                        @click="open(index, document)"
                                    >
                                        <img
                                            v-if="document"
                                            :src="document"
                                            :alt="index"
                                            class="overflow-hidden object-cover w-full h-full rounded-lg"
                                        />

                                        <div
                                            v-else
                                            class="flex items-center justify-center h-full"
                                        >
                                            <p class="text-gray-400">
                                                Belum ada
                                                {{ index.replace("_", " ") }}
                                                yang diunggah
                                            </p>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <Modal :show="modalDocument" @close="close()">
                <div class="p-6">
                    <h2
                        class="text-lg font-medium text-gray-900 dark:text-gray-100"
                    >
                        View {{ modalType }}
                    </h2>

                    <img
                        :src="modalItem"
                        :alt="`Bukti pembayaran ${modalType}`"
                    />
                    <div class="mt-6">
                        <SecondaryButton @click="close" class="ml-2">
                            Cancel
                        </SecondaryButton>
                    </div>
                </div>
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>
