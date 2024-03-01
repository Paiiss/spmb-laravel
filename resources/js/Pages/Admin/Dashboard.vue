<script setup>
import { ref, onMounted } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import Container from "@/Components/Container.vue";
import Card from "@/Components/Card.vue";
import Grid from "@/Components/Grid.vue";
import {
    Chart,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
} from "chart.js";
import { Bar } from "vue-chartjs";
import CardStats from "@/Components/CardStats.vue";

Chart.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend);

const data_chart = ref(null);
const data_count = ref(null);
const options = ref({
    responsive: true,
});

onMounted(() => {
    fetch(route("admin.dashboard.chart"))
        .then((response) => response.json())
        .then((data) => {
            data_chart.value = data.data.chart;
            data_count.value = data.data.count;
        });
});
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <div>
            <Container>
                <h2 class="text-2xl font-bold">Dashboard</h2>

                <Grid col="1">
                    <Grid col="1" sm="2" md="4" lg="4">
                        <CardStats
                            label="Pengguna"
                            icon="fa-solid fa-users"
                            color="blue"
                            :value="data_count ? data_count.users : 0"
                        />
                        <CardStats
                            label="Formulir"
                            icon="fa-solid fa-graduation-cap"
                            color="green"
                            :value="data_count ? data_count.forms : 0"
                        />
                        <CardStats
                            label="Prodi"
                            icon="fa-solid fa-graduation-cap"
                            color="red"
                            :value="data_count ? data_count?.prodi : 0"
                        />
                        <CardStats
                            label="Gel. Aktif"
                            icon="fa-solid fa-water"
                            color="orange"
                            :value="data_count ? data_count?.wave : 0"
                        />
                    </Grid>
                    <div>
                        <h2 class="text-xl font-bold mt-8 mb-4">
                            Antrian Verifikasi Formulir Mahasiswa
                        </h2>
                        <Grid col="1" sm="2" md="4" lg="4">
                            <CardStats
                                label="Formulir"
                                icon="fa-solid fa-user-tie"
                                color="blue"
                                :value="
                                    data_count
                                        ? data_count?.validation?.forms
                                        : 0
                                "
                            />

                            <CardStats
                                label="Penetuan"
                                icon="fa-solid fa-person-circle-question"
                                color="green"
                                :value="
                                    data_count
                                        ? data_count?.validation?.graduation
                                        : 0
                                "
                            />
                            <CardStats
                                label="Pembayaran"
                                icon="fa-solid fa-cash-register"
                                color="red"
                                :value="
                                    data_count
                                        ? data_count?.validation?.payment
                                        : 0
                                "
                            />
                            <CardStats
                                label="MCU"
                                icon="fa-solid fa-stethoscope"
                                color="orange"
                                :value="
                                    data_count
                                        ? data_count?.validation?.medical_check
                                        : 0
                                "
                            />
                            <CardStats
                                label="Wawancara"
                                icon="fa-solid fa-user-check"
                                color="yellow"
                                :value="
                                    data_count
                                        ? data_count?.validation?.interview
                                        : 0
                                "
                            />
                        </Grid>
                    </div>
                    <Card title="Statistik">
                        <Bar
                            v-if="data_chart"
                            :data="data_chart"
                            :options="options"
                        />
                    </Card>
                </Grid>
            </Container>
        </div>
    </AuthenticatedLayout>
</template>
