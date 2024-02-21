<script setup>
import Container from "@/Components/Container.vue";
import Card from "@/Components/Card.vue";

defineProps({
    wave: {
        default: null,
        type: String,
    },
});
</script>

<template>
    <Container>
        <Card title="Pendaftaran">
            <p class="text-gray-600 dark:text-gray-400">
                Formulir pendaftaran telah berhasil dikirim. Silahkan tunggu
                konfirmasi dari panitia.
            </p>
        </Card>
    </Container>
</template>
