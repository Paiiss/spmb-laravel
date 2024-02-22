<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import Container from "@/Components/Container.vue";
import Card from "@/Components/Card.vue";
import Display from "@/Components/Display.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps({
    form: {
        default: null,
        type: Object,
    },
});

const print = async () => {
    try {
        const response = await fetch(route("form.pdf-print"), {
            method: "GET",
        });

        const pdfBlob = await response.blob();
        const url = window.URL.createObjectURL(pdfBlob);
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", "hasil-seleksi.pdf");
        document.body.appendChild(link);
        link.click();
    } catch (error) {
        console.log(error);
    }
};
</script>
<template>
    <div>
        <Container>
            <Card>
                <div class="p-0 md:p-8 relative">
                    <div class="bg-white p-14 rounded-lg shadow-md">
                        <h2 class="text-2xl font-bold text-center">
                            Panitia Penerimaan Mahasiswa Baru
                        </h2>
                        <h3
                            class="text-xl font-semibold text-center capitalize"
                        >
                            Universitas Hang Tuah Pekanbaru Tahun Ajaran
                            {{ form.wave.tahun_akademik }}
                        </h3>
                        <div class="flex flex-col gap-4 mt-24">
                            <Display label="Nama" :value="form.name" />
                            <Display label="Email" :value="form.email" />
                            <Display
                                label="Tempat, Tanggal lahir"
                                :value="`${form.birth_place_city}, ${form.birth_date}`"
                            />
                            <Display
                                label="Program Studi"
                                :value="form.prodi"
                            />
                            <Display
                                label="No. Peserta"
                                :value="form.no_exam"
                            />
                            <Display label="Status" :value="form.end_status" />

                            <div>
                                <p>
                                    Berdasarkan hasil penilaian yang telah
                                    dilakukan, peserta seleksi yang bernama
                                    {{ form.name }} dinyatakan:
                                </p>

                                <div
                                    v-if="form.end_status == 'approved'"
                                    class="bg-green-200 p-4 rounded-lg mt-4"
                                >
                                    <p
                                        class="text-green font-bold uppercase text-center"
                                    >
                                        Diterima
                                    </p>
                                </div>
                                <div v-else-if="form.end_status == 'rejected'">
                                    <div class="bg-red-200 p-4 rounded-lg mt-4">
                                        <p
                                            class="text-red font-bold uppercase text-center"
                                        >
                                            Ditolak
                                        </p>
                                    </div>
                                    <div class="mt-4">
                                        <p>
                                            Alasan penolakan:
                                            {{ form.reason_rejected }}
                                        </p>
                                    </div>
                                </div>
                                <div v-else>
                                    <div
                                        class="bg-yellow-200 p-4 rounded-lg mt-4"
                                    >
                                        <p
                                            class="text-yellow font-bold uppercase text-center"
                                        >
                                            Menunggu
                                        </p>
                                    </div>
                                    <div class="mt-4">
                                        <p class="text-center font-semibold">
                                            sedang menunggu verifikasi panitia
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="flex justify-start items-center gap-4 mt-8"
                            >
                                <PrimaryButton
                                    v-if="form.end_status == 'approved'"
                                    @click="print"
                                >
                                    Cetak Bukti Kelulusan
                                </PrimaryButton>
                            </div>
                        </div>
                    </div>

                    <div
                        v-if="form.end_status == 'submitted'"
                        class="absolute top-0 left-0 bg-gray-800 text-white p-4 rounded-lg opacity-80 w-full h-full flex justify-center items-center"
                    >
                        <p class="text-center">
                            Pengumuman belum dapat dikeluarkan karena belum
                            diverifikasi oleh admin.
                        </p>
                    </div>
                </div>
            </Card>
        </Container>
    </div>
</template>
