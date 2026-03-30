<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    visits: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <main class="app-shell px-6 py-12">
        <div class="mx-auto max-w-5xl app-card">
            <h1 class="text-3xl font-semibold">All patients</h1>

            <div v-if="visits.length === 0" class="mt-6 rounded-xl border p-4 app-muted" style="border-color: var(--app-border); background: color-mix(in srgb, var(--app-bg-soft) 80%, black 20%);">
                No patients registered yet.
            </div>

            <div v-else class="mt-6 overflow-hidden rounded-xl border" style="border-color: var(--app-border);">
                <table class="min-w-full text-sm">
                    <thead class="text-left app-muted" style="background: color-mix(in srgb, var(--app-bg-soft) 85%, black 15%);">
                        <tr>
                            <th class="px-4 py-3 font-medium">Patient</th>
                            <th class="px-4 py-3 font-medium">Age</th>
                            <th class="px-4 py-3 font-medium">Gender</th>
                            <th class="px-4 py-3 font-medium">ESS</th>
                            <th class="px-4 py-3 font-medium">Ambulance</th>
                            <th class="px-4 py-3 font-medium">Queue priority</th>
                            <th class="px-4 py-3 font-medium">Created</th>
                            <th class="px-4 py-3 font-medium">Action</th>
                        </tr>
                    </thead>
                    <tbody style="background: color-mix(in srgb, var(--app-surface) 94%, black 6%);">
                        <tr v-for="visit in visits" :key="visit.id">
                            <td class="px-4 py-3">{{ visit.patient_name }}</td>
                            <td class="px-4 py-3">{{ visit.age }}</td>
                            <td class="px-4 py-3 capitalize">{{ visit.gender }}</td>
                            <td class="px-4 py-3">{{ visit.ess_code }}</td>
                            <td class="px-4 py-3">{{ visit.arrival_with_ambulance ? 'Yes' : 'No' }}</td>
                            <td class="px-4 py-3">{{ visit.current_queue_priority ?? 'Not set' }}</td>
                            <td class="px-4 py-3">{{ visit.created_at }}</td>
                            <td class="px-4 py-3">
                                <Link
                                    :href="`/visits/${visit.id}/priority`"
                                    class="btn-primary rounded-md px-3 py-1.5"
                                >
                                    Open
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <Link
                href="/dashboard"
                class="btn-primary mt-8"
            >
                Back to dashboard
            </Link>
        </div>
    </main>
</template>
