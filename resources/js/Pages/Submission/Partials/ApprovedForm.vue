<script setup>
import Card from "@/Components/Card.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Container from "@/Components/Container.vue";
defineProps({
    form: {
        default: null,
        type: Object,
    },
});
</script>

<template>
    <Container>
        <Card
            title="Pendaftaran"
            :description="`Data anda sudah di finalisasi pada pendaftaran tahun ajaran ${form.wave.tahun_akademik}, silahkan melanjutkan ke tahap selanjutnya.`"
        >
            <div class="grid grid-cols-3 gap-2">
                <div class="col-span-3 md:col-span-1 flex justify-center">
                    <img
                        :src="form.foto"
                        alt="Foto"
                        class="w-60 h-80 rounded-lg"
                    />
                </div>
                <div class="col-span-3 md:col-span-2 flex flex-col gap-4">
                    <div
                        class="font-bold text-lg text-gray-500 dark:text-gray-300"
                    >
                        No Ujian : <span>{{ form.no_exam }}</span>
                    </div>
                    <div
                        class="font-bold text-lg text-gray-500 dark:text-gray-300"
                    >
                        <div
                            class="font-bold text-lg text-gray-500 dark:text-gray-300"
                        >
                            Nama : <span>{{ form.name }}</span>
                        </div>
                        <div
                            class="font-bold text-lg text-gray-500 dark:text-gray-300"
                        >
                            NISN : <span>{{ form.education_number }}</span>
                        </div>
                    </div>
                    <div
                        class="font-bold text-lg text-gray-500 dark:text-gray-300"
                    >
                        Tempat, Tanggal Lahir :
                        <span
                            >{{ form.birth_place_city }},
                            {{ form.birth_date }}</span
                        >
                    </div>
                    <div
                        class="font-bold text-lg text-gray-500 dark:text-gray-300"
                    >
                        Pilihan Program Studi :
                        <span>{{ form.prodi }}</span>
                    </div>
                    <div
                        class="font-bold text-lg text-gray-500 dark:text-gray-300"
                    >
                        Gelombang :
                        <span>{{ form.wave.code }}</span>
                    </div>
                    <div>
                        <PrimaryButton> Cetak Kartu Ujian </PrimaryButton>
                    </div>
                </div>
            </div>
        </Card>
    </Container>
</template>
