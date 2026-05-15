<script setup>
defineProps({
    services: Array
});

// Helper to render simple SVG icons based on string
const getIcon = (name) => {
    // This is a simplified version. In a real app, you'd use a proper icon library.
    return '';
};
</script>

<template>
    <section id="layanan">
        <div style="display:flex;justify-content:space-between;align-items:flex-end;">
            <div>
                <p class="section-tag reveal">Pelayanan Publik</p>
                <h2 class="section-title reveal reveal-delay-1">Layanan <em>Administrasi</em></h2>
            </div>
            <p style="font-size:0.85rem;color:var(--text-light);text-align:right;" class="reveal">Senin–Jumat: 08.00–15.30<br>Sabtu: 08.00–12.00 WIB</p>
        </div>
        <div class="layanan-grid">
            <div v-for="(item, index) in services" :key="item.id" 
                 class="layanan-item reveal" 
                 :class="'reveal-delay-' + (index % 3)">
                <div class="layanan-icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path v-if="item.icon === 'document'" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 7.414V19a2 2 0 01-2 2z"/>
                        <path v-else-if="item.icon === 'users'" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path v-else d="M13 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V9z"/>
                    </svg>
                </div>
                <h3 class="layanan-name">{{ item.name }}</h3>
                <p class="layanan-desc">{{ item.description }}</p>
                <a :href="item.link || '#'" class="layanan-link">Ajukan →</a>
            </div>
        </div>
    </section>
</template>
