<script setup>
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();

defineProps({
    isOpen: {
        type: Boolean,
        default: false
    }
});

defineEmits(['close']);
</script>

<template>
    <aside class="sidebar" :class="{ 'is-open': isOpen }">
        <div class="sidebar-header">
            <img src="/img/logo.png" alt="Logo" class="sidebar-logo">
            <h2>Desa Pardomuan</h2>
            <button class="close-sidebar-btn" @click="$emit('close')">×</button>
        </div>
        
        <div class="sidebar-nav">
            <Link :href="route('admin.dashboard')" class="nav-item" :class="{'active': page.url === '/admin/dashboard'}">
                Dashboard
            </Link>
            <Link :href="route('admin.pages.index')" class="nav-item" :class="{'active': page.url?.startsWith('/admin/pages')}">
                Konten Halaman
            </Link>
            <Link :href="route('admin.news.index')" class="nav-item" :class="{'active': page.url?.startsWith('/admin/news')}">
                Berita & Pengumuman
            </Link>
            <Link :href="route('admin.potency.index')" class="nav-item" :class="{'active': page.url?.startsWith('/admin/potency')}">
                Potensi Desa
            </Link>
            <Link :href="route('admin.umkm.index')" class="nav-item" :class="{'active': page.url?.startsWith('/admin/umkm')}">
                UMKM
            </Link>
            <Link :href="route('admin.wisata.index')" class="nav-item" :class="{'active': page.url?.startsWith('/admin/wisata')}">
                Wisata
            </Link>
            <Link :href="route('admin.gallery.index')" class="nav-item" :class="{'active': page.url?.startsWith('/admin/gallery')}">
                Gallery
            </Link>
            <Link :href="route('admin.settings.index')" class="nav-item" :class="{'active': page.url?.startsWith('/admin/settings')}">
                Pengaturan Umum
            </Link>
        </div>
        
        <div class="sidebar-footer">
            <Link :href="route('logout')" method="post" as="button" class="logout-btn">
                Keluar (Logout)
            </Link>
        </div>
    </aside>
</template>

<style scoped>
.sidebar {
    width: 280px;
    background: #1A3D2B; /* Deep green */
    color: white;
    display: flex;
    flex-direction: column;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 50;
    transform: translateX(-100%);
    transition: transform 0.3s ease;
}

.sidebar.is-open {
    transform: translateX(0);
}

@media (min-width: 1024px) {
    .sidebar {
        position: sticky;
        transform: none;
    }
}

.sidebar-header {
    padding: 2rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.sidebar-logo {
    width: 40px;
    height: 40px;
    object-fit: contain;
}

.sidebar-header h2 {
    font-family: 'Lora', serif;
    font-size: 1.2rem;
    font-weight: 700;
    flex: 1;
}

.close-sidebar-btn {
    background: transparent;
    border: none;
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    display: block;
}

@media (min-width: 1024px) {
    .close-sidebar-btn {
        display: none;
    }
}

.sidebar-nav {
    flex: 1;
    padding: 1.5rem 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    overflow-y: auto;
}

.sidebar-nav::-webkit-scrollbar {
    width: 4px;
}
.sidebar-nav::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.2);
    border-radius: 4px;
}

.nav-item {
    display: block;
    padding: 0.8rem 1rem;
    color: rgba(255,255,255,0.7);
    text-decoration: none;
    border-radius: 8px;
    font-size: 0.95rem;
    font-weight: 500;
    transition: all 0.2s;
}

.nav-item:hover {
    background: rgba(255,255,255,0.1);
    color: white;
}

.nav-item.active {
    background: #A3B899;
    color: #1A3D2B;
    font-weight: 600;
}

.sidebar-footer {
    padding: 1.5rem;
    border-top: 1px solid rgba(255,255,255,0.1);
}

.logout-btn {
    width: 100%;
    padding: 0.8rem;
    background: rgba(239, 68, 68, 0.1);
    color: #fca5a5;
    border: 1px solid rgba(239, 68, 68, 0.2);
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.2s;
    text-align: center;
}

.logout-btn:hover {
    background: rgba(239, 68, 68, 0.2);
    color: white;
}
</style>
