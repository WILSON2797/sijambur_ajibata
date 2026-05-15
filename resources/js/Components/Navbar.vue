<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';

const isScrolled = ref(false);
const isMenuOpen = ref(false);

const handleScroll = () => {
    isScrolled.value = window.scrollY > 80;
};

const getScrollbarWidth = () => window.innerWidth - document.documentElement.clientWidth;

const lockScroll = () => {
    const sw = getScrollbarWidth();
    document.body.style.overflow = 'hidden';
    document.body.style.paddingRight = sw + 'px';
    // Also pad the fixed nav so it doesn't shift
    const nav = document.querySelector('nav');
    if (nav) nav.style.paddingRight = (parseFloat(getComputedStyle(nav).paddingRight) + sw) + 'px';
};

const unlockScroll = () => {
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';
    const nav = document.querySelector('nav');
    if (nav) nav.style.paddingRight = '';
};

const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
    if (isMenuOpen.value) {
        lockScroll();
    } else {
        unlockScroll();
    }
};

const closeMenu = () => {
    isMenuOpen.value = false;
    unlockScroll();
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll, { passive: true });
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});
</script>

<template>
    <nav :class="{ 'scrolled': isScrolled, 'menu-open': isMenuOpen }">
        <Link href="/" class="nav-logo" @click="closeMenu">
            <img class="nav-logo-img" src="/img/logo.png" alt="Logo Kab. Toba" />
            <div class="nav-logo-text">
                <strong>Pardomuan Ajibata</strong>
                <span>Kab. Toba · Sumatera Utara</span>
            </div>
        </Link>

        <!-- DESKTOP LINKS -->
        <ul class="nav-links desktop-only">
            <li><Link :href="route('home')" @click="closeMenu">Home</Link></li>
            <li><Link :href="route('about')" @click="closeMenu">Tentang</Link></li>
            <li><Link :href="route('potency')" @click="closeMenu">Potensi</Link></li>
            <li><Link :href="route('umkm')" @click="closeMenu">UMKM Desa</Link></li>
            <li><Link :href="route('wisata')" @click="closeMenu">Wisata Desa</Link></li>
            <li><Link :href="route('gallery')" @click="closeMenu">Gallery</Link></li>
            <li><Link :href="route('news')" @click="closeMenu">Berita</Link></li>
            <li><Link :href="route('home') + '#kontak'" class="nav-btn" @click="closeMenu">Hubungi Kami</Link></li>
        </ul>

        <!-- HAMBURGER ICON -->
        <button class="mobile-toggle" @click="toggleMenu" aria-label="Toggle menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>

        <!-- MOBILE OVERLAY -->
        <div class="mobile-overlay" :class="{ 'active': isMenuOpen }">
            <ul class="mobile-links">
                <li><Link :href="route('home')" @click="closeMenu">Home</Link></li>
                <li><Link :href="route('about')" @click="closeMenu">Tentang</Link></li>
                <li><Link :href="route('potency')" @click="closeMenu">Potensi</Link></li>
                <li><Link :href="route('umkm')" @click="closeMenu">UMKM Desa</Link></li>
                <li><Link :href="route('wisata')" @click="closeMenu">Wisata Desa</Link></li>
                <li><Link :href="route('gallery')" @click="closeMenu">Gallery</Link></li>
                <li><Link :href="route('news')" @click="closeMenu">Berita</Link></li>
                <li><Link :href="route('home') + '#kontak'" class="nav-btn" @click="closeMenu">Hubungi Kami</Link></li>
            </ul>
        </div>
    </nav>
</template>
