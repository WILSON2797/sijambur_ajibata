<script setup>
defineProps({
    stats: Array
});
</script>

<template>
    <div class="stats-section">
        <div v-for="(stat, index) in stats" :key="index" 
             class="stat-box reveal" 
             :class="'reveal-delay-' + (index % 5)">
            <div class="stat-box-num">{{ stat.value }}</div>
            <div class="stat-box-label">{{ stat.label }}</div>
        </div>
    </div>
</template>
