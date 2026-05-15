<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Gallery from '@/Components/Gallery.vue';

defineProps({
    items: Array
});
</script>

<template>
    <AppLayout>
        <Head title="Gallery — Pardomuan Ajibata" />
        
        <div class="page-header-hero">
            <h1 class="section-title">Galeri <em>Visual</em> Desa</h1>
            <p class="section-body" style="margin: 0 auto; text-align: center;">Kumpulan potret keindahan, kegiatan, dan kehidupan sehari-hari warga desa kami.</p>
        </div>

        <section class="section-padding-default bg-white">
            <Gallery :items="items" />
        </section>
    </AppLayout>
</template>
