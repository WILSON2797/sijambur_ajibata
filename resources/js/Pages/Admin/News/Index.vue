<script setup>
import { ref } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Compressor from 'compressorjs';
import Swal from 'sweetalert2';

const props = defineProps({
    news: Array
});

// Modal state
const isModalOpen = ref(false);
const editingNews = ref(null);
const fileInput = ref(null);
const imagePreview = ref(null);

const form = useForm({
    title: '',
    excerpt: '',
    content: '',
    published_at: new Date().toISOString().split('T')[0],
    image: null,
});

const openCreateModal = () => {
    editingNews.value = null;
    form.reset();
    form.clearErrors();
    form.published_at = new Date().toISOString().split('T')[0];
    imagePreview.value = null;
    isModalOpen.value = true;
};

const openEditModal = (newsItem) => {
    editingNews.value = newsItem;
    form.title = newsItem.title || '';
    form.excerpt = newsItem.excerpt || '';
    form.content = newsItem.content || '';
    form.published_at = newsItem.published_at || new Date().toISOString().split('T')[0];
    form.image = null; // Clear any old file
    imagePreview.value = newsItem.image || null;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    editingNews.value = null;
    form.reset();
    form.clearErrors();
    if (fileInput.value) fileInput.value.value = '';
};

// Handle file change and compress
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
        quality: 0.6, // Compress quality to 60%
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
        },
    });
};

const submit = () => {
    if (editingNews.value) {
        form.transform((data) => ({
            ...data,
            _method: 'put',
        })).post(route('admin.news.update', editingNews.value.id), {
            onSuccess: () => closeModal()
        });
    } else {
        form.post(route('admin.news.store'), {
            onSuccess: () => closeModal()
        });
    }
};

const confirmDelete = (id) => {
    Swal.fire({
        title: 'Hapus Berita?',
        text: "Berita yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('admin.news.destroy', id));
        }
    });
};
</script>

<template>
    <Head title="Kelola Berita" />

    <AdminLayout>
        <template #header>Kelola Berita & Pengumuman</template>

        <div class="card">
            <div class="card-header">
                <div class="header-content">
                    <h2>Daftar Berita</h2>
                    <p>Kelola semua berita dan pengumuman untuk website desa.</p>
                </div>
                <button @click="openCreateModal" class="btn-create">
                    + Tambah Berita
                </button>
            </div>

            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Judul Berita</th>
                            <th>Tanggal Publikasi</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in news" :key="item.id">
                            <td>
                                <img :src="item.image" class="table-img" alt="Thumbnail">
                            </td>
                            <td class="font-medium">
                                {{ item.title }}
                                <div class="text-gray truncate-text">{{ item.excerpt }}</div>
                            </td>
                            <td>{{ new Date(item.published_at).toLocaleDateString('id-ID') }}</td>
                            <td class="text-right">
                                <button @click="openEditModal(item)" class="btn-action">Edit</button>
                                <button @click="confirmDelete(item.id)" class="btn-action btn-danger">Hapus</button>
                            </td>
                        </tr>
                        <tr v-if="news.length === 0">
                            <td colspan="4" class="text-center text-gray py-4">Belum ada berita.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create/Edit Modal -->
        <div class="modal-backdrop" v-if="isModalOpen" @click.self="closeModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>{{ editingNews ? 'Edit Berita' : 'Tambah Berita Baru' }}</h2>
                    <button class="close-btn" @click="closeModal">×</button>
                </div>

                <div class="modal-body">
                    <form @submit.prevent="submit" class="admin-form">
                        <div class="form-group">
                            <label>Judul Berita</label>
                            <input type="text" v-model="form.title" required>
                            <span class="error" v-if="form.errors.title">{{ form.errors.title }}</span>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Publikasi</label>
                            <input type="date" v-model="form.published_at" required>
                            <span class="error" v-if="form.errors.published_at">{{ form.errors.published_at }}</span>
                        </div>

                        <div class="form-group">
                            <label>Kutipan Singkat (Excerpt)</label>
                            <textarea v-model="form.excerpt" rows="2" maxlength="500" required></textarea>
                            <span class="error" v-if="form.errors.excerpt">{{ form.errors.excerpt }}</span>
                        </div>

                        <div class="form-group">
                            <label>Isi Berita Lengkap</label>
                            <textarea v-model="form.content" rows="6" required></textarea>
                            <span class="error" v-if="form.errors.content">{{ form.errors.content }}</span>
                        </div>

                        <div class="form-group">
                            <label>Gambar Thumbnail (Otomatis Kompresi)</label>
                            
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

                            <input type="file" ref="fileInput" accept="image/*" @change="handleFileChange" style="display: none;" :required="!editingNews">
                            
                            <div v-if="imagePreview" class="image-preview-container">
                                <img :src="imagePreview" alt="Preview">
                                <button type="button" class="remove-img-btn" @click="imagePreview = null; form.image = null">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                            <span class="error" v-if="form.errors.image">{{ form.errors.image }}</span>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn-cancel" @click="closeModal">Batal</button>
                            <button type="submit" class="btn-save" :disabled="form.processing">
                                {{ form.processing ? 'Menyimpan...' : 'Simpan Berita' }}
                            </button>
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

.truncate-text {
    max-width: 200px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    color: #64748b;
    font-size: 0.8rem;
}

.img-preview img { 
    max-width: 100%; 
    max-height: 200px; 
    margin-top: 0.75rem; 
    border-radius: 12px; 
    border: 1px solid #e2e8f0;
}

.error {
    color: #ef4444;
    font-size: 0.75rem;
    margin-top: 0.25rem;
}
</style>
