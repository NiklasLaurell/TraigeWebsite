<script setup>
import { router } from '@inertiajs/vue3';
import { reactive } from 'vue';
import TopPanelHeader from '../../Components/TopPanelHeader.vue';

const form = reactive({
    name: '',
    age: '',
    gender: '',
    arrivalWithAmbulance: false,
    essCode: '',
});

const setIntegerField = (field, value) => {
    form[field] = String(value).replace(/\D/g, '');
};

const submit = () => {
    const age = Number.parseInt(form.age, 10);
    const essCode = Number.parseInt(form.essCode, 10);

    if (!Number.isInteger(age) || !Number.isInteger(essCode)) {
        return;
    }

    router.post('/visits', {
        patient_name: form.name,
        age,
        gender: form.gender,
        arrival_with_ambulance: form.arrivalWithAmbulance,
        ess_code: essCode,
    });
};
</script>

<template>
    <main class="app-shell">
        <TopPanelHeader title="Patients" subtitle="Register patient" />

        <div class="mx-auto mt-12 max-w-5xl app-card">
            <h1 class="text-3xl font-semibold">Register patient</h1>
            <p class="mt-2 app-muted">Fill in the details below to register a patient.</p>

            <form class="mt-8 grid gap-6" @submit.prevent="submit">
                <label class="flex items-center justify-between rounded-xl border px-4 py-3" style="border-color: var(--app-border); background: color-mix(in srgb, var(--app-bg-soft) 85%, black 15%); color: var(--app-text);">
                    <span class="font-medium">Arrival with ambulance</span>
                    <input
                        v-model="form.arrivalWithAmbulance"
                        type="checkbox"
                        class="h-6 w-6 cursor-pointer rounded accent-emerald-400"
                    >
                </label>

                <label class="block">
                    <span class="mb-1 block text-sm app-muted">Patient name</span>
                    <input
                        v-model="form.name"
                        type="text"
                        required
                        class="app-input"
                        placeholder="Enter patient name"
                    >
                </label>

                <label class="block">
                    <span class="mb-1 block text-sm app-muted">Age</span>
                    <input
                        :value="form.age"
                        type="text"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        required
                        @input="setIntegerField('age', $event.target.value)"
                        class="app-input"
                        placeholder="Enter age"
                    >
                </label>

                <label class="block">
                    <span class="mb-1 block text-sm app-muted">Gender</span>
                    <select
                        v-model="form.gender"
                        required
                        class="app-input"
                    >
                        <option disabled value="">Choose gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </label>

                <label class="block">
                    <span class="mb-1 block text-sm app-muted">ESS code</span>
                    <input
                        :value="form.essCode"
                        type="text"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        required
                        @input="setIntegerField('essCode', $event.target.value)"
                        class="app-input"
                        placeholder="Enter ESS code"
                    >
                </label>

                <div class="flex flex-wrap gap-3">
                    <button
                        type="submit"
                        class="btn-success"
                    >
                        Save patient
                    </button>
                </div>
            </form>
        </div>
    </main>
</template>
