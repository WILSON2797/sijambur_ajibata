<script setup>
import { ref } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Compressor from 'compressorjs';
import Swal from 'sweetalert2';

const props = defineProps({
    umkms: Array
});

const isModalOpen = ref(false);
const editingItem = ref(null);
const fileInput = ref(null);
const imagePreview = ref(null);

const form = useForm({
    name: '',
    owner: '',
    description: '',
    category: '',
    phone: '',
    address: '',
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
    form.name = item.name || '';
    form.owner = item.owner || '';
    form.description = item.description || '';
    form.category = item.category || '';
    form.phone = item.phone || '';
    form.address = item.address || '';
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
    console.log("File picked:", e.target.files[0]); // Debug log
    const file = e.target.files[0];
    if (!file) return;

    // Cek ukuran file (Max 15MB)
    if (file.size > 15 * 1024 * 1024) {
        console.log("File too large");
        Swal.fire({
            title: 'File Terlalu Besar',
            text: 'Ukuran foto maksimal adalah 15MB.',
            icon: 'error',
            confirmButtonColor: '#1A3D2B',
        });
        e.target.value = '';
        return;
    }

    console.log("Starting compression...");
    Swal.fire({
        title: 'Memproses Gambar...',
        text: 'Mohon tunggu sebentar.',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
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
            
            setTimeout(() => {
                Swal.close();
                console.log("Swal closed");
            }, 800);
        },
        error(err) {
            Swal.close();
            console.error("Compression error:", err.message);
        }
    });
};

const submit = () => {
    if (editingItem.value) {
        form.transform(data => ({ ...data, _method: 'put' }))
            .post(route('admin.umkm.update', editingItem.value.id), { onSuccess: () => closeModal() });
    } else {
        form.post(route('admin.umkm.store'), { onSuccess: () => closeModal() });
    }
};

const confirmDelete = (id) => {
    Swal.fire({
        title: 'Hapus UMKM?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed) router.delete(route('admin.umkm.destroy', id));
    });
};
</script>

<template>
    <Head title="Kelola UMKM Desa" />
    <AdminLayout>
        <template #header>UMKM Desa</template>
        <div class="card">
            <div class="card-header">
                <div class="header-content">
                    <h2>Daftar UMKM</h2>
                    <p>Kelola data usaha mikro, kecil, dan menengah di desa.</p>
                </div>
                <button @click="openCreateModal" class="btn-create">+ Tambah UMKM</button>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Nama Usaha</th>
                            <th>Pemilik</th>
                            <th>Kategori</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in umkms" :key="item.id">
                            <td><img :src="item.image" class="table-img"></td>
                            <td class="font-medium">{{ item.name }}</td>
                            <td>{{ item.owner || '-' }}</td>
                            <td><span class="badge">{{ item.category || 'Umum' }}</span></td>
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
                    <h2>{{ editingItem ? 'Edit UMKM' : 'Tambah UMKM' }}</h2>
                    <button class="close-btn" @click="closeModal">×</button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="submit" class="admin-form">
                        <div class="form-group">
                            <label>Nama UMKM</label>
                            <input type="text" v-model="form.name" required>
                        </div>
                        <div class="form-group">
                            <label>Nama Pemilik</label>
                            <input type="text" v-model="form.owner">
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <input type="text" v-model="form.category" placeholder="Contoh: Kuliner, Kerajinan">
                        </div>
                        <div class="form-group">
                            <label>No. Telepon / WA</label>
                            <input type="text" v-model="form.phone">
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea v-model="form.address" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Produk/Usaha</label>
                            <textarea v-model="form.description" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Gambar Produk/Toko</label>
                            
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
</style>
