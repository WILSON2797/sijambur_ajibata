<script setup>
import { ref } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Compressor from 'compressorjs';

const props = defineProps({
    pages: Array
});

// Modal state
const isModalOpen = ref(false);
const editingPage = ref(null);
const fileInput = ref(null);
const imagePreview = ref(null);

const form = useForm({
    title: '',
    subtitle: '',
    content: '',
    image: null,
    image_2: null,
    image_3: null,
});

const imagePreviews = ref({
    image: null,
    image_2: null,
    image_3: null,
});

const openEditModal = (page) => {
    editingPage.value = page;
    form.title = page.title || '';
    form.subtitle = page.subtitle || '';
    form.content = page.content || '';
    form.image = null;
    form.image_2 = null;
    form.image_3 = null;
    
    imagePreviews.value.image = page.image || null;
    imagePreviews.value.image_2 = page.image_2 || null;
    imagePreviews.value.image_3 = page.image_3 || null;
    
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    editingPage.value = null;
    form.reset();
    form.clearErrors();
    imagePreviews.value = { image: null, image_2: null, image_3: null };
};

const handleFileChange = (e, field) => {
    const file = e.target.files[0];
    if (!file) return;

    new Compressor(file, {
        quality: 0.6,
        maxWidth: 1920,
        success(result) {
            form[field] = result;
            imagePreviews.value[field] = URL.createObjectURL(result);
        },
        error(err) {
            console.error(err.message);
        },
    });
};

const submit = () => {
    form.transform((data) => ({
        ...data,
        _method: 'put',
    })).post(route('admin.pages.update', editingPage.value.id), {
        onSuccess: () => {
            closeModal();
        }
    });
};
</script>

<template>
    <Head title="Kelola Konten Halaman" />

    <AdminLayout>
        <template #header>Kelola Konten Halaman</template>

        <div class="card">
            <div class="card-header">
                <h2>Daftar Halaman</h2>
                <p>Bagian-bagian statis pada website (Hero, Tentang Kami, dll).</p>
            </div>

            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Section</th>
                            <th>Judul Utama</th>
                            <th>Subtitle / Tag</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="page in pages" :key="page.id">
                            <td>
                                <span class="badge">{{ page.section }}</span>
                            </td>
                            <td class="font-medium">{{ page.title }}</td>
                            <td class="text-gray">{{ page.subtitle || '-' }}</td>
                            <td class="text-right">
                                <button @click="openEditModal(page)" class="btn-action">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal-backdrop" v-if="isModalOpen" @click.self="closeModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Edit Konten: <span class="badge">{{ editingPage?.section }}</span></h2>
                    <button class="close-btn" @click="closeModal">×</button>
                </div>

                <div class="modal-body">
                    <form @submit.prevent="submit" class="admin-form">
                        <div class="form-group">
                            <label>Judul Utama</label>
                            <input type="text" v-model="form.title" required>
                            <span class="error" v-if="form.errors.title">{{ form.errors.title }}</span>
                        </div>

                        <div class="form-group">
                            <label>Subtitle / Tagline</label>
                            <input type="text" v-model="form.subtitle">
                            <span class="error" v-if="form.errors.subtitle">{{ form.errors.subtitle }}</span>
                        </div>

                        <div class="form-group">
                            <label>Konten Deskripsi</label>
                            <textarea v-model="form.content" rows="4" required></textarea>
                            <span class="error" v-if="form.errors.content">{{ form.errors.content }}</span>
                        </div>

                        <div class="form-group">
                            <label>{{ editingPage?.slug === 'about' ? 'Gambar Utama (Besar)' : 'Upload Gambar' }}</label>
                            <input type="file" @change="handleFileChange($event, 'image')" accept="image/*">
                            <span class="error" v-if="form.errors.image">{{ form.errors.image }}</span>
                            <div v-if="imagePreviews.image" class="img-preview">
                                <img :src="imagePreviews.image" alt="Preview">
                            </div>
                        </div>

                        <template v-if="editingPage?.slug === 'about'">
                            <div class="form-group">
                                <label>Gambar Tambahan 1 (Kiri Bawah)</label>
                                <input type="file" @change="handleFileChange($event, 'image_2')" accept="image/*">
                                <span class="error" v-if="form.errors.image_2">{{ form.errors.image_2 }}</span>
                                <div v-if="imagePreviews.image_2" class="img-preview">
                                    <img :src="imagePreviews.image_2" alt="Preview">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Gambar Tambahan 2 (Kanan Bawah)</label>
                                <input type="file" @change="handleFileChange($event, 'image_3')" accept="image/*">
                                <span class="error" v-if="form.errors.image_3">{{ form.errors.image_3 }}</span>
                                <div v-if="imagePreviews.image_3" class="img-preview">
                                    <img :src="imagePreviews.image_3" alt="Preview">
                                </div>
                            </div>
                        </template>

                        <div class="modal-footer">
                            <button type="button" class="btn-cancel" @click="closeModal">Batal</button>
                            <button type="submit" class="btn-save" :disabled="form.processing">
                                {{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
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
}

.card-header h2 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
}

.card-header p {
    color: #64748b;
    font-size: 0.9rem;
    margin-top: 0.25rem;
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

.font-medium {
    font-weight: 600;
    color: #334155;
}

.text-gray {
    color: #64748b;
    font-size: 0.9rem;
}

.text-right {
    text-align: right !important;
}

.badge {
    display: inline-block;
    padding: 0.35rem 0.75rem;
    background: #f1f5f9;
    color: #475569;
    border-radius: 99px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 1rem;
    background: #1A3D2B;
    color: white;
    font-size: 0.85rem;
    font-weight: 600;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-action:hover {
    background: #A3B899;
    color: #1A3D2B;
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
    max-width: 600px;
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

.form-group input[type="file"] {
    padding: 0.5rem 0;
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
