<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import IconButton from "@/Components/IconButton.vue";
import Container from "@/Components/Container.vue";
import Card from "@/Components/Card.vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Pagination from "@/Components/Pagination.vue";
import { Head, router } from "@inertiajs/vue3";
import { ref } from "vue";

import ModalView from "./Partials/ModalView.vue";
import Table from "./Partials/Table.vue";

defineProps({
    forms: Object,
});

const item = ref({});
const modal = ref(false);

const open = (i) => {
    fetch(route("admin.end-validation.show", i.id))
        .then((res) => res.json())
        .then((data) => {
            console.log(data);
            item.value = data.data;
            modal.value = true;
        });
};

const close = () => {
    modal.value = false;
    item.value = {};
};
</script>

<template>
    <Head title="Penentuan Kelulusan" />
    <AuthenticatedLayout>
        <div>
            <Container>
                <Card
                    title="Penentuan Kelulusan"
                    description=" Penentuan Kelulusan"
                >
                    <div class="flex flex-col gap-4">
                        <Table :forms="forms" :open="open" />
                        <div class="flex items-center justify-center">
                            <Pagination :pages="forms.links" type="visit" />
                        </div>
                    </div>
                </Card>
            </Container>
            <Modal :show="modal" @close="close">
                <ModalView :item="item" :close="close" />
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>
