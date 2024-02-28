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
                        <div
                            class="flex items-center justify-between bg-white p-4 rounded-lg shadow-md"
                        >
                            <div class="bg-blue-100 p-4 rounded-full mr-4">
                                <i
                                    class="fas fa-users text-4xl text-blue-500"
                                ></i>
                            </div>
                            <div
                                class="flex flex-col justify-center items-center"
                            >
                                <div class="text-2xl font-bold">
                                    {{ data_count ? data_count.users : 0 }}
                                </div>
                                <div>Pengguna</div>
                            </div>
                        </div>
                        <div
                            class="flex items-center justify-between bg-white p-4 rounded-lg shadow-md"
                        >
                            <div class="bg-yellow-100 p-4 rounded-full mr-4">
                                <i
                                    class="fas fa-graduation-cap text-4xl text-green-500"
                                />
                            </div>
                            <div
                                class="flex flex-col justify-center items-center"
                            >
                                <div class="text-2xl font-bold">
                                    {{ data_count ? data_count.forms : 0 }}
                                </div>
                                <div>Formulir</div>
                            </div>
                        </div>
                        <div
                            class="flex items-center justify-between bg-white p-4 rounded-lg shadow-md"
                        >
                            <div class="bg-red-100 p-4 rounded-full mr-4">
                                <i
                                    class="fas fa-graduation-cap text-4xl text-red-500"
                                />
                            </div>
                            <div
                                class="flex flex-col justify-center items-center"
                            >
                                <div class="text-2xl font-bold">
                                    {{ data_count ? data_count.prodi : 0 }}
                                </div>
                                <div>Prodi</div>
                            </div>
                        </div>
                        <div
                            class="flex items-center justify-between bg-white p-4 rounded-lg shadow-md"
                        >
                            <div class="bg-orange-100 p-4 rounded-full mr-4">
                                <i
                                    class="fas fa-water text-4xl text-orange-500"
                                />
                            </div>
                            <div
                                class="flex flex-col justify-center items-center"
                            >
                                <div class="text-2xl font-bold">
                                    {{ data_count ? data_count?.wave : 0 }}
                                </div>
                                <div>Gel. Aktif</div>
                            </div>
                        </div>
                    </Grid>
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
