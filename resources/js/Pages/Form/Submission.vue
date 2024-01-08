<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps();
const form = useForm({
    gelombang: "",
    pilihan_1: "",
    pilihan_2: "",
});
</script>

<template>
    <Head title="Submission" />

    <AuthenticatedLayout>
        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div
                    class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg"
                >
                    <h2 class="font-bold text-left text-black text-2xl">
                        Pendaftaran
                    </h2>
                    <p>
                        Ajukan pendaftaran untuk mendaftar di gelombang yang
                        tersedia
                    </p>
                    <div class="pt-8">
                        <form action="" class="mt-6 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <InputLabel
                                        for="gelombang"
                                        value="Gelombang"
                                    />

                                    <TextInput
                                        id="gelombang"
                                        class="mt-1 block w-full"
                                        type="text"
                                        v-model="form.gelombang"
                                        autofocus
                                        autocomplete="gelombang"
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.gelombang"
                                    />
                                </div>
                                <div>
                                    <InputLabel
                                        for="pilihan_1"
                                        value="Pilihan 1"
                                    />

                                    <TextInput
                                        id="pilihan_1"
                                        class="mt-1 block w-full"
                                        type="text"
                                        v-model="form.pilihan_1"
                                        autofocus
                                        autocomplete="pilihan_1"
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.pilihan_1"
                                    />
                                </div>
                                <div>
                                    <InputLabel
                                        for="pilihan_2"
                                        value="Pilihan 2"
                                    />

                                    <TextInput
                                        id="pilihan_2"
                                        class="mt-1 block w-full"
                                        type="text"
                                        v-model="form.pilihan_2"
                                        autofocus
                                        autocomplete="pilihan_2"
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.pilihan_2"
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
        </div>
    </AuthenticatedLayout>
</template>
