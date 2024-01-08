<script setup>
import { Head, Link } from "@inertiajs/vue3";
import HomeLayout from "@/Layouts/HomeLayout.vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

const programStudi = [
    ["S1 Teknik Informatika", "Baik Sekali"],
    ["S1 Sistem Informasi", "Baik Sekali"],
    ["S2 Ilmu Kesehatan Masyarakat", "Unggul"],
    ["S1 Kesehatan Masyarakat", "Baik Sekali"],
    ["S1 Ilmu Keperawatan", "Baik"],
    ["S1 Kebidanan", "Baik"],
    ["Profesi Ners", "Baik"],
    ["Pendidikan Profesi Bidan", "Baik"],
    ["D3 RMIK", "Baik"],
    ["D3 Kebidanan", "Baik"],
    ["S1 Ilmu Hukum", "Baik"],
    ["S1 Ilmu Komunikasi", "Baik"],
];
</script>
<template>
    <Head title="Welcome" />
    <HomeLayout>
        <section
            class="p-6 md:p-16 lg:p-12 xl:p-16 from-teal-500 to-teal-200 bg-gradient-to-br"
        >
            <div class="container max-w-7xl px-6 lg:px-8 mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 items-center gap-3">
                    <div class="w-full text-white">
                        <header class="text-2xl md:text-3xl font-bold pb-3">
                            Penerimaan Mahasiwa Baru
                        </header>
                        <p class="leading-relaxed">
                            UHT Pekanbaru mempunyai tata nilai budaya akademik
                            yang khas yaitu
                            <span class="font-semibold">BERTUAH</span> mempunyai
                            makna bahwa setiap lulusan Universitas Hang Tuah
                            Pekanbaru harus memiliki kualifikasi
                        </p>
                        <div class="flex gap-3 pt-4">
                            <Link
                                :href="route('register')"
                                class="animate-pulse hover:animate-none hover:animate-pulse-none inline-flex items-center px-3 py-2 text-white bg-gray-800 rounded-lg capitalize hover:bg-gray-700 focus:outline focus:outline-2 focus:rounded-;g focus:outline-teal-950 font-semibold"
                                ><i class="fa-solid fa-user-graduate pr-2" />
                                Daftar sekarang
                            </Link>
                            <!-- <Link
                                class="inline-flex items-center px-3 py-2 text-white bg-gray-800 rounded-lg capitalize"
                            >
                                <i class="fa-solid fa-book-bookmark pr-2" />
                                Panduan PMB</Link
                            > -->
                        </div>
                    </div>
                    <div class="w-full hidden lg:block">
                        <img
                            class="rounded-xl mx-auto"
                            src="/images/pmbcover.png"
                            alt="Cover Pmb Hang Tuah Pekanbaru"
                        />
                    </div>
                </div>
            </div>
        </section>
        <section class="p-6 md:p-16 lg:p-12 xl:p-16">
            <div class="container mx-auto">
                <header
                    class="text-2xl md:text-3xl text-black text-center font-bold pb-5 mb-10 capitalize border-b-2 border-black"
                >
                    pilihan program studi
                </header>
                <div class="owl-carousel owl-theme">
                    <div
                        v-for="(program, index) in programStudi"
                        :key="index"
                        class="item p-5 bg-gray-100 rounded-xl shadow-lg"
                    >
                        <header class="font-bold text-center">
                            {{ program[0] }}
                        </header>
                        <p class="text-center font-semibold">
                            {{ program[1] }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section
            class="p-6 md:p-16 lg:p-12 xl:p-16 from-teal-500 to-teal-200 bg-gradient-to-"
        >
            <div class="container mx-auto p-6">
                <header
                    class="text-2xl text-center pb-5 mb-10 text-black font-bold capitalize border-b-2 border-black"
                >
                    Sekilas tentang kami
                </header>
                <p>
                    UHT Pekanbaru sebagai lembaga pendidikan tinggi
                    menyelenggarakan kegiatan pendidikan, penelitian dan
                    pengabdian kepada masyarakat, yang bertujuan untuk mengisi
                    kemerdekaan Negara Kesatuan Republik Indonesia sesuai dengan
                    cita-cita nasional, untuk meningkatkan mutu kehidupan serta
                    martabat manusia yang berkarakter mulia berlandaskan iman
                    dan takwa. Dalam melaksanakan fungsinya UHT berdasarkan pada
                    Pancasila sebagai falsafah bangsa dan ideologi negara.
                </p>
            </div>
        </section>
        <section class="p-6 md:p-16 lg:p-12 xl:p-16">
            <div
                class="container mx-auto bg-background-light rounded-lg p-6 text-white"
            >
                <div
                    class="grid grid-flow-row-dense grid-cols-2 md:grid-cols-3 gap-4 items-center"
                >
                    <div class="col-span-2">
                        <header
                            class="text-2xl font-bold text-left pb-3 leading-relaxed"
                        >
                            Punya pertanyaan seputar PMB
                            <span class="animate-pulse">?</span>
                        </header>
                        <p class="text-left font-semibold">
                            Jika anda memiliki sebuah pertanyaan atau kendala
                            silahkan hubungi kami atau dapat membaca panduan
                            pendaftaran
                        </p>
                    </div>
                    <div
                        class="col-span-2 md:col-span-1 space-x-3 flex justify-center"
                    >
                        <Link
                            class="p-2 bg-transparent ring-2 ring-white rounded-lg hover:bg-teal-600"
                            href="https://wa.me/6281360000000"
                        >
                            <i class="fa-brands fa-whatsapp pr-2"></i>
                            Whatsapp</Link
                        >

                        <Link
                            href=""
                            class="p-2 bg-transparent ring-2 ring-white rounded-lg hover:bg-teal-600"
                        >
                            <i class="fa-solid fa-book-bookmark pr-2" />
                            Panduan</Link
                        >
                    </div>
                </div>
            </div>
        </section>
    </HomeLayout>
</template>
