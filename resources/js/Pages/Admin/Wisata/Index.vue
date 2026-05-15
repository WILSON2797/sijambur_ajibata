<script setup>
import { ref } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Compressor from 'compressorjs';
import Swal from 'sweetalert2';

const props = defineProps({
    wisatas: Array
});

const isModalOpen = ref(false);
const editingItem = ref(null);
const fileInput = ref(null);
const imagePreview = ref(null);

const form = useForm({
    name: '',
    description: '',
    location: '',
    category: '',
    image: null,
    is_featured: false,
});

const openCreateModal = () => {
    editingItem.value = null;
    form.reset();
    imagePreview.value = null;
    isModalOpen.value = true;
};

const openEditModal = (item) => {
    editingItem.value = item;
    form.name = item.name || '';
    form.description = item.description || '';
    form.location = item.location || '';
    form.category = item.category || '';
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
    console.log("File picked:", e.target.files[0]);
    const file = e.target.files[0];
    if (!file) return;

    // Cek ukuran file (Max 15MB)
    if (file.size > 15 * 1024 * 1024) {
        Swal.fire({
            title: 'File Terlalu Besar',
            text: 'Ukuran foto maksimal adalah 15MB.',
            icon: 'error',
            confirmButtonColor: '#1A3D2B',
        });
        e.target.value = '';
        return;
    }

    Swal.fire({
        title: 'Memproses Gambar...',
        text: 'Mohon tunggu sebentar.',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    new Compressor(file, {
        quality: 0.6,
        maxWidth: 1920,
        success(result) {
            console.log("Compression success:", result);
            form.image = result;
            imagePreview.value = URL.createObjectURL(result);
            
            // Berikan jeda sedikit agar user bisa melihat loadingnya
            setTimeout(() => {
                Swal.close();
            }, 800);
        },
        error(err) {
            Swal.close();
            console.error(err.message);
        }
    });
};

const submit = () => {
    if (editingItem.value) {
        form.transform(data => ({ ...data, _method: 'put' }))
            .post(route('admin.wisata.update', editingItem.value.id), { onSuccess: () => closeModal() });
    } else {
        form.post(route('admin.wisata.store'), { onSuccess: () => closeModal() });
    }
};

const confirmDelete = (id) => {
    Swal.fire({
        title: 'Hapus Wisata?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed) router.delete(route('admin.wisata.destroy', id));
    });
};
</script>

<template>
    <Head title="Kelola Wisata Desa" />
    <AdminLayout>
        <template #header>Wisata Desa</template>
        <div class="card">
            <div class="card-header">
                <div class="header-content">
                    <h2>Daftar Objek Wisata</h2>
                    <p>Kelola destinasi wisata alam dan budaya di desa.</p>
                </div>
                <button @click="openCreateModal" class="btn-create">+ Tambah Wisata</button>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Nama Wisata</th>
                            <th>Lokasi</th>
                            <th>Kategori</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in wisatas" :key="item.id">
                            <td><img :src="item.image" class="table-img"></td>
                            <td class="font-medium">{{ item.name }}</td>
                            <td>{{ item.location || '-' }}</td>
                            <td><span class="badge">{{ item.category || 'Alam' }}</span></td>
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
                    <h2>{{ editingItem ? 'Edit Wisata' : 'Tambah Wisata' }}</h2>
                    <button class="close-btn" @click="closeModal">×</button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="submit" class="admin-form">
                        <div class="form-group">
                            <label>Nama Objek Wisata</label>
                            <input type="text" v-model="form.name" required>
                            <div v-if="form.errors.name" class="error">{{ form.errors.name }}</div>
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <input type="text" v-model="form.category" placeholder="Contoh: Wisata Alam, Budaya, Edukasi">
                            <div v-if="form.errors.category" class="error">{{ form.errors.category }}</div>
                        </div>
                        <div class="form-group">
                            <label>Lokasi</label>
                            <input type="text" v-model="form.location" placeholder="Misal: Dusun I, Tepi Danau">
                            <div v-if="form.errors.location" class="error">{{ form.errors.location }}</div>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea v-model="form.description" rows="4" required></textarea>
                            <div v-if="form.errors.description" class="error">{{ form.errors.description }}</div>
                        </div>
                        <div class="form-group">
                            <label class="switch-container">
                                <div class="switch-label">
                                    <span class="switch-title">Destinasi Utama</span>
                                    <span class="switch-desc">Tampilkan sebagai destinasi unggulan di halaman depan.</span>
                                </div>
                                <div class="switch">
                                    <input type="checkbox" v-model="form.is_featured" :true-value="1" :false-value="0">
                                    <span class="slider"></span>
                                </div>
                            </label>
                            <div v-if="form.errors.is_featured" class="error">{{ form.errors.is_featured }}</div>
                        </div>
                        <div class="form-group">
                            <label>Gambar Objek Wisata</label>
                            
                            <div class="upload-container-relative">
                                <!-- Custom Upload Picker -->
                                <div v-if="!imagePreview" class="upload-picker">
                                    <div class="upload-option" @click="$refs.fileInput.removeAttribute('capture'); $refs.fileInput.click()">
                                        <i class="fa-solid fa-images"></i>
                                        <span>Galeri</span>
                                    </div>
                                    <div class="upload-option" @click="$refs.fileInput.setAttribute('capture', 'environment'); $refs.fileInput.click()">
                                        <i class="fa-solid fa-camera"></i>
                                        <span>Kamera</span>
                                    </div>
                                </div>
                            </div>

                            <input type="file" ref="fileInput" accept="image/*" @change="handleFileChange" style="display: none;">
                            
                            <div v-if="imagePreview" class="image-preview-container">
                                <img :src="imagePreview" alt="Preview">
                                <button type="button" class="remove-img-btn" @click="imagePreview = null; form.image = null">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                            <div v-if="form.errors.image" class="error">{{ form.errors.image }}</div>
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
.card-header { 
    display: flex; 
    flex-direction: column; 
    gap: 1rem; 
}

@media (min-width: 640px) {
    .card-header {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }
}

.table-img { 
    width: 50px; 
    height: 50px; 
    object-fit: cover; 
    border-radius: 8px; 
}

.btn-action { 
    padding: 0.4rem 0.8rem; 
    background: #f8fafc; 
    border: 1px solid #e2e8f0; 
    border-radius: 8px; 
    cursor: pointer; 
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-danger { 
    color: #ef4444; 
    border-color: #fee2e2; 
}

.btn-danger:hover {
    background: #fee2e2;
}

.img-preview img { 
    max-width: 100%; 
    max-height: 200px; 
    margin-top: 0.75rem; 
    border-radius: 12px; 
    border: 1px solid #e2e8f0;
}

.badge { 
    padding: 0.25rem 0.75rem; 
    background: #f1f5f9; 
    border-radius: 99px; 
    font-size: 0.75rem; 
    color: #475569;
    font-weight: 600;
}

.error {
    color: #ef4444;
    font-size: 0.75rem;
    margin-top: 0.25rem;
}
</style>
