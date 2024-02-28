<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
defineProps({});

const goToForm = () => {
    return route("form.edit", { id: "personal" });
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Dashboard
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:shadow-lg sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h1 class="font-bold text-2xl">
                            Selamat Datang di Sistem Pendaftaran Mahasiswa Baru
                            <br />
                            {{ $page.props.auth.user.name }} 👋
                        </h1>
                        <p v-if="!$page.props.auth.form.already">
                            Apakah anda akan mendaftar sebagai mahasiswa baru?
                            silahkan klik tombol dibawah ini.
                        </p>
                        <p v-else>Silahkan lanjut mengisi form pendaftaran.</p>
                        <div class="flex justify-start mt-4">
                            <PrimaryButton
                                ><Link
                                    :href="
                                        route('form.edit', { id: 'personal' })
                                    "
                                    >{{
                                        $page.props.auth.form.already
                                            ? "Lanjut"
                                            : "Bikin formulir"
                                    }}</Link
                                >
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:shadow-lg sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h1 class="font-bold text-2xl">Panduan pengisian</h1>
                        <ol
                            class="relative border-s border-gray-200 dark:border-gray-700"
                        >
                            <li class="mb-10 ms-4">
                                <div
                                    class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"
                                ></div>
                                <time
                                    class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500"
                                    >Langkah pertama</time
                                >
                                <h3
                                    class="text-lg font-semibold text-gray-900 dark:text-white"
                                >
                                    Ajukan pembelian formulir
                                </h3>
                                <p
                                    class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400"
                                >
                                    Pilih gelombang pendaftaran dan pilih jursan
                                    yang anda inginkan di menu
                                    <Link
                                        :href="route('form.submission')"
                                        class="text-blue-600 hover:underline"
                                        >pendaftaran</Link
                                    >.
                                </p>
                            </li>
                            <li class="mb-10 ms-4">
                                <div
                                    class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"
                                ></div>
                                <time
                                    class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500"
                                    >Langkah kedua</time
                                >
                                <h3
                                    class="text-lg font-semibold text-gray-900 dark:text-white"
                                >
                                    Isi setiap formulir
                                </h3>
                                <p
                                    class="text-base font-normal text-gray-500 dark:text-gray-400"
                                >
                                    Isi setiap formulir dengan benar dan sesuai
                                    dengan identitas diri anda di menu
                                    <Link
                                        class="text-blue-600 hover:underline"
                                        :href="
                                            route('form.edit', {
                                                id: 'personal',
                                            })
                                        "
                                        >data diri</Link
                                    >
                                </p>
                            </li>
                            <li class="mb-10 ms-4">
                                <div
                                    class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"
                                ></div>
                                <time
                                    class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500"
                                    >Langkah ketiga</time
                                >
                                <h3
                                    class="text-lg font-semibold text-gray-900 dark:text-white"
                                >
                                    Jika sudah lengkap, ikuti semua tes yang ada
                                </h3>
                                <p
                                    class="text-base font-normal text-gray-500 dark:text-gray-800"
                                >
                                    Tes akan dilakukan secara online, pastikan
                                    koneksi internet anda stabil dan tidak ada
                                    gangguan.
                                </p>
                            </li>

                            <li class="ms-4">
                                <div
                                    class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"
                                ></div>
                                <time
                                    class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500"
                                    >Langkah keempat</time
                                >
                                <h3
                                    class="text-lg font-semibold text-gray-900 dark:text-white"
                                >
                                    Tunggu pengumuman
                                </h3>
                                <p
                                    class="text-base font-normal text-gray-500 dark:text-gray-800"
                                >
                                    Panitia akan mengumumkan hasil seleksi
                                    penerimaan mahasiswa baru di menu
                                    <Link
                                        class="text-blue-600 hover:underline"
                                        :href="route('form.submission')"
                                        >pendaftaran</Link
                                    >.
                                </p>
                            </li>
                        </ol>

                        <footer class="flex justify-end mt-4">
                            <p class="text-gray-300 dark:text-gray-400 text-sm">
                                cumungut :3
                            </p>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
