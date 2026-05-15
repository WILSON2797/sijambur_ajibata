<script setup>
import { ref, computed } from 'vue';

const activeIndex = ref(2);

const items = [
    { title: 'Bukit Panorama', desc: 'Pemandangan Danau Toba dari puncak bukit', image: 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?w=1200&q=90' },
    { title: 'Tepi Danau', desc: 'Suasana tenang di pinggiran desa Pardomuan', image: 'https://images.unsplash.com/photo-1602867741746-6df80f40b3f6?w=1200&q=90' },
    { title: 'Sawah Hijau', desc: 'Hamparan sawah subur di kaki bukit', image: 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1200&q=90' },
    { title: 'Budaya Lokal', desc: 'Pelestarian adat dan tradisi Batak Toba', image: 'https://images.unsplash.com/photo-1609221382720-8a8f1fbf6de3?w=1200&q=90' },
    { title: 'Senja di Desa', desc: 'Momen matahari terbenam yang memukau', image: 'https://images.unsplash.com/photo-1548514814-ea62ef1c9e94?w=1200&q=90' },
];

const next = () => {
    activeIndex.value = (activeIndex.value + 1) % items.length;
};

const prev = () => {
    activeIndex.value = (activeIndex.value - 1 + items.length) % items.length;
};

const setIndex = (index) => {
    activeIndex.value = index;
};
</script>

<template>
    <section id="gallery" class="gallery-section">
        <div class="gallery-header">
            <p class="section-tag reveal">Koleksi Visual</p>
            <h2 class="section-title reveal reveal-delay-1">Galeri <em>Foto Desa</em></h2>
        </div>

        <div class="carousel-container reveal reveal-delay-2">
            <button class="carousel-nav-btn prev" @click.stop="prev" aria-label="Previous slide">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5"><path d="M15 18l-6-6 6-6"/></svg>
            </button>
            
            <div class="slides-wrapper">
                <div v-for="(item, index) in items" :key="index" 
                     class="slide" 
                     @click="setIndex(index)"
                     :class="{ 
                         'active': index === activeIndex,
                         'prev-slide': index === (activeIndex - 1 + items.length) % items.length,
                         'next-slide': index === (activeIndex + 1) % items.length,
                         'far-prev': index === (activeIndex - 2 + items.length) % items.length,
                         'far-next': index === (activeIndex + 2) % items.length,
                         'hidden': Math.abs(index - activeIndex) > 2 && Math.abs(index - activeIndex) < items.length - 2
                     }">
                    <div class="slide-inner">
                        <img :src="item.image" :alt="item.title">
                        <div class="slide-content" v-if="index === activeIndex">
                            <h3>{{ item.title }}</h3>
                            <p>{{ item.desc }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <button class="carousel-nav-btn next" @click.stop="next" aria-label="Next slide">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5"><path d="M9 18l6-6-6-6"/></svg>
            </button>
        </div>

        <div class="carousel-footer reveal reveal-delay-3">
            <div class="dots">
                <span v-for="(_, index) in items" :key="index" 
                      class="dot" 
                      :class="{ 'active': index === activeIndex }"
                      @click="setIndex(index)"></span>
            </div>
            <p class="hint">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M5 12l4-4M5 12l4 4"/></svg>
                Geser ke kiri atau kanan untuk melihat galeri lainnya
            </p>
        </div>
    </section>
</template>
