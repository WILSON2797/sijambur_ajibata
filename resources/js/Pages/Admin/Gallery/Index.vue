<script setup>
import { ref } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Compressor from 'compressorjs';
import Swal from 'sweetalert2';

const props = defineProps({
    galleries: Array
});

const isModalOpen = ref(false);
const editingItem = ref(null);
const fileInput = ref(null);
const imagePreview = ref(null);

const form = useForm({
    title: '',
    description: '',
    category: '',
    image: null,
});

const openCreateModal = () => {
    editingItem.value = null;
    form.reset();
    imagePreview.value = null;
    isModalOpen.value = true;
};

const openEditModal = (item) => {
    editingItem.value = item;
    form.title = item.title || '';
    form.description = item.description || '';
    form.category = item.category || '';
    form.image = null;
    imagePreview.value = item.image || null;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    editingItem.value = null;
    form.reset();
    if (fileInput.value) fileInput.value.value = '';
};

const handleFileChange = (e) => {
    const file = e.target.files[0];
    if (!file) return;
    new Compressor(file, {
        quality: 0.6,
        maxWidth: 1920,
        success(result) {
            form.image = result;
            imagePreview.value = URL.createObjectURL(result);
        }
    });
};

const submit = () => {
    if (editingItem.value) {
        form.transform(data => ({ ...data, _method: 'put' }))
            .post(route('admin.gallery.update', editingItem.value.id), { onSuccess: () => closeModal() });
    } else {
        form.post(route('admin.gallery.store'), { onSuccess: () => closeModal() });
    }
};

const confirmDelete = (id) => {
    Swal.fire({
        title: 'Hapus Foto?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed) router.delete(route('admin.gallery.destroy', id));
    });
};
</script>

<template>
    <Head title="Kelola Galeri Foto" />
    <AdminLayout>
        <template #header>Galeri Foto</template>
        <div class="card">
            <div class="card-header">
                <div class="header-content">
                    <h2>Koleksi Foto</h2>
                    <p>Kelola dokumentasi visual kegiatan dan pesona desa.</p>
                </div>
                <button @click="openCreateModal" class="btn-create">+ Tambah Foto</button>
            </div>
            <div class="gallery-grid-admin">
                <div v-for="item in galleries" :key="item.id" class="gallery-card-admin">
                    <img :src="item.image" class="gallery-img-admin">
                    <div class="gallery-info-admin">
                        <h3>{{ item.title }}</h3>
                        <span class="badge">{{ item.category || 'Umum' }}</span>
                        <div class="gallery-actions-admin">
                            <button @click="openEditModal(item)" class="btn-icon">Edit</button>
                            <button @click="confirmDelete(item.id)" class="btn-icon btn-danger-text">Hapus</button>
                        </div>
                    </div>
                </div>
                <div v-if="galleries.length === 0" class="text-center py-5 w-full">Belum ada foto galeri.</div>
            </div>
        </div>

        <div class="modal-backdrop" v-if="isModalOpen" @click.self="closeModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>{{ editingItem ? 'Edit Foto' : 'Tambah Foto' }}</h2>
                    <button class="close-btn" @click="closeModal">×</button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="submit" class="admin-form">
                        <div class="form-group">
                            <label>Judul/Keterangan Foto</label>
                            <input type="text" v-model="form.title" required>
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <input type="text" v-model="form.category" placeholder="Contoh: Budaya, Alam, Kegiatan Desa">
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Singkat</label>
                            <textarea v-model="form.description" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Gambar</label>
                            <input type="file" ref="fileInput" accept="image/*" @change="handleFileChange">
                            <div v-if="imagePreview" class="img-preview"><img :src="imagePreview"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-cancel" @click="closeModal">Batal</button>
                            <button type="submit" class="btn-save" :disabled="form.processing">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
.card { background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden; }
.card-header { padding: 1.5rem 2rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
.btn-create { padding: 0.7rem 1.5rem; background: #1A3D2B; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; }
.gallery-grid-admin { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem; padding: 2rem; }
.gallery-card-admin { background: #f8fafc; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; transition: transform 0.2s; }
.gallery-card-admin:hover { transform: translateY(-4px); }
.gallery-img-admin { width: 100%; height: 150px; object-fit: cover; }
.gallery-info-admin { padding: 1rem; }
.gallery-info-admin h3 { font-size: 0.95rem; font-weight: 700; margin-bottom: 0.5rem; color: #1e293b; }
.gallery-actions-admin { display: flex; justify-content: space-between; margin-top: 1rem; border-top: 1px solid #e2e8f0; padding-top: 0.5rem; }
.btn-icon { background: none; border: none; font-size: 0.85rem; font-weight: 600; color: #1A3D2B; cursor: pointer; }
.btn-danger-text { color: #ef4444; }
.modal-backdrop { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 100; }
.modal-content { background: white; width: 100%; max-width: 500px; border-radius: 12px; max-height: 90vh; overflow-y: auto; }
.modal-header { padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; }
.modal-body { padding: 1.5rem; }
.form-group { margin-bottom: 1rem; display: flex; flex-direction: column; gap: 0.5rem; }
.form-group input, .form-group textarea { padding: 0.7rem; border: 1px solid #cbd5e1; border-radius: 8px; }
.img-preview img { max-height: 200px; width: 100%; object-fit: cover; margin-top: 0.5rem; border-radius: 8px; }
.modal-footer { display: flex; justify-content: flex-end; gap: 1rem; margin-top: 1.5rem; }
.btn-save { background: #1A3D2B; color: white; padding: 0.7rem 2rem; border: none; border-radius: 8px; cursor: pointer; }
.badge { padding: 0.2rem 0.5rem; background: #e2e8f0; border-radius: 4px; font-size: 0.75rem; color: #475569; }
.text-center { text-align: center; }
.py-5 { padding-top: 3rem; padding-bottom: 3rem; }
.w-full { grid-column: 1 / -1; }
</style>
