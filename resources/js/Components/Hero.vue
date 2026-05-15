<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps({
    content: Object,
    stats: Object
});

const heroBg = ref(null);

onMounted(() => {
    window.addEventListener('scroll', () => {
        if (heroBg.value) {
            heroBg.value.style.transform = `translateY(${window.scrollY * 0.38}px)`;
        }
    }, { passive: true });
});
</script>

<template>
    <section id="hero">
        <div class="hero-bg" ref="heroBg" :style="{ '--hero-url': `url(${content?.image})` }"></div>
        <div class="hero-content">
            <h1 class="hero-title" data-aos="fade-up" data-aos-duration="1200">
                Desa<br>
                <em>{{ content?.title.split(' ')[1] }}</em><br>
                {{ content?.title.split(' ')[2] }}
            </h1>
            <p class="hero-desc" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1200">{{ content?.content }}</p>
            <div class="hero-actions" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1200">
                <a href="#tentang" class="btn-primary">
                    Kenali Desa Kami
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="#layanan" class="btn-outline">Lihat Layanan</a>
            </div>
        </div>
        <div class="hero-side-info" data-aos="fade-left" data-aos-delay="600">
            <div class="hero-stat" v-for="(val, key) in stats" :key="key">
                <div class="hero-stat-num">{{ val }}</div>
                <div class="hero-stat-label">{{ key }}</div>
            </div>
        </div>
        <div class="hero-scroll-hint" data-aos="fade-up" data-aos-delay="800">
            <span>Scroll</span>
            <div class="scroll-dot"></div>
        </div>
    </section>
</template>
