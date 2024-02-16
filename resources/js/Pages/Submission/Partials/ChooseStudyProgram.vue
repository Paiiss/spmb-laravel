<script setup>
import { ref, onMounted } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Combobox from "@/Components/Combobox.vue";
import axios from "axios";

const form = useForm({
    wave: "",
    option: "",
    option_2: "",
}).transform((data) => ({
    wave: data.wave ? parseInt(data.wave) : "",
    option: data.option ? parseInt(data.option) : "",
    option_2: data.option_2 ? parseInt(data.option_2) : null,
}));

const submit = () => {
    form.post(route("form.submission.store"), {
        preserveScroll: true,
        onSuccess: () => {},
    });
};

const choices = ref([]);
const choicesProdi = ref([]);
onMounted(() => {
    if (!usePage().props?.form_status) {
        axios
            .get("/api/gelombang")
            .then((response) => {
                choices.value = response.data.data.map((item) => ({
                    value: `${item.id}`,
                    text: item.gelombang,
                }));
                choices.value.unshift({
                    value: "",
                    text: "Pilih Gelombang",
                });
            })
            .catch((error) => {});

        axios.get("/api/program-studi").then((response) => {
            choicesProdi.value = response.data.data.map((item) => ({
                value: `${item.id}`,
                text: item.nama_prodi,
            }));
            choicesProdi.value.unshift({
                value: "",
                text: "Pilih Prodi",
            });
        });
    }
});
</script>

<template>
    <div class="max-w-7xl min-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <h2 class="font-bold text-left text-black text-2xl">Pendaftaran</h2>
            <p>Ajukan pendaftaran untuk mendaftar di gelombang yang tersedia</p>
            <div class="pt-8">
                <form @submit.prevent="submit" class="mt-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <InputLabel for="gelombang" value="Gelombang" />

                            <Combobox
                                id="gelombang"
                                class="mt-1 block w-full"
                                v-model="form.wave"
                                :option-value="choices"
                                :placeholder="'Pilih Gelombang'"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.wave"
                            />
                        </div>
                        <div>
                            <InputLabel for="pilihan_1" value="Pilihan 1" />

                            <Combobox
                                id="pilihan_1"
                                class="mt-1 block w-full"
                                v-model="form.option"
                                :option-value="choicesProdi"
                                :placeholder="'Pilih Prodi'"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.option"
                            />
                        </div>
                        <div>
                            <InputLabel for="pilihan_2" value="Pilihan 2" />

                            <Combobox
                                id="pilihan_2"
                                class="mt-1 block w-full"
                                v-model="form.option_2"
                                :option-value="choicesProdi"
                                :placeholder="'Pilih Prodi'"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.option_2"
                            />
                        </div>
                    </div>
                    <div class="flex justify-end gap-4">
                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p
                                v-if="form.recentlySuccessful"
                                class="text-sm text-gray-600 dark:text-gray-400 items-center flex gap-2"
                            >
                                Berhasil mengajukan
                            </p>
                        </Transition>
                        <PrimaryButton :disabled="form.processing"
                            >Daftar</PrimaryButton
                        >
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
