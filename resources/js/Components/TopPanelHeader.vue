<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    title: {
        type: String,
        required: true,
    },
    subtitle: {
        type: String,
        default: '',
    },
    showLogout: {
        type: Boolean,
        default: false,
    },
});

defineEmits(['logout']);
</script>

<template>
    <header class="border-b px-6 py-4 backdrop-blur" style="border-color: var(--app-border); background: color-mix(in srgb, var(--app-bg-soft) 75%, transparent 25%);">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <Link href="/dashboard" class="inline-flex items-center gap-2 rounded-lg px-2 py-1 transition hover:bg-slate-800/70" style="color: var(--app-text);">
                    <span class="flex h-9 w-9 items-center justify-center rounded-md font-bold" style="background: var(--app-primary); color: #082f49;">
                        T
                    </span>
                    <span class="text-sm font-semibold tracking-wide">Triage</span>
                </Link>

                <div>
                    <p class="text-xs uppercase tracking-[0.2em] app-muted">{{ title }}</p>
                    <h1 class="mt-1 text-xl font-semibold">{{ subtitle }}</h1>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button
                    v-if="showLogout"
                    type="button"
                    class="btn-primary"
                    @click="$emit('logout')"
                >
                    Log out
                </button>
            </div>
        </div>
    </header>
</template>
