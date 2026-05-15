<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    potency: Object,
    otherPotencies: Array
});
</script>

<template>
    <AppLayout>
        <Head :title="potency.title + ' — Potensi Desa Pardomuan Ajibata'" />

        <!-- Detail Hero -->
        <section class="potency-detail-hero">
            <div class="potency-detail-bg" :style="{ '--detail-bg': `url(${potency.image})` }"></div>
            <div class="potency-detail-content">
                <nav class="breadcrumb">
                    <Link :href="route('home')">Home</Link>
                    <span>/</span>
                    <Link :href="route('potency')">Potensi</Link>
                    <span>/</span>
                    <span class="active">{{ potency.title }}</span>
                </nav>
                <div class="potency-header">
                    <span class="potency-tag-large">{{ potency.tag || 'Potensi Desa' }}</span>
                    <h1 class="potency-title-large">{{ potency.title }}</h1>
                </div>
            </div>
        </section>

        <!-- Content Section -->
        <section class="potency-content-section section-padding-default">
            <div class="potency-container">
                <div class="potency-main-text">
                    <div class="editorial-body" v-html="(potency.description || '').replace(/\n/g, '<br>')"></div>
                    
                    <div class="potency-meta-info">
                        <div class="meta-item">
                            <span class="meta-label">Kategori</span>
                            <span class="meta-value">{{ potency.tag || 'Umum' }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Lokasi</span>
                            <span class="meta-value">Desa Pardomuan Ajibata</span>
                        </div>
                    </div>

                    <div class="potency-actions">
                        <Link :href="route('potency')" class="btn-outline-dark">
                            ← Kembali ke Daftar Potensi
                        </Link>
                        <a href="https://wa.me/628123456789" target="_blank" class="btn-whatsapp">
                            Tanya Lebih Lanjut
                        </a>
                    </div>
                </div>

                <aside class="potency-sidebar">
                    <div class="sidebar-card">
                        <h3>Potensi Lainnya</h3>
                        <div class="sidebar-list">
                            <template v-for="item in otherPotencies" :key="item.id">
                                <Link v-if="item.slug"
                                      :href="route('potency.detail', item.slug)" 
                                      class="sidebar-item">
                                    <img :src="item.image" :alt="item.title">
                                    <div>
                                        <h4>{{ item.title }}</h4>
                                        <span>{{ item.tag }}</span>
                                    </div>
                                </Link>
                            </template>
                        </div>
                    </div>
                </aside>
            </div>
        </section>
    </AppLayout>
</template>

<style scoped>
.potency-detail-hero {
    height: 70vh;
    min-height: 500px;
    position: relative;
    display: flex;
    align-items: flex-end;
    padding: 5rem;
    overflow: hidden;
}

.potency-detail-bg {
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(26,61,43,0.2), rgba(26,61,43,0.85)), var(--detail-bg) center/cover no-repeat;
    z-index: 1;
}

.potency-detail-content {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    color: white;
}

.breadcrumb {
    display: flex;
    gap: 0.8rem;
    font-size: 0.75rem;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    margin-bottom: 1.5rem;
    opacity: 0.8;
}

.breadcrumb a {
    color: white;
    text-decoration: none;
    transition: color 0.3s;
}

.breadcrumb a:hover {
    color: var(--green-light);
}

.breadcrumb .active {
    color: var(--green-light);
    font-weight: 700;
}

.potency-tag-large {
    display: inline-block;
    padding: 0.4rem 1.2rem;
    background: var(--green-fresh);
    border-radius: 100px;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    margin-bottom: 1rem;
}

.potency-title-large {
    font-family: 'Lora', serif;
    font-size: clamp(2.5rem, 5vw, 4.5rem);
    font-weight: 700;
    line-height: 1.1;
}

.potency-container {
    display: grid;
    grid-template-columns: 1.8fr 1fr;
    gap: 5rem;
    max-width: 1200px;
    margin: 0 auto;
}

.editorial-body {
    font-size: 1.15rem;
    line-height: 1.9;
    color: var(--text-mid);
    margin-bottom: 3rem;
    overflow-wrap: break-word;
}

.potency-meta-info {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    padding: 2rem;
    background: var(--green-mist);
    border-radius: 16px;
    margin-bottom: 3rem;
}

.meta-label {
    display: block;
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: var(--green-fresh);
    margin-bottom: 0.4rem;
}

.meta-value {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-dark);
}

.potency-actions {
    display: flex;
    gap: 1rem;
}

.btn-outline-dark {
    padding: 1rem 2rem;
    border: 1.5px solid var(--text-dark);
    border-radius: 100px;
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--text-dark);
    transition: all 0.3s;
}

.btn-outline-dark:hover {
    background: var(--text-dark);
    color: white;
}

.btn-whatsapp {
    padding: 1rem 2rem;
    background: #25D366;
    color: white;
    border-radius: 100px;
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 600;
    transition: transform 0.3s;
}

.btn-whatsapp:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(37, 211, 102, 0.3);
}

.sidebar-card {
    background: white;
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 2rem;
    position: sticky;
    top: 100px;
}

.sidebar-card h3 {
    font-family: 'Lora', serif;
    font-size: 1.3rem;
    margin-bottom: 1.5rem;
    color: var(--text-dark);
}

.sidebar-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.sidebar-item {
    display: flex;
    gap: 1rem;
    text-decoration: none;
    color: inherit;
    transition: opacity 0.3s;
}

.sidebar-item:hover {
    opacity: 0.8;
}

.sidebar-item img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 10px;
}

.sidebar-item h4 {
    font-size: 0.9rem;
    font-weight: 700;
    margin-bottom: 0.2rem;
}

.sidebar-item span {
    font-size: 0.7rem;
    color: var(--green-fresh);
    font-weight: 600;
}

@media (max-width: 1024px) {
    .potency-container {
        grid-template-columns: 1fr;
        gap: 3rem;
    }
    .potency-detail-hero {
        padding: 3rem 2rem;
        height: 60vh;
    }
}
</style>
