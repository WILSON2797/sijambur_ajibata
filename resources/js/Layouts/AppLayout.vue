<script>
// State outside the component to persist across Inertia navigations but reset on Refresh
let introPlayedGlobal = false;
</script>

<script setup>
import { ref, onMounted, onUnmounted, nextTick, watch } from 'vue';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import Lenis from 'lenis';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import AOS from 'aos';
import 'aos/dist/aos.css';
import IntroLoader from '@/Components/IntroLoader.vue';

gsap.registerPlugin(ScrollTrigger);

const isLoading = ref(!introPlayedGlobal);
const isContentVisible = ref(introPlayedGlobal);
const isFirstLoad = ref(!introPlayedGlobal);
let lenis;

const handleIntroComplete = () => {
    isLoading.value = false;
    introPlayedGlobal = true;
};

onMounted(() => {
    // Initialize Lenis
    lenis = new Lenis({
        duration: 1.2,
        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)), // https://www.desmos.com/calculator/brs54l4xou
        direction: 'vertical',
        gestureDirection: 'vertical',
        smooth: true,
        mouseMultiplier: 1,
        smoothTouch: false,
        touchMultiplier: 2,
        infinite: false,
    });

    // Synchronize Lenis with GSAP ScrollTrigger
    lenis.on('scroll', ScrollTrigger.update);

    gsap.ticker.add((time) => {
        lenis.raf(time * 1000);
    });

    gsap.ticker.lagSmoothing(0);

    // Initialize AOS
    AOS.init({
        duration: 1000,
        easing: 'ease-out-cubic',
        once: false,
        offset: window.innerWidth < 768 ? 50 : 120, // Smaller offset for mobile
    });

    // Sync with ScrollTrigger
    lenis.on('scroll', () => {
        ScrollTrigger.update();
    });

    // Refresh animations if intro is skipped
    if (!isLoading.value) {
        nextTick(() => {
            AOS.refresh();
            ScrollTrigger.refresh();
        });
    }
});

watch(isContentVisible, (newVal) => {
    if (newVal) {
        // Intro complete
        nextTick(() => {
            AOS.refresh();
            ScrollTrigger.refresh();
            window.scrollTo(0, 0);
        });
    }
});

onUnmounted(() => {
    if (lenis) {
        lenis.destroy();
    }
    gsap.ticker.remove(lenis.raf);
});
</script>

<template>
    <div class="app-layout">
        <IntroLoader 
            v-if="isLoading" 
            :is-first-load="isFirstLoad"
            @reveal="isContentVisible = true" 
            @complete="handleIntroComplete" 
        />
        
        <div :class="{ 'content-hidden': !isContentVisible }">
            <Navbar />
            
            <main>
                <slot />
            </main>
            
            <Footer />
        </div>
    </div>
</template>

<style>
/* Layout specific styles if needed */
.app-layout {
    overflow-x: hidden;
    width: 100%;
    position: relative;
}

main {
    min-height: 80vh;
}

.content-hidden {
    opacity: 0;
    pointer-events: none;
}

.app-layout > div:not(.intro-experience) {
    /* Subtle fade in for main content only during initial reveal */
    transition: opacity 0.8s ease-out;
}
</style>
