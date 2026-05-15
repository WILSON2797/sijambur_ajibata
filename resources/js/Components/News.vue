<script setup>
import { computed } from 'vue';

const props = defineProps({
    news: Array
});

const mainNews = computed(() => props.news[0]);
const sideNews = computed(() => props.news.slice(1));

const formatDate = (dateStr) => {
    if (!dateStr) return '';
    const date = new Date(dateStr);
    return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
};
</script>

<template>
    <section id="berita">
        <div class="berita-head">
            <div>
                <p class="section-tag" data-aos="fade-up">Informasi Terkini</p>
                <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">Berita & <em>Pengumuman</em></h2>
            </div>
            <a href="#" class="view-all-link" data-aos="fade-up">Semua Berita ↗</a>
        </div>
        <div class="berita-grid">
            <div class="berita-main" data-aos="fade-up" data-aos-delay="200" v-if="mainNews">
                <div class="berita-main-overflow"><img loading="lazy" :src="mainNews.image" :alt="mainNews.title"></div>
                <div class="berita-body-main">
                    <p class="berita-date">{{ formatDate(mainNews.published_at) }}</p>
                    <h3 class="berita-title">{{ mainNews.title }}</h3>
                    <p class="berita-excerpt">{{ mainNews.excerpt }}</p>
                    <a href="#" class="read-link">Baca Selengkapnya →</a>
                </div>
            </div>
            <div class="berita-side">
                <div v-for="(item, index) in sideNews" :key="item.id" 
                     class="berita-item" 
                     data-aos="fade-left"
                     :data-aos-delay="(index + 1) * 100">
                    <img loading="lazy" :src="item.image" :alt="item.title">
                    <div>
                        <p class="berita-date">{{ formatDate(item.published_at) }}</p>
                        <h3 class="berita-title">{{ item.title }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
