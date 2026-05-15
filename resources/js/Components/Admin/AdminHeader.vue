<script setup>
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const emit = defineEmits(['toggle-sidebar']);
</script>

<template>
    <header class="topbar">
        <div class="header-left">
            <button class="hamburger-btn" @click="emit('toggle-sidebar')">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            </button>
            <h1><slot>Admin Panel</slot></h1>
        </div>
        
        <div class="header-right">
            <div class="user-info">
                <div class="avatar">
                    {{ page.props.auth?.user?.name?.charAt(0) || 'A' }}
                </div>
                <div class="user-details">
                    <span class="user-name">{{ page.props.auth?.user?.name || 'Admin Desa' }}</span>
                    <span class="user-role">Administrator</span>
                </div>
            </div>
        </div>
    </header>
</template>

<style scoped>
.topbar {
    background: white;
    padding: 0.75rem 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #edf2f7;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
}

.header-left {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.hamburger-btn {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    color: #1e293b;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 10px;
    transition: all 0.2s;
}

.hamburger-btn:hover {
    background: #f1f5f9;
}

.header-left h1 {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 150px;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 0.6rem;
}

.avatar {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    background: #1A3D2B;
    color: #A3B899;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1rem;
}

.user-details {
    display: none;
    flex-direction: column;
}

.user-name {
    font-weight: 600;
    color: #1e293b;
    font-size: 0.85rem;
}

.user-role {
    font-size: 0.65rem;
    color: #64748b;
    font-weight: 500;
}

@media (min-width: 640px) {
    .header-left h1 {
        max-width: none;
    }
}

@media (min-width: 1024px) {
    .hamburger-btn {
        display: none;
    }
    .topbar {
        padding: 1rem 2rem;
    }
    .header-left h1 {
        font-size: 1.3rem;
    }
    .user-details {
        display: flex;
    }
    .user-info {
        gap: 0.8rem;
    }
    .avatar {
        width: 38px;
        height: 38px;
        font-size: 1.1rem;
    }
}
</style>


