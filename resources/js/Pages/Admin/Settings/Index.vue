<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    settings: Object
});

// Flat settings to bind to form
const initialData = {};
Object.values(props.settings).forEach(group => {
    group.forEach(s => {
        initialData[s.id] = s.value;
    });
});

const form = useForm({
    settings: initialData
});

const submit = () => {
    form.put(route('admin.settings.update'), {
        preserveScroll: true
    });
};
</script>

<template>
    <Head title="Pengaturan Umum" />
    <AdminLayout>
        <template #header>Pengaturan Umum</template>
        
        <div class="settings-container">
            <form @submit.prevent="submit" class="admin-form">
                <div v-for="(group, groupName) in settings" :key="groupName" class="settings-group card">
                    <div class="card-header">
                        <h2>{{ groupName.charAt(0).toUpperCase() + groupName.slice(1) }}</h2>
                    </div>
                    <div class="card-body">
                        <div v-for="setting in group" :key="setting.id" class="form-group">
                            <label>{{ setting.key.split('_').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' ') }}</label>
                            <input v-if="setting.key !== 'village_description'" type="text" v-model="form.settings[setting.id]">
                            <textarea v-else v-model="form.settings[setting.id]" rows="4"></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save" :disabled="form.processing">
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Semua Pengaturan' }}
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<style scoped>
.settings-container { max-width: 800px; }
.card { background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 2rem; }
.card-header { padding: 1.2rem 2rem; border-bottom: 1px solid #e2e8f0; background: #f8fafc; }
.card-header h2 { font-size: 1.1rem; font-weight: 700; color: #1e293b; }
.card-body { padding: 2rem; }
.form-group { margin-bottom: 1.5rem; display: flex; flex-direction: column; gap: 0.5rem; }
.form-group label { font-weight: 600; color: #475569; font-size: 0.9rem; }
.form-group input, .form-group textarea { padding: 0.8rem; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit; }
.form-actions { position: sticky; bottom: 2rem; background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 -4px 20px rgba(0,0,0,0.1); display: flex; justify-content: flex-end; }
.btn-save { background: #1A3D2B; color: white; padding: 1rem 3rem; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; transition: transform 0.2s; }
.btn-save:hover { transform: scale(1.02); }
</style>
