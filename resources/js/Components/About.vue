<script setup>
defineProps({
    content: Object,
    pills: Array,
    images: Array
});
</script>

<template>
    <section id="tentang">
        <div class="about-text">
            <p class="section-tag reveal">{{ content?.subtitle }}</p>
            <h2 class="section-title reveal reveal-delay-1" v-html="content?.title.replace('Danau Toba', '<em>Danau Toba</em>')"></h2>
            <div class="section-body reveal reveal-delay-2">{{ content?.content }}</div>
            <div class="about-pills reveal reveal-delay-4">
                <span class="pill" v-for="pill in pills" :key="pill">{{ pill }}</span>
            </div>
        </div>
        <div class="about-images reveal reveal-delay-2">
            <img loading="lazy" class="about-img-a" :src="images[0]" alt="Danau Toba">
            <div class="about-img-wrap">
                <img loading="lazy" class="about-img-b" :src="images[1]" alt="Desa">
                <span class="about-img-label">📍 Tepi Danau Toba</span>
            </div>
            <img loading="lazy" class="about-img-c" :src="images[2]" alt="Pertanian">
        </div>
    </section>
</template>
