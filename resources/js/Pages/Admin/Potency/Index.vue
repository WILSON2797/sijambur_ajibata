<script setup>
import { ref } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Compressor from 'compressorjs';
import Swal from 'sweetalert2';

const props = defineProps({
    potencies: Array
});

const isModalOpen = ref(false);
const editingItem = ref(null);
const fileInput = ref(null);
const imagePreview = ref(null);

const form = useForm({
    title: '',
    description: '',
    tag: '',
    image: null,
    is_featured: false,
});

const openCreateModal = () => {
    editingItem.value = null;
    form.reset();
    form.clearErrors();
    imagePreview.value = null;
    isModalOpen.value = true;
};

const openEditModal = (item) => {
    editingItem.value = item;
    form.title = item.title || '';
    form.description = item.description || '';
    form.tag = item.tag || '';
    form.is_featured = !!item.is_featured;
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
            .post(route('admin.potency.update', editingItem.value.id), { onSuccess: () => closeModal() });
    } else {
        form.post(route('admin.potency.store'), { onSuccess: () => closeModal() });
    }
};

const confirmDelete = (id) => {
    Swal.fire({
        title: 'Hapus Potensi?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed) router.delete(route('admin.potency.destroy', id));
    });
};
</script>

<template>
    <Head title="Kelola Potensi Desa" />
    <AdminLayout>
        <template #header>Potensi Desa</template>
        <div class="card">
            <div class="card-header">
                <div class="header-content">
                    <h2>Daftar Potensi</h2>
                    <p>Kelola potensi unggulan yang dimiliki desa.</p>
                </div>
                <button @click="openCreateModal" class="btn-create">+ Tambah Potensi</button>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Judul</th>
                            <th>Tag</th>
                            <th>Featured</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in potencies" :key="item.id">
                            <td><img :src="item.image" class="table-img"></td>
                            <td class="font-medium">{{ item.title }}</td>
                            <td><span class="badge">{{ item.tag }}</span></td>
                            <td>{{ item.is_featured ? 'Ya' : 'Tidak' }}</td>
                            <td class="text-right">
                                <button @click="openEditModal(item)" class="btn-action">Edit</button>
                                <button @click="confirmDelete(item.id)" class="btn-action btn-danger">Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal-backdrop" v-if="isModalOpen" @click.self="closeModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>{{ editingItem ? 'Edit Potensi' : 'Tambah Potensi' }}</h2>
                    <button class="close-btn" @click="closeModal">×</button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="submit" class="admin-form">
                        <div class="form-group">
                            <label>Judul Potensi</label>
                            <input type="text" v-model="form.title" required>
                        </div>
                        <div class="form-group">
                            <label>Tag (Misal: Pertanian, Wisata)</label>
                            <input type="text" v-model="form.tag">
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea v-model="form.description" rows="4" required></textarea>
                        </div>
                        <div class="form-group-row">
                            <label class="checkbox-container">
                                <input type="checkbox" v-model="form.is_featured">
                                <span class="checkmark"></span>
                                Jadikan Unggulan (Featured)
                            </label>
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
/* Reuse styles from News/Index.vue or move to global if possible */
.card { background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden; }
.card-header { padding: 1.5rem 2rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
.btn-create { padding: 0.7rem 1.5rem; background: #1A3D2B; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; }
.admin-table { width: 100%; border-collapse: collapse; }
.admin-table th { background: #f8fafc; padding: 1rem 2rem; text-align: left; font-size: 0.85rem; color: #64748b; border-bottom: 1px solid #e2e8f0; }
.admin-table td { padding: 1rem 2rem; border-bottom: 1px solid #e2e8f0; }
.table-img { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; }
.btn-action { padding: 0.5rem 1rem; background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px; cursor: pointer; margin-left: 0.5rem; }
.btn-danger { color: #ef4444; border-color: #fca5a5; }
.modal-backdrop { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 100; }
.modal-content { background: white; width: 100%; max-width: 600px; border-radius: 12px; max-height: 90vh; overflow-y: auto; }
.modal-header { padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; }
.modal-body { padding: 1.5rem; }
.form-group { margin-bottom: 1rem; display: flex; flex-direction: column; gap: 0.5rem; }
.form-group input, .form-group textarea { padding: 0.7rem; border: 1px solid #cbd5e1; border-radius: 8px; }
.img-preview img { max-height: 150px; margin-top: 0.5rem; border-radius: 8px; }
.modal-footer { display: flex; justify-content: flex-end; gap: 1rem; margin-top: 1.5rem; }
.btn-save { background: #1A3D2B; color: white; padding: 0.7rem 2rem; border: none; border-radius: 8px; cursor: pointer; }
.badge { padding: 0.2rem 0.6rem; background: #f1f5f9; border-radius: 99px; font-size: 0.8rem; }
.checkbox-container { display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-weight: 600; font-size: 0.9rem; }
</style>
