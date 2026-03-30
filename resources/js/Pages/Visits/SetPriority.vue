<script setup>
import { router } from '@inertiajs/vue3';
import { reactive } from 'vue';
import TopPanelHeader from '../../Components/TopPanelHeader.vue';

const props = defineProps({
    visit: {
        type: Object,
        required: true,
    },
    recommendation: {
        type: Object,
        default: null,
    },
    measurement_decisions: {
        type: Object,
        default: () => ({ vp: null, bg: null }),
    },
});

const form = reactive({
    currentQueuePriority: String(
        props.visit.current_queue_priority ?? props.recommendation?.predicted_priority ?? 3,
    ),
});

const setPriority = (value) => {
    form.currentQueuePriority = String(value).replace(/\D/g, '').slice(0, 1);
};

const generateMeasurementDecision = (decisionType) => {
    router.post(`/visits/${props.visit.id}/measurement-decisions`, {
        decision_type: decisionType,
    });
};

const generateTriagePrediction = (stage = 'initial') => {
    router.post(`/visits/${props.visit.id}/triage-predictions`, {
        stage,
    });
};

const submit = () => {
    const currentQueuePriority = Number.parseInt(form.currentQueuePriority, 10);

    if (!Number.isInteger(currentQueuePriority) || currentQueuePriority < 1 || currentQueuePriority > 5) {
        return;
    }

    router.patch(`/visits/${props.visit.id}/priority`, {
        current_queue_priority: currentQueuePriority,
    });
};
</script>

<template>
    <main class="app-shell">
        <TopPanelHeader title="Visits" subtitle="Set queue priority" />

        <div class="mx-auto mt-12 max-w-4xl app-card">
            <h1 class="text-3xl font-semibold">Set final queue priority</h1>
            <p class="mt-2 app-muted">
                Visit created for <span class="font-semibold" style="color: var(--app-text);">{{ visit.patient_name }}</span>.
                Choose the final queue priority manually.
            </p>

            <div v-if="recommendation" class="mt-6 rounded-xl border p-4" style="border-color: color-mix(in srgb, var(--app-primary) 40%, black 60%); background: color-mix(in srgb, var(--app-primary) 12%, transparent 88%);">
                <p class="text-sm uppercase tracking-wide" style="color: var(--app-primary);">Triage recommendation</p>
                <p class="mt-2 text-lg">
                    Recommended priority:
                    <span class="font-semibold" style="color: var(--app-primary-hover);">{{ recommendation.predicted_priority }}</span>
                </p>
                <p class="mt-1 text-sm app-muted">
                    TC probability: {{ recommendation.tc_probability }}
                </p>
                <p class="text-sm app-muted">Stage: {{ recommendation.stage }}</p>
            </div>

            <div class="mt-6 rounded-xl border p-4" style="border-color: color-mix(in srgb, var(--app-warning) 45%, black 55%); background: color-mix(in srgb, var(--app-warning) 12%, transparent 88%);">
                <p class="text-sm uppercase tracking-wide" style="color: var(--app-warning);">Measurement decisions</p>
                <p class="mt-2" style="color: var(--app-text);">Generate whether VP and BG should be measured.</p>
                <div class="mt-3 grid gap-2 text-sm app-muted">
                    <p>
                        VP: {{ measurement_decisions.vp ? `${measurement_decisions.vp.should_measure ? 'measure' : 'skip'} (${measurement_decisions.vp.measurement_affects_tc_probability})` : 'not generated' }}
                    </p>
                    <p>
                        BG: {{ measurement_decisions.bg ? `${measurement_decisions.bg.should_measure ? 'measure' : 'skip'} (${measurement_decisions.bg.measurement_affects_tc_probability})` : 'not generated' }}
                    </p>
                </div>
                <div class="mt-4 flex flex-wrap gap-3">
                    <button
                        type="button"
                        class="btn-warning"
                        @click="generateMeasurementDecision('vp')"
                    >
                        Generate VP decision
                    </button>

                    <button
                        type="button"
                        class="btn-primary"
                        @click="generateMeasurementDecision('bg')"
                    >
                        Generate BG decision
                    </button>

                    <button
                        type="button"
                        class="btn-success"
                        @click="generateTriagePrediction('initial')"
                    >
                        Generate triage prediction
                    </button>
                </div>
            </div>

            <form class="mt-8 grid gap-6" @submit.prevent="submit">
                <label class="block">
                    <span class="mb-1 block text-sm app-muted">Final queue priority (1-5)</span>
                    <input
                        :value="form.currentQueuePriority"
                        type="text"
                        inputmode="numeric"
                        pattern="[1-5]"
                        required
                        @input="setPriority($event.target.value)"
                        class="app-input"
                        placeholder="Enter queue priority"
                    >
                </label>

                <div class="flex gap-3">
                    <button
                        type="submit"
                        class="btn-success"
                    >
                        Save final priority
                    </button>
                </div>
            </form>
        </div>
    </main>
</template>
