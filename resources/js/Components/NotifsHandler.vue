<template>
    <div
        v-if="notification.length"
        class="max-h-96 overflow-y-auto shadow-md sm:rounded-lg"
    >
        <div class="w-full text-sm" v-for="x in notification" :key="x.id">
            <div
                class="flex p-4 border-b"
                :class="{
                    'bg-white': x.read_at,
                    'bg-gray-100': !x.read_at,
                }"
            >
                <div>
                    <div class="font-semibold">{{ x.data.subject }}</div>
                    <div class="text-sm text-gray-500 lowercase">
                        {{ x.data.message }}
                    </div>
                    <div class="text-xs text-gray-400">
                        {{ x.created_at.split("T")[0] }}
                    </div>
                </div>

                <div class="ms-auto flex items-center">
                    <button
                        type="button"
                        @click="readNotif(x.id)"
                        class="inline-flex flex-shrink-0 justify-center items-center h-5 w-5 rounded-lg text-yellow-800 opacity-50 hover:opacity-100 focus:outline-none focus:opacity-100 dark:text-yellow-200"
                    >
                        <span class="sr-only" v-if="!x.read_at">Check</span>
                        <i
                            class="fas fa-check flex-shrink-0 w-4 h-4"
                            v-if="!x.read_at"
                        ></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div v-else>
        <div class="w-full text-sm rounded-lg">
            <div class="flex p-4">Tidak ada notifikasi</div>
        </div>
    </div>
</template>

<script setup>
import { computed, watch, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import useNotifs from "@/Composables/useNotifs.js";

const { addNotif, notification, removeNotif, readNotif } = useNotifs();
const notif = computed(() => usePage().props.notifications);
onMounted(() => {
    if (notif.value) {
        for (let i = 0; i < notif.value.length; i++) {
            if (
                notification.value.filter((e) => e.id === notif.value[i].id)
                    .length
            )
                continue;
            addNotif(notif.value[i]);
        }
    }
});
watch(notif, (newVal) => {
    if (newVal) {
        for (let i = 0; i < newVal.length; i++) {
            if (notification.value.filter((e) => e.id === newVal[i].id).length)
                continue;
            addNotif(newVal[i]);
        }
    }
});
</script>
