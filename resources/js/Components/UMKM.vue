<script setup>
defineProps({
    items: Array
});
</script>

<template>
    <section id="umkm" class="section-padding-default bg-off-white">
        <p class="section-tag reveal">Ekonomi Kreatif</p>
        <h2 class="section-title reveal reveal-delay-1">UMKM <em>Desa Kami</em></h2>
        <div class="umkm-grid">
            <div v-for="(item, index) in items" :key="index" class="pot-card reveal" :class="'reveal-delay-' + (index % 3)">
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
