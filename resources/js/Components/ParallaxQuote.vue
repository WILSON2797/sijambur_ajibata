<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    content: Object
});

const p1Bg = ref(null);

onMounted(() => {
    window.addEventListener('scroll', () => {
        if (!p1Bg.value) return;
        const rect = p1Bg.value.parentElement.getBoundingClientRect();
        const off = (rect.top + rect.height / 2 - window.innerHeight / 2) * 0.28;
        p1Bg.value.style.transform = `translateY(${off}px)`;
    }, { passive: true });
});
</script>

<template>
    <div class="parallax-1">
        <div class="p1-bg" ref="p1Bg"></div>
        <div class="p1-content">
            <span class="p1-leaf">🌿</span>
            <blockquote>"{{ content?.content }}"</blockquote>
            <cite>— {{ content?.title }}</cite>
        </div>
    </div>
</template>
