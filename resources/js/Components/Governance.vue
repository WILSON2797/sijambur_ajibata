<script setup>
import { computed } from 'vue';

const props = defineProps({
    officials: Array
});

const head = computed(() => props.officials[0]);
const members = computed(() => props.officials.slice(1));
</script>

<template>
    <section id="pemerintahan">
        <p class="section-tag reveal">Struktur Organisasi</p>
        <h2 class="section-title reveal reveal-delay-1">Perangkat <em>Desa</em></h2>
        <div class="pemerintahan-grid">
            <div class="aparatur-card-head reveal" v-if="head">
                <img class="aparatur-photo" :src="head.photo" :alt="head.name">
                <div>
                    <div class="aparatur-jabatan" style="color:var(--green-light);margin-bottom:0.4rem;">{{ head.position }}</div>
                    <div class="aparatur-nama">{{ head.name }}</div>
                    <p>{{ head.description }}</p>
                </div>
            </div>
            <div v-for="(item, index) in members" :key="item.id" 
                 class="aparatur-card reveal" 
                 :class="'reveal-delay-' + (index + 1)">
                <img class="aparatur-photo" :src="item.photo" :alt="item.name">
                <p class="aparatur-nama">{{ item.name }}</p>
                <p class="aparatur-jabatan">{{ item.position }}</p>
            </div>
        </div>
    </section>
</template>
