<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import About from '@/Components/About.vue';

defineProps({
    about: Object,
    pills: Array,
    images: Array
});
</script>

<template>
    <AppLayout>
        <Head title="Tentang Desa — Pardomuan Ajibata" />
        
        <div class="page-header-hero">
            <h1 class="section-title"><em>Tentang</em> Desa Kami</h1>
            <p class="section-body">Sejarah, visi, dan filosofi kehidupan di Desa Pardomuan Ajibata.</p>
        </div>

        <section class="section-padding-default bg-white">
            <About :content="about" :pills="pills" :images="images" />
        </section>
    </AppLayout>
</template>
