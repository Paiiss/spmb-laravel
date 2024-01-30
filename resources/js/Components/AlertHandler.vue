<template>
    <Teleport to="body">
        <div
            v-if="alerts.length"
            class="fixed top-0 right-0 z-50 p-3 flex flex-col gap-3"
        >
            <Transition
                enter-active-class="transition ease-in-out"
                enter-from-class="opacity-0"
                leave-active-class="transition ease-in-out"
                leave-to-class="opacity-0"
                v-for="alert in alerts"
                :key="alert.id"
            >
                <div
                    class="max-w-xs text-sm rounded-lg"
                    :class="{
                        'bg-teal-100 border border-teal-200 text-teal-800 dark:bg-teal-800/10 dark:border-teal-900 dark:text-teal-500':
                            alert.type === 'success',
                        'bg-yellow-100 border border-yellow-200 text-yellow-800 dark:bg-yellow-800/10 dark:border-yellow-900 dark:text-yellow-500':
                            alert.type === 'warning',
                        'bg-red-100 border-red-200 text-red-800 dark:bg-red-800/10 dark:border-red-900 dark:text-red-500':
                            alert.type === 'danger',
                    }"
                    role="alert"
                >
                    <div class="flex p-4">
                        {{ alert.message }}

                        <div class="ms-auto">
                            <button
                                type="button"
                                @click="removeAlert(alert.id)"
                                class="inline-flex flex-shrink-0 justify-center items-center h-5 w-5 rounded-lg text-yellow-800 opacity-50 hover:opacity-100 focus:outline-none focus:opacity-100 dark:text-yellow-200"
                            >
                                <span class="sr-only">Close</span>
                                <i
                                    class="fas fa-times flex-shrink-0 w-4 h-4"
                                ></i>
                            </button>
                        </div>
                    </div>
                </div>
            </Transition>
        </div>
    </Teleport>
</template>

<script setup>
import { computed, watch, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import useAlerts from "@/Composables/useAlerts.js";

const { addAlert, alerts, removeAlert } = useAlerts();
const alert = computed(() => usePage().props.flash.alert);

onMounted(() => {
    if (alert.value) {
        addAlert(alert.value);
    }
});
watch(alert, (newVal) => {
    if (newVal) {
        addAlert(newVal);
    }
});
</script>
