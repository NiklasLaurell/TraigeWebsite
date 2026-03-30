<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = ref({
    email: '',
    password: '',
    remember: false,
});

const status = ref('');
const error = ref('');

const submit = async () => {
    status.value = '';
    error.value = '';

    try {
        await window.axios.post('/login', {
            email: form.value.email,
            password: form.value.password,
            remember: form.value.remember,
        });

        window.location.href = '/dashboard';
    } catch {
        error.value = 'Login failed. Please check your credentials.';
    }
};
</script>

<template>
    <main class="min-h-screen bg-slate-950 px-6 py-12 text-slate-100">
        <div class="mx-auto w-full max-w-md rounded-2xl border border-slate-800 bg-slate-900 p-8 shadow-2xl">
            <h1 class="text-2xl font-semibold">Log in</h1>
            <p class="mt-2 text-sm text-slate-300">Welcome back.</p>

            <p v-if="status" class="mt-4 rounded-lg border border-emerald-500/40 bg-emerald-500/10 p-3 text-sm text-emerald-200">
                {{ status }}
            </p>
            <p v-if="error" class="mt-4 rounded-lg border border-rose-500/40 bg-rose-500/10 p-3 text-sm text-rose-200">
                {{ error }}
            </p>

            <form class="mt-6 space-y-4" @submit.prevent="submit">

                <label class="block">
                    <span class="mb-1 block text-sm text-slate-300">Email</span>
                    <input
                        type="email"
                        v-model="form.email"
                        required
                        autofocus
                        class="w-full rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 outline-none ring-sky-300 transition focus:ring"
                    >
                </label>

                <label class="block">
                    <span class="mb-1 block text-sm text-slate-300">Password</span>
                    <input
                        type="password"
                        v-model="form.password"
                        required
                        class="w-full rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 outline-none ring-sky-300 transition focus:ring"
                    >
                </label>

                <label class="flex items-center gap-2 text-sm text-slate-300">
                    <input v-model="form.remember" type="checkbox" class="rounded border-slate-600 bg-slate-800">
                    Remember me
                </label>

                <button
                    type="submit"
                    class="w-full rounded-lg bg-sky-400 px-4 py-2 font-semibold text-slate-900 transition hover:bg-sky-300"
                >
                    Log in
                </button>
            </form>

            <p class="mt-6 text-sm text-slate-300">
                No account?
                <Link href="/register" class="font-semibold text-sky-300 hover:text-sky-200">Register</Link>
            </p>
        </div>
    </main>
</template>


