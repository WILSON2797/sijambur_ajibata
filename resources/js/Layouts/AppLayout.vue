<script setup>
import { onMounted, onUnmounted } from 'vue';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import Lenis from 'lenis';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

let lenis;

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

    // Global reveal animation using GSAP
    const revealElements = document.querySelectorAll('.reveal');
    revealElements.forEach((el) => {
        gsap.fromTo(el, 
            { y: 50, opacity: 0 }, 
            { 
                y: 0, 
                opacity: 1, 
                duration: 1, 
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: el,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            }
        );
    });
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
        <Navbar />
        
        <main>
            <slot />
        </main>
        
        <Footer />
    </div>
</template>

<style>
/* Layout specific styles if needed */
main {
    min-height: 80vh;
}
</style>
