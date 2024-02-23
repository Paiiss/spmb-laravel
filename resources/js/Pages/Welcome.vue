<script setup>
import { Head, Link } from "@inertiajs/vue3";
import HomeLayout from "@/Layouts/HomeLayout.vue";
import { Carousel, Navigation, Pagination, Slide } from "vue3-carousel";

import "vue3-carousel/dist/carousel.css";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
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

const cooperate = [
    ["https://unp.ac.id/", "https://htp.ac.id/asset/kerjasama/UNP.png"],
    ["https://umsu.ac.id/", "https://htp.ac.id/asset/kerjasama/UMSU.png"],
    ["https://uisi.ac.id/", "https://htp.ac.id/asset/kerjasama/UISI.png"],
    [
        "https://lincoln.edu.my/",
        "https://htp.ac.id/asset/kerjasama/LINCOLN.png",
    ],
    [
        "https://dinkes.riau.go.id/",
        "https://htp.ac.id/asset/kerjasama/Bakti-Husada.png",
    ],
    ["https://upiyptk.ac.id/", "https://htp.ac.id/asset/kerjasama/upi.png"],
];

const setting_carousel = {
    autoplay: 3000,
    settings: {
        itemsToShow: 1,
        snapAlign: "center",
        loop: true,
    },
    breakpoints: {
        700: {
            itemsToShow: 3.5,
            snapAlign: "center",
        },
        1024: {
            itemsToShow: 5,
            snapAlign: "start",
        },
    },
};
</script>
<template>
    <Head title="PMB" />
    <HomeLayout>
        <section
            class="min-h-screen p-6 md:p-16 lg:p-12 xl:p-16 flex items-center"
        >
            <div class="container px-6 lg:px-8 mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 items-center gap-3">
                    <div class="w-full text-gray-900">
                        <h1 class="text-2xl md:text-5xl font-bold pb-3">
                            Penerimaan Mahasiwa Baru
                        </h1>
                        <div class="pb-3">
                            <h2 class="text-xl md:text-3xl font-semibold">
                                {{ $page.props.web_settings.institution_name }}
                            </h2>
                            <p class="leading-relaxed">
                                {{
                                    $page.props.web_settings
                                        .institution_synopsis
                                }}
                            </p>
                            <div class="flex gap-3 pt-4">
                                <Link
                                    :href="route('register')"
                                    class="relative -top-1 -left-1 bg-gray-800 py-2.5 px-5 font-medium uppercase text-white transition-all before:absolute before:top-1 before:left-1 before:-z-[1] before:h-full before:w-full before:border-2 before:border-gray-700 before:transition-all before:content-[''] hover:top-0 hover:left-0 before:hover:top-0 before:hover:left-0 rounded-md"
                                    ><i
                                        class="fa-solid fa-user-graduate pr-2"
                                    />
                                    Daftar sekarang
                                </Link>
                            </div>
                        </div>
                    </div>
                    <div class="w-full hidden lg:block">
                        <img
                            class="mx-auto"
                            src="/images/pmbcover.png"
                            alt="Cover Pmb Hang Tuah
                        Pekanbaru"
                        />
                    </div>
                </div>
            </div>
        </section>
        <!--  <section class="p-6 md:p-16 lg:p-12 xl:p-16">
            <div class="container mx-auto">
                <h2
                    class="text-2xl md:text-3xl text-black text-center font-bold pb-5 mb-10 capitalize"
                >
                    pilihan
                    <span class="relative inline-block">
                        <span
                            class="absolute inline-block w-full h-2 bg-teal-300 bottom-1.5"
                        ></span>
                        <span class="relative"> program studi</span>
                    </span>
                </h2>
                <div class="owl-carousel owl-theme">
                    <div
                        v-for="(program, index) in programStudi"
                        :key="index"
                        class="item p-5 bg-gray-200 rounded-xl shadow-lg"
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
        </section> -->

        <section class="p-6 md:p-16 lg:p-12 xl:p-16">
            <div class="container mx-auto p-6">
                <header
                    class="text-2xl text-center pb-5 mb-10 text-black font-bold capitalize"
                >
                    Sekilas tentang kami
                </header>
                <p class="text-wrap text-ellipsis">
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
            <div class="container mx-auto p-6">
                <h2
                    class="text-2xl text-center pb-5 mb-10 text-black font-bold capitalize"
                >
                    Bekerja sama dengan
                </h2>
                <Carousel
                    :itemsToShow="3.95"
                    :wrapAround="true"
                    :transition="500"
                    :autoplay="setting_carousel.autoplay"
                    v-bind="setting_carousel.settings"
                    :breakpoints="setting_carousel.breakpoints"
                >
                    <Slide v-for="(x, index) in cooperate" :key="index">
                        <div class="flex p-5">
                            <a
                                :href="x[0]"
                                target="_blank"
                                class="flex items-center justify-center"
                            >
                                <img
                                    :src="x[1]"
                                    alt="Cooperate"
                                    class="w-20 h-20"
                                />
                            </a>
                        </div>
                    </Slide>

                    <template #addons>
                        <Navigation />
                        <Pagination />
                    </template>
                </Carousel>
            </div>
        </section>

        <section class="p-6 md:p-16 lg:p-12 xl:p-16">
            <div
                class="container mx-auto bg-background-primary rounded-lg p-6 text-white"
            >
                <div class="flex flex-col md:flex-row justify-between">
                    <div>
                        <h5
                            class="text-2xl font-bold text-left pb-3 leading-relaxed"
                        >
                            Punya pertanyaan seputar PMB
                            <span class="animate-pulse">?</span>
                        </h5>
                        <p class="text-left font-normal">
                            Jika anda memiliki sebuah pertanyaan atau kendala
                            silahkan hubungi kami atau dapat membaca panduan
                            pendaftaran
                        </p>
                    </div>
                    <div class="flex mt-5 md:mt-0">
                        <div
                            class="flex flex-row gap-3 items-center sm:flex-row sm:gap-5 sm:justify-end sm:items-center"
                        >
                            <Link
                                class="p-2 bg-transparent ring-2 ring-white rounded-lg hover:bg-teal-600 text-xs sm:text-base"
                                href="https://wa.me/6281360000000"
                            >
                                <span class="flex items-center justify-center">
                                    <i class="fa-brands fa-whatsapp pr-2"></i>
                                    Whatsapp
                                </span>
                            </Link>

                            <Link
                                href=""
                                class="p-2 bg-transparent ring-2 ring-white rounded-lg hover:bg-teal-600 text-xs sm:text-base"
                            >
                                <span class="flex items-center justify-center">
                                    <i class="fa-solid fa-book-bookmark pr-2" />
                                    Panduan
                                </span>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </HomeLayout>
</template>
