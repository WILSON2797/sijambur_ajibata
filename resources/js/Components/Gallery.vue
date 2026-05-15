<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    items: {
        type: Array,
        default: () => []
    }
});

const activeIndex = ref(0);

const next = () => {
    if (props.items.length === 0) return;
    activeIndex.value = (activeIndex.value + 1) % props.items.length;
};

const prev = () => {
    if (props.items.length === 0) return;
    activeIndex.value = (activeIndex.value - 1 + props.items.length) % props.items.length;
};

const setIndex = (index) => {
    activeIndex.value = index;
};
</script>

<template>
    <section id="gallery" class="gallery-section">
        <div class="gallery-header">
            <p class="section-tag" data-aos="fade-up">Koleksi Visual</p>
            <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">Galeri <em>Foto Desa</em></h2>
        </div>

        <div class="carousel-container" data-aos="fade-up" data-aos-delay="200">
            <button class="carousel-nav-btn prev" @click.stop="prev" aria-label="Previous slide">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5"><path d="M15 18l-6-6 6-6"/></svg>
            </button>
            
            <div class="slides-wrapper" v-if="props.items && props.items.length > 0">
                <div v-for="(item, index) in props.items" :key="index" 
                     class="slide" 
                     @click="setIndex(index)"
                     :class="{ 
                         'active': index === activeIndex,
                         'prev-slide': props.items.length > 1 && index === (activeIndex - 1 + props.items.length) % props.items.length,
                         'next-slide': props.items.length > 1 && index === (activeIndex + 1) % props.items.length,
                         'far-prev': props.items.length > 2 && index === (activeIndex - 2 + props.items.length) % props.items.length,
                         'far-next': props.items.length > 2 && index === (activeIndex + 2) % props.items.length,
                         'hidden': props.items.length > 5 && Math.abs(index - activeIndex) > 2 && Math.abs(index - activeIndex) < props.items.length - 2
                     }">
                    <div class="slide-inner">
                        <img loading="lazy" :src="item.image" :alt="item.title">
                        <div class="slide-content" v-if="index === activeIndex">
                            <h3>{{ item.title }}</h3>
                            <p>{{ item.description }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="empty-gallery">
                <p>Belum ada koleksi foto.</p>
            </div>

            <button class="carousel-nav-btn next" @click.stop="next" aria-label="Next slide">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5"><path d="M9 18l6-6-6-6"/></svg>
            </button>
        </div>

        <div class="carousel-footer" data-aos="fade-up" data-aos-delay="300">
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
