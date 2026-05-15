<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Wisata from '@/Components/Wisata.vue';

defineProps({
    destinations: Array
});
</script>

<template>
    <AppLayout>
        <Head title="Wisata Desa — Pardomuan Ajibata" />
        
        <div class="page-header-hero">
            <h1 class="section-title">Destinasi <em>Wisata</em> Desa</h1>
            <p class="section-body" style="margin: 0 auto; text-align: center;">Nikmati keindahan alam dan kearifan lokal di tepi Danau Toba yang memesona.</p>
        </div>

        <section class="section-padding-default bg-white">
            <Wisata :destinations="destinations" />
        </section>
    </AppLayout>
</template>
