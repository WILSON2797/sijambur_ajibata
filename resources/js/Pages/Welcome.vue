<script setup>
import { onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Hero from '@/Components/Hero.vue';
import Marquee from '@/Components/Marquee.vue';
import Stats from '@/Components/Stats.vue';
import About from '@/Components/About.vue';
import ParallaxQuote from '@/Components/ParallaxQuote.vue';
import Potency from '@/Components/Potency.vue';
import UMKM from '@/Components/UMKM.vue';
import Wisata from '@/Components/Wisata.vue';
import Gallery from '@/Components/Gallery.vue';
import News from '@/Components/News.vue';
import Agenda from '@/Components/Agenda.vue';
import Contact from '@/Components/Contact.vue';
import Map from '@/Components/Map.vue';


const props = defineProps({
    hero: Object,
    about: Object,
    quote: Object,
    potencies: Array,
    news: Array,
    umkm: Array,
    wisata: Array,
    agendas: Array,
    settings: Object,
    marqueeItems: Array
});

onMounted(() => {
    // SMOOTH ANCHOR
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const href = a.getAttribute('href');
            if (href === '#' || !href.startsWith('#')) return;
            const t = document.querySelector(href);
            if (t) { 
                e.preventDefault(); 
                t.scrollIntoView({ behavior: 'smooth' }); 
                // Update URL without jump
                history.pushState(null, null, href);
            }
        });
    });
});

const statsData = [
    { label: 'Total Penduduk', value: props.settings.stat_population },
    { label: 'Kepala Keluarga', value: props.settings.stat_families },
    { label: 'Dusun', value: '4' },
    { label: 'Ketinggian dpl', value: props.settings.stat_altitude },
    { label: 'Ha Luas Wilayah', value: props.settings.stat_area },
];

const aboutImages = [
    'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?w=900&q=85',
    'https://images.unsplash.com/photo-1602867741746-6df80f40b3f6?w=500&q=80',
    'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500&q=80'
];

const aboutPills = ['🌿 Alam Hijau', '🐟 Danau Toba', '🎭 Budaya Batak', '🌾 Pertanian', '🧵 Tenun Ulos', '🏘️ Adat Istiadat'];
</script>

<template>
    <AppLayout>
        <Head title="Desa Pardomuan Ajibata — Kabupaten Toba" />
        
        <Hero :content="hero" :stats="{ 'Penduduk': settings.stat_population, 'Ha Luas': settings.stat_area, 'dpl': settings.stat_altitude }" />
        
        <Marquee :items="marqueeItems" />
        
        <Stats :stats="statsData" />
        
        <About :content="about" :pills="aboutPills" :images="aboutImages" />
        
        <ParallaxQuote :content="quote" />
        
        <Potency :potencies="potencies" />
        
        <UMKM :items="umkm" />
        
        <Wisata :destinations="wisata" />
        
        <Gallery />
        
        <News :news="news" />
        
        <Agenda :agendas="agendas" />
        
        <Contact :settings="settings" />
        
        <Map />
    </AppLayout>
</template>
