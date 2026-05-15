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
    const file = e.target.files[0];
    if (!file) return;

    new Compressor(file, {
        quality: 0.6, // Compress quality to 60%
        maxWidth: 1920,
        success(result) {
            form.image = result;
            imagePreview.value = URL.createObjectURL(result);
        },
        error(err) {
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
                            <input type="file" ref="fileInput" accept="image/*" @change="handleFileChange" :required="!editingNews">
                            <span class="error" v-if="form.errors.image">{{ form.errors.image }}</span>
                            
                            <div v-if="imagePreview" class="img-preview">
                                <img :src="imagePreview" alt="Preview">
                            </div>
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
.card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    overflow: hidden;
}

.card-header {
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.header-content h2 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
}

.header-content p {
    color: #64748b;
    font-size: 0.9rem;
    margin-top: 0.25rem;
}

.btn-create {
    padding: 0.75rem 1.5rem;
    background: #1A3D2B;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-create:hover {
    background: #A3B899;
    color: #1A3D2B;
}

.table-responsive {
    overflow-x: auto;
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
}

.admin-table th {
    background: #f8fafc;
    text-align: left;
    padding: 1rem 2rem;
    font-size: 0.85rem;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 1px solid #e2e8f0;
}

.admin-table td {
    padding: 1.2rem 2rem;
    border-bottom: 1px solid #e2e8f0;
    vertical-align: middle;
}

.table-img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
}

.font-medium {
    font-weight: 600;
    color: #334155;
}

.text-gray {
    color: #64748b;
    font-size: 0.85rem;
    margin-top: 0.25rem;
}

.truncate-text {
    max-width: 300px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.text-right { text-align: right !important; }
.text-center { text-align: center !important; }
.py-4 { padding-top: 2rem !important; padding-bottom: 2rem !important; }

.btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 1rem;
    background: #f1f5f9;
    color: #334155;
    font-size: 0.85rem;
    font-weight: 600;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    cursor: pointer;
    margin-left: 0.5rem;
    transition: all 0.2s;
}

.btn-action:hover {
    background: #e2e8f0;
}

.btn-danger {
    background: #fef2f2;
    color: #ef4444;
    border-color: #fca5a5;
}

.btn-danger:hover {
    background: #fee2e2;
}

/* Modal Styles */
.modal-backdrop {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 100;
    padding: 1rem;
}

.modal-content {
    background: white;
    width: 100%;
    max-width: 700px;
    border-radius: 12px;
    box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
    max-height: 90vh;
    display: flex;
    flex-direction: column;
}

.modal-header {
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h2 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}

.close-btn {
    background: transparent;
    border: none;
    font-size: 1.5rem;
    color: #94a3b8;
    cursor: pointer;
    transition: color 0.2s;
}

.close-btn:hover {
    color: #ef4444;
}

.modal-body {
    padding: 2rem;
    overflow-y: auto;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
}

.form-group label {
    font-weight: 600;
    color: #334155;
    font-size: 0.9rem;
}

.form-group input[type="text"], 
.form-group input[type="date"], 
.form-group textarea {
    padding: 0.75rem 1rem;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-family: inherit;
    font-size: 1rem;
    color: #1e293b;
    background: #f8fafc;
    transition: all 0.2s;
}

.form-group input:focus, 
.form-group textarea:focus {
    outline: none;
    border-color: #A3B899;
    background: white;
    box-shadow: 0 0 0 3px rgba(163, 184, 153, 0.2);
}

.img-preview {
    margin-top: 1rem;
}

.img-preview img {
    max-height: 150px;
    border-radius: 8px;
    object-fit: cover;
}

.error {
    color: #ef4444;
    font-size: 0.8rem;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e2e8f0;
}

.btn-cancel {
    padding: 0.75rem 1.5rem;
    background: white;
    color: #475569;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-cancel:hover {
    background: #f8fafc;
    color: #1e293b;
}

.btn-save {
    padding: 0.75rem 2rem;
    background: #1A3D2B;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-save:hover {
    background: #0f241a;
}

.btn-save:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}
</style>
