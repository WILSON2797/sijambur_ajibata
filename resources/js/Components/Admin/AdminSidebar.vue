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
    z-index: 150; /* Ensure it's above header */
    transform: translateX(-100%);
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: 10px 0 30px rgba(0,0,0,0.1);
}

.sidebar.is-open {
    transform: translateX(0);
}

@media (min-width: 1024px) {
    .sidebar {
        position: sticky;
        transform: none;
        box-shadow: none;
        z-index: 50;
    }
}

.sidebar-header {
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    border-bottom: 1px solid rgba(255,255,255,0.08);
}

.sidebar-logo {
    width: 36px;
    height: 36px;
    object-fit: contain;
}

.sidebar-header h2 {
    font-family: 'Lora', serif;
    font-size: 1.1rem;
    font-weight: 700;
    flex: 1;
    margin: 0;
}

.close-sidebar-btn {
    background: rgba(255,255,255,0.1);
    border: none;
    color: white;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 1.2rem;
}

@media (min-width: 1024px) {
    .close-sidebar-btn {
        display: none;
    }
}

.sidebar-nav {
    flex: 1;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
    overflow-y: auto;
}

.nav-item {
    display: flex;
    align-items: center;
    padding: 0.85rem 1rem;
    color: rgba(255,255,255,0.6);
    text-decoration: none;
    border-radius: 10px;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.2s;
}

@media (max-width: 1023px) {
    .nav-item {
        padding: 1rem; /* Bigger touch target on mobile */
        font-size: 0.95rem;
    }
}

.nav-item:hover {
    background: rgba(255,255,255,0.05);
    color: white;
}

.nav-item.active {
    background: #A3B899;
    color: #1A3D2B;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(163, 184, 153, 0.2);
}

.sidebar-footer {
    padding: 1.5rem 1rem;
    border-top: 1px solid rgba(255,255,255,0.08);
}

.logout-btn {
    width: 100%;
    padding: 0.9rem;
    background: rgba(239, 68, 68, 0.08);
    color: #fca5a5;
    border: 1px solid rgba(239, 68, 68, 0.15);
    border-radius: 10px;
    cursor: pointer;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.2s;
    text-align: center;
}

.logout-btn:hover {
    background: rgba(239, 68, 68, 0.2);
    color: white;
}
</style>
