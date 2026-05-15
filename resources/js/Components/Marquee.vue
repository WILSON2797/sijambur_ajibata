<script setup>
defineProps({
    items: Array
});
</script>

<template>
    <div class="marquee-bar">
        <div class="marquee-track">
            <span v-for="n in 2" :key="n">
                <span v-for="item in items" :key="item">{{ item }}</span>
            </span>
        </div>
    </div>
</template>
