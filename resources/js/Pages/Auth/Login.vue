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
    padding: 1.5rem;
}

.login-bg-overlay {
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at center, rgba(26,61,43,0.85) 0%, rgba(13,31,22,0.98) 100%);
    z-index: 1;
}

.login-container {
    position: relative;
    z-index: 2;
    background: rgba(255, 255, 255, 0.03);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    padding: 1.8rem 1.5rem;
    border-radius: 16px;
    width: 100%;
    max-width: 320px; /* Even smaller */
    box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.5);
    color: white;
}

.login-header {
    text-align: center;
    margin-bottom: 1.5rem;
}

.login-logo {
    width: 48px; /* Even smaller */
    height: 48px;
    object-fit: contain;
    margin: 0 auto 1rem;
    filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));
}

.login-header h1 {
    font-family: 'Lora', serif;
    font-size: 1.25rem; /* Even smaller */
    font-weight: 700;
    margin-bottom: 0.25rem;
    color: #fff;
    letter-spacing: -0.01em;
}

.login-header p {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.5);
}

.login-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
}

.form-group label {
    font-size: 0.7rem;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.7);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.form-group input {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    padding: 0.6rem 0.8rem; /* Slimmer inputs */
    border-radius: 8px;
    color: white;
    font-size: 0.85rem;
    transition: all 0.2s ease;
}

.form-group input::placeholder {
    color: rgba(255, 255, 255, 0.2);
}

.form-group input:focus {
    outline: none;
    border-color: #A3B899;
    background: rgba(255, 255, 255, 0.08);
    box-shadow: 0 0 0 4px rgba(163, 184, 153, 0.1);
}

.form-group input.has-error {
    border-color: #f87171;
}

.error-msg {
    color: #f87171;
    font-size: 0.75rem;
    margin-top: 0.2rem;
}

.form-group-checkbox {
    margin-top: 0.2rem;
}

.form-group-checkbox label {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    cursor: pointer;
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.6);
    user-select: none;
}

.form-group-checkbox input[type="checkbox"] {
    appearance: none;
    width: 16px;
    height: 16px;
    border: 1px solid rgba(255, 255, 255, 0.2);
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
    left: 4.5px;
    top: 1.5px;
    width: 4px;
    height: 8px;
    border: solid #0d1f16;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

.login-btn {
    width: 100%;
    background: #A3B899;
    color: #0d1f16;
    padding: 0.7rem; /* Slimmer button */
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.85rem;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 0.4rem;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 4px 10px rgba(163, 184, 153, 0.15);
}

.login-btn:hover:not(:disabled) {
    background: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 255, 255, 0.2);
}

.login-btn:active:not(:disabled) {
    transform: translateY(0);
}

.login-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Mobile Adjustments */
@media (max-width: 480px) {
    .login-container {
        padding: 2rem 1.5rem;
        max-width: 100%;
    }
    
    .login-header h1 {
        font-size: 1.35rem;
    }
}

/* Subtle animation */
.login-container {
    animation: slideUpFade 0.7s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes slideUpFade {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}
</style>
