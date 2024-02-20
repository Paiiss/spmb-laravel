<script setup>
import { ref } from "vue";
import Container from "@/Components/Container.vue";
import Card from "@/Components/Card.vue";

defineProps({
    form: {
        default: null,
        type: Object,
    },
});
</script>
<template>
    <div>
        <Container>
            <Card
                title="Status akhir"
                description="Status akhir dari pengajuan ini"
            >
            </Card>
        </Container>
    </div>
</template>
