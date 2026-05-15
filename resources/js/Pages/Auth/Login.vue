<script setup>
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login.attempt'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Admin Login" />

    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-header">
                <img src="/img/logo.png" alt="Logo" class="login-logo" />
                <h1>Desa Pardomuan</h1>
                <p>Silakan masuk ke panel admin</p>
            </div>

            <form @submit.prevent="submit" class="login-form">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input 
                        id="email" 
                        type="email" 
                        v-model="form.email" 
                        required 
                        autofocus 
                        placeholder="admin@example.com"
                        :class="{'has-error': form.errors.email}"
                    >
                    <span class="error-msg" v-if="form.errors.email">{{ form.errors.email }}</span>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input 
                        id="password" 
                        type="password" 
                        v-model="form.password" 
                        required 
                        placeholder="••••••••"
                    >
                    <span class="error-msg" v-if="form.errors.password">{{ form.errors.password }}</span>
                </div>

                <div class="form-group-checkbox">
                    <label>
                        <input type="checkbox" v-model="form.remember">
                        <span>Ingat Saya</span>
                    </label>
                </div>

                <button type="submit" :disabled="form.processing" class="login-btn">
                    <span v-if="form.processing">Memproses...</span>
                    <span v-else>Masuk ke Panel</span>
                </button>
            </form>
        </div>
        
        <div class="login-bg-overlay"></div>
    </div>
</template>

<style scoped>
.login-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: url('https://images.unsplash.com/photo-1596402184320-417e7178b2cd?w=1600&q=80') center/cover no-repeat;
    position: relative;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.login-bg-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(26,61,43,0.9) 0%, rgba(13,31,22,0.95) 100%);
    z-index: 1;
}

.login-container {
    position: relative;
    z-index: 2;
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    padding: 3rem 2.5rem;
    border-radius: 24px;
    width: 100%;
    max-width: 420px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    color: white;
}

.login-header {
    text-align: center;
    margin-bottom: 2.5rem;
}

.login-logo {
    width: 72px;
    height: 72px;
    object-fit: contain;
    margin: 0 auto 1.5rem;
    filter: drop-shadow(0 4px 12px rgba(0,0,0,0.15));
}

.login-header h1 {
    font-family: 'Lora', serif;
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: #fff;
}

.login-header p {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.6);
}

.form-group {
    margin-bottom: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group label {
    font-size: 0.85rem;
    font-weight: 500;
    color: rgba(255, 255, 255, 0.9);
}

.form-group input {
    background: rgba(255, 255, 255, 0.06);
    border: 1px solid rgba(255, 255, 255, 0.15);
    padding: 0.85rem 1.2rem;
    border-radius: 12px;
    color: white;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-group input::placeholder {
    color: rgba(255, 255, 255, 0.3);
}

.form-group input:focus {
    outline: none;
    border-color: #A3B899; /* green-light */
    background: rgba(255, 255, 255, 0.1);
    box-shadow: 0 0 0 4px rgba(163, 184, 153, 0.15);
}

.form-group input.has-error {
    border-color: #ef4444;
}

.error-msg {
    color: #fca5a5;
    font-size: 0.8rem;
    margin-top: 0.2rem;
}

.form-group-checkbox {
    margin-bottom: 2rem;
}

.form-group-checkbox label {
    display: flex;
    align-items: center;
    gap: 0.7rem;
    cursor: pointer;
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.7);
}

.form-group-checkbox input[type="checkbox"] {
    appearance: none;
    width: 18px;
    height: 18px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 4px;
    background: transparent;
    cursor: pointer;
    position: relative;
    transition: all 0.2s;
}

.form-group-checkbox input[type="checkbox"]:checked {
    background: #A3B899;
    border-color: #A3B899;
}

.form-group-checkbox input[type="checkbox"]:checked::after {
    content: '';
    position: absolute;
    left: 5px;
    top: 2px;
    width: 5px;
    height: 10px;
    border: solid #1A3D2B;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

.login-btn {
    width: 100%;
    background: #A3B899;
    color: #0f241a;
    padding: 1rem;
    border-radius: 12px;
    font-weight: 700;
    font-size: 1rem;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    justify-content: center;
    align-items: center;
}

.login-btn:hover:not(:disabled) {
    background: #fff;
    transform: translateY(-2px);
}

.login-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

/* Add some subtle animation on load */
.login-container {
    animation: slideUpFade 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes slideUpFade {
    0% { opacity: 0; transform: translateY(30px); }
    100% { opacity: 1; transform: translateY(0); }
}
</style>
