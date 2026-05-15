<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import News from '@/Components/News.vue';

defineProps({
    news: Array
});
</script>

<template>
    <AppLayout>
        <Head title="Berita Desa — Pardomuan Ajibata" />
        
        <div class="page-header-hero">
            <h1 class="section-title">Kabar <em>Terbaru</em> Desa</h1>
            <p class="section-body">Ikuti perkembangan terkini, pengumuman, dan berita seputar kegiatan di Desa Pardomuan Ajibata.</p>
        </div>

        <section class="section-padding-default bg-white">
            <News :news="news" />
        </section>
    </AppLayout>
</template>
