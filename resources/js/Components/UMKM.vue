<script setup>
defineProps({
    items: Array
});
</script>

<template>
    <section id="umkm" class="section-padding-default bg-off-white">
        <p class="section-tag" data-aos="fade-up">Ekonomi Kreatif</p>
        <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">UMKM <em>Desa Kami</em></h2>
        <div class="umkm-grid">
            <div v-for="(item, index) in items" :key="index" class="pot-card" data-aos="fade-up" :data-aos-delay="(index % 3) * 100">
                <div class="pot-card-img-wrap"><img loading="lazy" :src="item.image" :alt="item.name"></div>
                <div class="pot-card-body">
                    <p class="pot-tag">Produk Unggulan</p>
                    <h3 class="pot-card-title">{{ item.name }}</h3>
                    <p class="pot-card-desc">{{ item.description }}</p>
                </div>
            </div>
        </div>
    </section>
</template>
