<script setup>
import { onMounted } from 'vue';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';

onMounted(() => {
    // REVEAL OBSERVER
    const observer = new IntersectionObserver(entries => {
        entries.forEach(e => { 
            if (e.isIntersecting) { 
                e.target.classList.add('visible'); 
                observer.unobserve(e.target); 
            } 
        });
    }, { threshold: 0.1 });
    
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
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
