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
                            <label>File Gambar</label>
                            
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

.gallery-grid-admin { 
    display: grid; 
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); 
    gap: 1.25rem; 
    padding: 1.5rem; 
}

.gallery-card-admin { 
    background: white; 
    border-radius: 16px; 
    overflow: hidden; 
    border: 1px solid #e2e8f0; 
    transition: all 0.3s ease; 
}

.gallery-card-admin:hover { 
    transform: translateY(-4px); 
    box-shadow: 0 12px 20px rgba(0,0,0,0.06);
}

.gallery-img-admin { 
    width: 100%; 
    height: 140px; 
    object-fit: cover; 
}

.gallery-info-admin { 
    padding: 1rem; 
}

.gallery-info-admin h3 { 
    font-size: 0.9rem; 
    font-weight: 700; 
    margin-bottom: 0.5rem; 
    color: #1e293b; 
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.gallery-actions-admin { 
    display: flex; 
    justify-content: space-between; 
    margin-top: 1rem; 
    border-top: 1px solid #f1f5f9; 
    padding-top: 0.75rem; 
}

.btn-icon { 
    background: none; 
    border: none; 
    font-size: 0.8rem; 
    font-weight: 700; 
    color: #1A3D2B; 
    cursor: pointer; 
    transition: color 0.2s;
}

.btn-danger-text { 
    color: #ef4444; 
}

.img-preview img { 
    max-height: 200px; 
    width: 100%; 
    object-fit: cover; 
    margin-top: 0.75rem; 
    border-radius: 12px; 
    border: 1px solid #e2e8f0;
}

.badge { 
    padding: 0.25rem 0.6rem; 
    background: #f1f5f9; 
    border-radius: 6px; 
    font-size: 0.7rem; 
    color: #64748b; 
    font-weight: 600;
}
</style>
