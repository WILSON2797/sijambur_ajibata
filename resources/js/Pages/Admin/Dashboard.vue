<script setup>
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
</script>

<template>
    <Head title="Admin Dashboard" />

    <AdminLayout>
        <template #header>Dashboard</template>
        
        <div class="welcome-card">
            <h2>Selamat Datang di Panel Admin!</h2>
            <p>Dari sini Anda dapat mengelola seluruh konten website Desa Pardomuan Ajibata.</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Berita</h3>
                <p class="stat-num">12</p>
            </div>
            <div class="stat-card">
                <h3>Potensi Desa</h3>
                <p class="stat-num">5</p>
            </div>
            <div class="stat-card">
                <h3>UMKM Terdaftar</h3>
                <p class="stat-num">8</p>
            </div>
            <div class="stat-card">
                <h3>Destinasi Wisata</h3>
                <p class="stat-num">4</p>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
.welcome-card {
    background: white;
    padding: 2rem;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    margin-bottom: 2rem;
    border-left: 6px solid #A3B899;
}

.welcome-card h2 {
    font-family: 'Lora', serif;
    font-size: 1.5rem;
    color: #1A3D2B;
    margin-bottom: 0.5rem;
}

.welcome-card p {
    color: #64748b;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.stat-card {
    background: white;
    padding: 1.5rem;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
}

.stat-card h3 {
    font-size: 0.9rem;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.5rem;
}

.stat-num {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1A3D2B;
    line-height: 1;
}
</style>
