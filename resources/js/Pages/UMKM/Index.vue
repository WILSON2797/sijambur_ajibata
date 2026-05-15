<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import UMKM from '@/Components/UMKM.vue';

defineProps({
    items: Array
});
</script>

<template>
    <AppLayout>
        <Head title="UMKM Desa — Pardomuan Ajibata" />
        
        <div class="page-header" style="background: var(--green-deep); padding: 8rem 4rem 4rem; text-align: center; color: white;">
            <h1 class="section-title" style="color: white; margin-bottom: 1rem;">Potensi <em>UMKM</em> Desa</h1>
            <p style="max-width: 600px; margin: 0 auto; opacity: 0.8;">Mendukung ekonomi kreatif lokal melalui produk-produk unggulan karya warga Desa Pardomuan Ajibata.</p>
        </div>

        <section class="section-padding-default bg-white">
            <UMKM :items="items" />
        </section>
    </AppLayout>
</template>
