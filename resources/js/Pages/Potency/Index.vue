<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Potency from '@/Components/Potency.vue';

defineProps({
    potencies: Array
});
</script>

<template>
    <AppLayout>
        <Head title="Potensi Desa — Pardomuan Ajibata" />
        
        <div class="page-header-hero">
            <h1 class="section-title">Potensi <em>Unggulan</em> Desa</h1>
            <p class="section-body">Menjelajahi berbagai kekayaan alam, budaya, dan sumber daya yang menjadi kebanggaan Desa Pardomuan Ajibata.</p>
        </div>

        <section class="section-padding-default bg-white">
            <Potency :potencies="potencies" :show-view-all="false" />
        </section>
    </AppLayout>
</template>
