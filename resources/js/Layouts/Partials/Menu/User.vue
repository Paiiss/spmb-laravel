<script setup>
import { ref } from "vue";
import ResponsiveSideBar from "@/Components/ResponsiveSideBar.vue";
const showingListForm = ref(
    route().current("form.edit") || route().current("documents.index") || false
);

defineProps({
    check: {
        type: Boolean,
        required: true,
        default: true,
    },
});
</script>

<template>
    <div>
        <div class="mb-8">
            <header
                class="px-3 mb-4 text-xs font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400"
            >
                Menu
            </header>
            <ul class="space-y-2 font-medium">
                <li>
                    <ResponsiveSideBar
                        icon="fa-solid fa-house"
                        :href="route('dashboard')"
                        :active="route().current('dashboard')"
                    >
                        Dashboard
                    </ResponsiveSideBar>
                </li>
                <template v-if="check">
                    <li>
                        <ResponsiveSideBar
                            icon="fa-solid fa-file-invoice"
                            :href="route('form.submission')"
                            :active="route().current('form.submission')"
                        >
                            Pendaftaran
                        </ResponsiveSideBar>
                    </li>
                    <li v-if="$page.props.auth.form.is_paid_registration">
                        <button
                            type="button"
                            @click="showingListForm = !showingListForm"
                            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                        >
                            <i class="fa-solid fa-address-card" />
                            <span
                                class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap capitalize"
                                >Data diri</span
                            >
                            <i
                                class="fa-solid"
                                :class="{
                                    'fa-chevron-up': showingListForm,
                                    'fa-chevron-down': !showingListForm,
                                }"
                            />
                        </button>
                        <ul
                            class="py-2 space-y-2"
                            :class="{
                                block: showingListForm,
                                hidden: !showingListForm,
                            }"
                        >
                            <li>
                                <ResponsiveSideBar
                                    :href="
                                        route('form.edit', {
                                            id: 'personal',
                                        })
                                    "
                                    :active="
                                        route().current('form.edit', {
                                            id: 'personal',
                                        })
                                    "
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                    >Personal</ResponsiveSideBar
                                >
                            </li>
                            <li>
                                <ResponsiveSideBar
                                    :href="
                                        route('form.edit', {
                                            id: 'address',
                                        })
                                    "
                                    :active="
                                        route().current('form.edit', {
                                            id: 'address',
                                        })
                                    "
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                    >Alamat</ResponsiveSideBar
                                >
                            </li>
                            <li>
                                <ResponsiveSideBar
                                    :href="
                                        route('form.edit', {
                                            id: 'disability',
                                        })
                                    "
                                    :active="
                                        route().current('form.edit', {
                                            id: 'disability',
                                        })
                                    "
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                    >Disabilitas</ResponsiveSideBar
                                >
                            </li>
                            <li>
                                <ResponsiveSideBar
                                    :href="
                                        route('form.edit', {
                                            id: 'education',
                                        })
                                    "
                                    :active="
                                        route().current('form.edit', {
                                            id: 'education',
                                        })
                                    "
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                    >Pendidikan</ResponsiveSideBar
                                >
                            </li>
                            <li>
                                <ResponsiveSideBar
                                    :href="
                                        route('form.edit', {
                                            id: 'parent',
                                        })
                                    "
                                    :active="
                                        route().current('form.edit', {
                                            id: 'parent',
                                        })
                                    "
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                    >Orang tua / wali</ResponsiveSideBar
                                >
                            </li>
                            <li>
                                <ResponsiveSideBar
                                    :href="route('documents.index')"
                                    :active="route().current('documents.index')"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                    >Dokumen</ResponsiveSideBar
                                >
                            </li>
                        </ul>
                    </li>
                    <li>
                        <ResponsiveSideBar
                            icon="fa-solid fa-money-bill"
                            :href="route('form.payment')"
                            :active="route().current('form.payment')"
                        >
                            Pembayaran
                        </ResponsiveSideBar>
                    </li>
                </template>
            </ul>
        </div>
        <template v-if="$page.props.auth.form.status == 'approved'">
            <div class="mb-8">
                <header
                    class="px-3 mb-4 text-xs font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400"
                >
                    Ujian
                </header>
                <ul
                    class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"
                >
                    <li v-if="$page.props.auth.exams.knowledge">
                        <ResponsiveSideBar
                            :href="route('exams.knowledge')"
                            :active="route().current('exams.knowledge')"
                            icon="fas fa-clipboard"
                        >
                            Ujian pengetahuan
                        </ResponsiveSideBar>
                    </li>
                    <li v-if="$page.props.auth.exams.health">
                        <ResponsiveSideBar
                            :href="route('exams.health')"
                            :active="route().current('exams.health')"
                            icon="fas fa-stethoscope"
                        >
                            Pemeriksaan kesehatan
                        </ResponsiveSideBar>
                    </li>
                    <li v-if="$page.props.auth.exams.interview">
                        <ResponsiveSideBar
                            :href="route('exams.interview')"
                            :active="route().current('exams.interview')"
                            icon="fas fa-microphone"
                        >
                            Wawancara
                        </ResponsiveSideBar>
                    </li>
                </ul>
            </div>
        </template>
    </div>
</template>
