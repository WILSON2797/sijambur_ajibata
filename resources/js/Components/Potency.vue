<script setup>
defineProps({
    potencies: Array
});
</script>

<template>
    <section id="potensi">
        <div class="potensi-head">
            <div>
                <p class="section-tag reveal">Yang Kami Miliki</p>
                <h2 class="section-title reveal reveal-delay-1">Potensi <em>Unggulan Desa</em></h2>
            </div>
            <a href="#" class="view-all-link reveal">Lihat Semua ↗</a>
        </div>
        <div class="potensi-grid reveal reveal-delay-1">
            <div v-for="pot in potencies" :key="pot.id" 
                 class="pot-card" 
                 :class="{ 'featured': pot.is_featured }">
                <div class="pot-card-img-wrap"><img :src="pot.image" :alt="pot.title"></div>
                <div class="pot-card-body">
                    <p class="pot-tag">{{ pot.tag }}</p>
                    <h3 class="pot-card-title">{{ pot.title }}</h3>
                    <p class="pot-card-desc">{{ pot.description }}</p>
                    <a v-if="pot.is_featured" href="#" class="read-link">Selengkapnya →</a>
                </div>
            </div>
        </div>
    </section>
</template>
