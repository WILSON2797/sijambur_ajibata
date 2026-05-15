<script setup>
defineProps({
    destinations: Array
});
</script>

<template>
    <section id="wisata" class="section-padding-default bg-white">
        <div style="text-align: center; margin-bottom: 4rem;">
            <p class="section-tag" data-aos="fade-up">Destinasi Pilihan</p>
            <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">Jelajahi <em>Keindahan</em> Desa</h2>
            <p class="section-body" data-aos="fade-up" data-aos-delay="200" style="margin: 0 auto;">Temukan pesona alam tersembunyi dan pengalaman tak terlupakan di Desa Pardomuan Ajibata.</p>
        </div>

        <div class="wisata-container">
            <div v-for="(dest, index) in destinations" :key="index" class="wisata-item" data-aos="fade-up" :data-aos-delay="index % 2 * 100">
                <div class="wisata-img-side">
                    <img loading="lazy" :src="dest.image" :alt="dest.name">
                    <div class="wisata-badge">Must Visit</div>
                </div>
                <div class="wisata-info-side">
                    <p class="wisata-cat">Natural Landmark</p>
                    <h3 class="wisata-name">{{ dest.name }}</h3>
                    <p class="wisata-text">{{ dest.description }}</p>
                    <a href="#" class="wisata-link">
                        <span>Jelajahi Sekarang</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
</template>
