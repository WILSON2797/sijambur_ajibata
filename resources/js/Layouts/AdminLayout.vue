<script setup>
import { ref, watch, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import AdminSidebar from '@/Components/Admin/AdminSidebar.vue';
import AdminHeader from '@/Components/Admin/AdminHeader.vue';
import AdminFooter from '@/Components/Admin/AdminFooter.vue';

const page = usePage();
const isSidebarOpen = ref(false);

const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value;
};

// Listen to flash messages
watch(() => page.props.flash, (flash) => {
    if (flash?.success) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: flash.success,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    }
    if (flash?.error) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: flash.error,
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
        });
    }
}, { deep: true });

onMounted(() => {
    // Initial check in case there's a flash message on first load
    if (page.props.flash?.success) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: page.props.flash.success,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    }
});
</script>

<template>
    <div class="admin-layout" :class="{ 'sidebar-open': isSidebarOpen }">
        <!-- Overlay for mobile when sidebar is open -->
        <div class="sidebar-overlay" v-if="isSidebarOpen" @click="isSidebarOpen = false"></div>

        <!-- Modular Sidebar -->
        <AdminSidebar :isOpen="isSidebarOpen" @close="isSidebarOpen = false" />

        <!-- Main Content Wrapper -->
        <main class="main-content">
            <!-- Modular Header -->
            <AdminHeader @toggle-sidebar="toggleSidebar">
                <slot name="header">Admin Panel</slot>
            </AdminHeader>

            <!-- Page Content -->
            <div class="content-body">
                <slot />
            </div>

            <!-- Modular Footer -->
            <AdminFooter />
        </main>
    </div>
</template>

<style scoped>
.admin-layout {
    display: flex;
    min-height: 100vh;
    background: #f8fafc;
    font-family: 'Plus Jakarta Sans', sans-serif;
    position: relative;
}

.main-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow-x: hidden;
    min-height: 100vh;
    width: 100%;
}

.content-body {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 40;
    display: none;
}

/* Desktop */
@media (min-width: 1024px) {
    .content-body {
        padding: 2.5rem;
    }
}

/* Mobile responsive */
@media (max-width: 1023px) {
    .sidebar-overlay {
        display: block;
    }
}
</style>
