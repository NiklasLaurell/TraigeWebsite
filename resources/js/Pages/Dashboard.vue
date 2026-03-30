<script setup>
const logout = async () => {
    await window.axios.post('/logout');
    window.location.href = '/';
};
</script>

<template>
    <main class="min-h-screen bg-slate-950 px-6 py-16 text-slate-100">
        <div class="mx-auto max-w-4xl rounded-2xl border border-slate-800 bg-slate-900 p-8">
            <h1 class="text-3xl font-semibold">Dashboard</h1>
            <p class="mt-3 text-slate-300">You are logged in.</p>
            <button
                type="button"
                class="mt-6 rounded-lg bg-sky-400 px-4 py-2 font-semibold text-slate-900 transition hover:bg-sky-300"
                @click="logout"
            >
                Log out
            </button>
        </div>
    </main>
</template>
