<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    potencies: Array,
    showViewAll: {
        type: Boolean,
        default: true
    }
});
</script>

<template>
    <section id="potensi">
        <div class="potensi-head">
            <div>
                <p class="section-tag" data-aos="fade-up">Yang Kami Miliki</p>
                <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">Potensi <em>Unggulan Desa</em></h2>
            </div>
            <Link v-if="showViewAll" :href="route('potency')" class="view-all-link" data-aos="fade-up">Lihat Semua ↗</Link>
        </div>
        <div class="potensi-grid" data-aos="fade-up" data-aos-delay="200">
            <div v-for="pot in potencies" :key="pot.id" 
                 class="pot-card" 
                 :class="{ 'featured': pot.is_featured }">
                <div class="pot-card-img-wrap">
                    <img loading="lazy" :src="pot.image" :alt="pot.title">
                </div>
                <div class="pot-card-body">
                    <p class="pot-tag">{{ pot.tag }}</p>
                    <h3 class="pot-card-title">{{ pot.title }}</h3>
                    <p class="pot-card-desc">{{ pot.description }}</p>
                    <Link v-if="pot.slug" :href="route('potency.detail', pot.slug)" class="read-link">Selengkapnya →</Link>
                </div>
            </div>
        </div>
    </section>
</template>
