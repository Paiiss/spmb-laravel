<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

// const user = usePage().props.auth.user;

/* const form = useForm({
    father_name: "",
    father_birth_date: "",
    father_place: "",
    father_last_education: "",
    father_job: "",
    father_phone: "",
    father_email: "",
    mother_name: "",
    mother_birth_date: "",
    mother_place: "",
    mother_last_education: "",
    mother_job: "",
    mother_email: "",
    mother_phone: "",
    guardian_name: "",
    guardian_birth_date: "",
    guardian_place: "",
    guardian_last_education: "",
    guardian_job: "",
    guardian_email: "",
    guardian_phone: "",
}); */

const form = useForm({
    familyMembers: [
        {
            role: "father",
            name: "",
            birth_date: "",
            place: "",
            last_education: "",
            job: "",
            phone: "",
            email: "",
        },
        {
            role: "mother",
            name: "",
            birth_date: "",
            place: "",
            last_education: "",
            job: "",
            phone: "",
            email: "",
        },
        {
            role: "guardian",
            name: "",
            birth_date: "",
            place: "",
            last_education: "",
            job: "",
            phone: "",
            email: "",
        },
    ],
});

const memberFields = [
    "name",
    "birth_date",
    "place",
    "last_education",
    "job",
    "phone",
    "email",
];

const updateFormValue = (role, field, value) => {
    const memberIndex = form.familyMembers.findIndex(
        (member) => member.role === role
    );
    form.familyMembers[memberIndex][field] = value;
};

const getFieldId = (role, field) => {
    return `${role}_${field}`;
};

const capitalize = (string) => {
    return string.charAt(0).toUpperCase() + string.slice(1);
};

/* const type = new Map({
    father: "Father",
    mother: "Mother",
    guardian: "Guardian",   
}); */
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Parent
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Update your parent information.
            </p>
        </header>

        <form @submit.prevent="form.patch(route(''))" class="mt-6 space-y-6">
            <div v-for="member in form.familyMembers" :key="member.role">
                <h3 class="text-black dark:text-white font-bold text-1xl">
                    {{
                        member.role.charAt(0).toUpperCase() +
                        member.role.slice(1)
                    }}
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div
                        class="col-span-2"
                        v-for="field in memberFields"
                        :key="field"
                    >
                        <InputLabel
                            for="is_color_blind"
                            :value="capitalize(field.replace('_', ' '))"
                        />

                        <TextInput
                            :id="getFieldId(member.role, field)"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="member[field]"
                            required
                        />

                        <InputError
                            class="mt-2"
                            :message="form.errors[field]"
                        />
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600 dark:text-gray-400"
                    >
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
