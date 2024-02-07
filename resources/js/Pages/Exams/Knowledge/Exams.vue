<script setup>
import { Head, Link, usePage, useForm } from "@inertiajs/vue3";
import ExamLayout from "@/Layouts/ExamLayout.vue";
import { ref, onMounted, onBeforeUnmount } from "vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

defineProps({
    exam: {
        type: Object,
        required: true,
    },
    history: {
        type: Object,
        required: true,
    },
});

const options = {
    option_a: "A",
    option_b: "B",
    option_c: "C",
    option_d: "D",
    option_e: "E",
};

const countdown = ref("00:00:00");
const countdownInterval = ref(null);
const question = ref([]);
const answer = ref({});
const posistion = ref(0);
const timeoutSaveId = ref(null);
const modalSubmit = ref(false);

const form = useForm({
    answers: {},
    finish: false,
});

const changeQuestion = (index) => {
    posistion.value = index;
};

const changeAnswer = (index, value) => {
    answer.value[index] = value;
    clearTimeout(timeoutSaveId.value);
    timeoutSaveId.value = setTimeout(() => {
        form.answers = answer.value;
        form.patch(route("exams.knowledge.store", usePage().props.exam.id));
    }, 2000);
};

const submit = () => {
    form.finish = true;
    form.answers = answer.value;
    form.patch(route("exams.knowledge.store", usePage().props.exam.id));
};

onMounted(() => {
    const examOrder = JSON.parse(usePage().props.history.order_questions);
    const quest = JSON.parse(JSON.stringify(usePage().props.exam.questions));

    question.value =
        examOrder.map((id) => quest.find((q) => q.id == id)) || quest;
    // const answer = usePage().props.history.answers;

    // if (answer)
    if (usePage().props.history.answers)
        answer.value = JSON.parse(usePage().props.history.answers);

    // countdown
    const finishAt = new Date(usePage().props.history?.finished_at).getTime();

    countdownInterval.value = setInterval(() => {
        const now = new Date().getTime();
        const distance = finishAt - now;

        const hours = Math.floor(
            (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
        );
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        if (distance < 0) {
            clearInterval(countdownInterval.value);
            countdown.value = "00:00:00";
            submit();
            return;
        }

        countdown.value = `${hours}:${minutes}:${seconds}`;
    }, 1000);
});

const backQuestion = () => {
    if (posistion.value > 0) posistion.value--;
};

const nextQuestion = () => {
    if (posistion.value < question.value.length - 1) posistion.value++;
};

onBeforeUnmount(() => {
    clearInterval(countdownInterval.value);
});
</script>

<template>
    <Head :title="exam.name" />
    <ExamLayout>
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="col-span-1 md:col-span-3">
                    <div class="bg-white shadow-md rounded-md p-4 h-full">
                        <div class="flex flex-row justify-between items-center">
                            <h1 class="text-2xl font-bold text-gray-800">
                                {{ exam.name }}
                            </h1>
                        </div>
                        <div class="mt-4">
                            <div
                                v-html="question[posistion]?.question"
                                style="user-select: none"
                            />
                        </div>
                        <div class="mt-4">
                            <div class="grid grid-cols-1 gap-4">
                                <button
                                    v-for="(value, index) in Object.keys(
                                        options
                                    )"
                                    :key="index"
                                    class="p-2 border border-gray-200 rounded-md text-left"
                                    :class="{
                                        'bg-gray-200 border border-gray-400':
                                            answer[question[posistion]?.id] ==
                                            options[value],
                                    }"
                                    @click="
                                        changeAnswer(
                                            question[posistion].id,
                                            options[value]
                                        )
                                    "
                                >
                                    {{ options[value] }}.
                                    {{ question[posistion]?.[value] }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-1 order-last md:order-none">
                    <div class="flex flex-col gap-4">
                        <div class="bg-white shadow-md rounded-md p-4">
                            <div
                                class="flex flex-row justify-between items-center"
                            >
                                <h1 class="text-2xl font-bold text-gray-800">
                                    {{ exam.name }}
                                </h1>
                            </div>
                            <div class="mt-4">
                                <div class="grid grid-cols-5 gap-4">
                                    <button
                                        v-for="(value, index) in question"
                                        :key="index"
                                        class="p-2 border border-gray-200 rounded-md text-center"
                                        :class="{
                                            'bg-blue-500 hover:bg-blue-600 text-white':
                                                answer[value.id] != undefined &&
                                                index != posistion,
                                            'bg-gray-300 hover:bg-gray-400':
                                                index == posistion &&
                                                answer[value.id] == undefined,
                                            'bg-blue-700 hover:bg-blue-800 text-white ':
                                                index == posistion,
                                        }"
                                        @click="changeQuestion(index)"
                                    >
                                        {{ index + 1 }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white shadow-md rounded-md p-4">
                            <div
                                class="flex flex-row justify-between items-center"
                            >
                                <h1 class="text-2xl font-bold text-gray-800">
                                    Sisa waktu
                                </h1>
                            </div>
                            <div
                                class="mt-4 text-center text-2xl font-bold text-gray-800"
                            >
                                {{ countdown }}
                            </div>

                            <div class="mt-4">
                                <div class="grid grid-cols-1 gap-4">
                                    <button
                                        class="text-white px-4 py-2 rounded-md"
                                        :class="{
                                            'bg-red-500 hover:bg-red-600':
                                                Object.keys(answer).length >=
                                                question.length,
                                            'bg-gray-400 cursor-not-allowed':
                                                Object.keys(answer).length <
                                                question.length,
                                        }"
                                        @click="modalSubmit = true"
                                    >
                                        Selesai
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-1 md:col-span-3">
                    <div class="flex flex-row items-center justify-between">
                        <button
                            class="text-white px-4 py-2 rounded-md"
                            :class="{
                                'bg-blue-500 hover:bg-blue-600': posistion > 0,
                                'bg-gray-400': posistion <= 0,
                            }"
                            @click="backQuestion"
                            :disabled="posistion <= 0"
                        >
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </button>
                        <button
                            class="text-white px-4 py-2 rounded-md"
                            :class="{
                                'bg-gray-400 cursor-not-allowed':
                                    posistion >= question.length - 1,
                                'bg-blue-500 hover:bg-blue-600':
                                    posistion < question.length - 1,
                            }"
                            @click="nextQuestion"
                            :disabled="posistion >= question.length - 1"
                        >
                            Lanjut
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
            <Modal :show="modalSubmit" @close="modalSubmit = false">
                <div class="bg-white shadow-md rounded-md p-4">
                    <div class="flex flex-row justify-between items-center">
                        <h1 class="text-2xl font-bold text-gray-800">
                            Submit jawaban
                        </h1>
                    </div>
                    <div class="mt-4">
                        <p>
                            Apakah anda yakin ingin mengumpulkan jawaban anda?,
                            jawaban yang sudah dikumpulkan tidak dapat diubah
                            kembali.
                        </p>
                    </div>

                    <div class="mt-4">
                        <div class="flex justify-end gap-2">
                            <PrimaryButton @click="submit">
                                Submit
                            </PrimaryButton>
                            <SecondaryButton @click="modalSubmit = false">
                                Batal
                            </SecondaryButton>
                        </div>
                    </div>
                </div>
            </Modal>
        </div>
    </ExamLayout>
</template>
