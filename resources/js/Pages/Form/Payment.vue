<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import DateInput from "@/Components/DateInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps();
const form = useForm({
    image: null,
    date: "",
    amount: "",
});
</script>

<template>
    <Head title="Pembayaran" />

    <AuthenticatedLayout>
        <div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <div
                    class="max-w-full p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg"
                >
                    <h2 class="font-bold text-black text-2xl">
                        Bukti pembayaran
                    </h2>
                    <div class="">
                        <p class="py-2">
                            Anda belum mengupload bukti pembayaran.
                        </p>
                    </div>
                </div>
                <div
                    class="max-w-full rounded-lg bg-white dark:bg-gray-800 p-4 sm:p-8"
                >
                    <div>
                        <h2 class="font-bold text-black text-2xl">
                            Formulir pembayaran
                        </h2>
                        <div class="py-2">
                            <p class="text-gray-500">
                                Silahkan isi formulir pembayaran dibawah ini.
                            </p>
                        </div>
                    </div>
                    <div class="pt-5">
                        <form action="" class="mt-6 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <InputLabel
                                        for="date"
                                        value="Tanggal pembayaran"
                                    />

                                    <DateInput
                                        id="date"
                                        class="mt-1 block w-full"
                                        v-model="form.date"
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.date"
                                    />
                                </div>
                                <div>
                                    <InputLabel
                                        for="date"
                                        value="Nominal pembayaran"
                                    />

                                    <TextInput
                                        id="date"
                                        class="mt-1 block w-full [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                        type="number"
                                        v-model="form.amount"
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.amount"
                                    />
                                </div>
                                <div class="col-span-2">
                                    <InputLabel
                                        for="date"
                                        value="Bukti pembayaran"
                                    />
                                    <input
                                        class="my-2 block w-full text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                        id="large_size"
                                        type="file"
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
                                        Saved.
                                    </p>
                                </Transition>
                                <PrimaryButton :disabled="form.processing"
                                    >Save</PrimaryButton
                                >
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
