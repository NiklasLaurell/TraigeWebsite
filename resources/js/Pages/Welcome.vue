<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <main class="min-h-screen bg-[radial-gradient(circle_at_20%_20%,_#1d4ed8_0%,_transparent_40%),radial-gradient(circle_at_80%_0%,_#0ea5e9_0%,_transparent_35%),linear-gradient(135deg,_#020617_0%,_#0f172a_100%)]">
        <div class="mx-auto flex min-h-screen max-w-6xl flex-col justify-center px-6 py-16">
            <section class="rounded-3xl border border-white/20 bg-white/10 p-10 shadow-2xl backdrop-blur md:p-14">
                <p class="text-sm uppercase tracking-[0.25em] text-sky-200">Triage Website</p>
                <h1 class="mt-4 text-4xl font-semibold leading-tight text-white md:text-6xl">
                    Fast triage starts with one account
                </h1>
                <p class="mt-6 max-w-2xl text-lg text-slate-200">
                    Log in to continue your workflow, or create a new account in less than a minute.
                </p>

                <div class="mt-10 flex flex-wrap gap-4">
                    <Link
                        href="/login"
                        class="rounded-xl bg-sky-400 px-6 py-3 font-semibold text-slate-900 transition hover:bg-sky-300"
                    >
                        Log in
                    </Link>
                    <Link
                        href="/register"
                        class="rounded-xl border border-slate-200/60 px-6 py-3 font-semibold text-slate-100 transition hover:bg-white/10"
                    >
                        Register
                    </Link>
                </div>
            </section>
        </div>
    </main>
</template>
