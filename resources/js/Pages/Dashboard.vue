<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import TopPanelHeader from '../Components/TopPanelHeader.vue';

const page = usePage();

const logout = async () => {
    await window.axios.post('/logout');
    window.location.href = '/';
};

const userName = page.props.auth?.user?.name ?? 'User';
</script>

<template>
    <main class="app-shell">
        <TopPanelHeader title="Dashboard" :subtitle="`Welcome, ${userName}`" :show-logout="true" @logout="logout" />

        <div class="app-container py-12">
            <div class="app-card">
                <h2 class="text-2xl font-semibold">Visit Management</h2>
                <p class="mt-2 app-muted">Choose where you want to go next.</p>

                <div class="mt-8 flex flex-wrap gap-4">
                    <Link
                        href="/visits/create"
                        class="btn-success px-5 py-3"
                    >
                        Register patient
                    </Link>

                    <Link
                        href="/visits"
                        class="btn-primary px-5 py-3"
                    >
                        All visits
                    </Link>
                </div>
            </div>
        </div>
    </main>
</template>
