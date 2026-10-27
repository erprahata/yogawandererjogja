<template>
    <div class="min-h-screen bg-[#f8fafc] font-sans selection:bg-brand selection:text-white flex items-center justify-center relative overflow-hidden">
        <!-- Ornamen Background Premium -->
        <div class="absolute inset-0 z-0 bg-black/5">
            <img src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=1920&auto=format&fit=crop" class="w-full h-full object-cover opacity-40 mix-blend-overlay" />
            <div class="absolute inset-0 bg-gradient-to-br from-brand/90 to-[#0f3b40]/90 mix-blend-multiply"></div>
        </div>
        
        <!-- Ambient Glow -->
        <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] bg-white/20 rounded-full mix-blend-overlay filter blur-[100px] animate-float"></div>

        <!-- Glass Panel Card -->
        <div class="relative z-10 w-full max-w-md mx-6 animate-fade-in-up">
            <div class="bg-white/10 backdrop-blur-2xl border border-white/20 rounded-[2rem] shadow-[0_8px_32px_0_rgba(0,0,0,0.3)] p-8 md:p-10">
                
                <!-- Header/Logo -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-white mb-2" style="font-family: 'Playfair Display', serif;">Yoga Wanderer</h2>
                    <p class="text-gray-200 text-sm font-light tracking-wide uppercase">{{ authModeText }}</p>
                </div>

                <!-- Form Login -->
                <form v-if="mode === 'login'" @submit.prevent="handleLogin" class="space-y-5">
                    <div>
                        <label class="block text-white text-sm font-medium mb-2">Email</label>
                        <input v-model="form.email" type="email" required class="w-full bg-white/20 border border-white/30 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-white/50 placeholder-gray-300 transition" placeholder="email@contoh.com">
                    </div>
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-white text-sm font-medium">Password</label>
                            <a @click.prevent="mode = 'forgot'" href="#" class="text-xs text-amber-300 hover:text-white transition">Lupa password?</a>
                        </div>
                        <input v-model="form.password" type="password" required class="w-full bg-white/20 border border-white/30 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-white/50 placeholder-gray-300 transition" placeholder="••••••••">
                    </div>
                    <button type="submit" class="w-full bg-white text-brand font-bold py-3.5 rounded-xl hover:bg-gray-100 transition shadow-lg mt-4">Masuk</button>
                    <p class="text-center text-sm text-gray-300 mt-6">Belum punya akun? <a @click.prevent="mode = 'register'" href="#" class="text-white font-bold hover:underline">Daftar sekarang</a></p>
                </form>

                <!-- Form Register -->
                <form v-if="mode === 'register'" @submit.prevent="handleRegister" class="space-y-5">
                    <div>
                        <label class="block text-white text-sm font-medium mb-2">Nama Lengkap</label>
                        <input v-model="form.name" type="text" required class="w-full bg-white/20 border border-white/30 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-white/50 placeholder-gray-300 transition" placeholder="Nama Anda">
                    </div>
                    <div>
                        <label class="block text-white text-sm font-medium mb-2">Email</label>
                        <input v-model="form.email" type="email" required class="w-full bg-white/20 border border-white/30 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-white/50 placeholder-gray-300 transition" placeholder="email@contoh.com">
                    </div>
                    <div>
                        <label class="block text-white text-sm font-medium mb-2">Password</label>
                        <input v-model="form.password" type="password" required class="w-full bg-white/20 border border-white/30 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-white/50 placeholder-gray-300 transition" placeholder="Minimal 8 karakter">
                    </div>
                    <button type="submit" class="w-full bg-white text-brand font-bold py-3.5 rounded-xl hover:bg-gray-100 transition shadow-lg mt-4">Daftar Akun</button>
                    <p class="text-center text-sm text-gray-300 mt-6">Sudah punya akun? <a @click.prevent="mode = 'login'" href="#" class="text-white font-bold hover:underline">Masuk di sini</a></p>
                </form>

                <!-- Form Forgot Password -->
                <form v-if="mode === 'forgot'" @submit.prevent="handleForgot" class="space-y-5">
                    <p class="text-sm text-gray-200 mb-4 text-center">Masukkan email Anda. Kami akan mengirimkan tautan untuk mereset password Anda.</p>
                    <div>
                        <label class="block text-white text-sm font-medium mb-2">Email Terdaftar</label>
                        <input v-model="form.email" type="email" required class="w-full bg-white/20 border border-white/30 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-white/50 placeholder-gray-300 transition" placeholder="email@contoh.com">
                    </div>
                    <button type="submit" class="w-full bg-amber-500 text-white font-bold py-3.5 rounded-xl hover:bg-amber-600 transition shadow-lg mt-4">Kirim Link Reset</button>
                    <p class="text-center text-sm text-gray-300 mt-6">Kembali ke <a @click.prevent="mode = 'login'" href="#" class="text-white font-bold hover:underline">Halaman Login</a></p>
                </form>

            </div>
            
            <div class="text-center mt-6 text-white/60 text-xs font-light">
                &copy; {{ new Date().getFullYear() }} Yoga Wanderer Jogja. System by RHT Labs.
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();
const mode = ref('login'); // 'login', 'register', 'forgot'

const form = ref({
    name: '',
    email: '',
    password: ''
});

const authModeText = computed(() => {
    if (mode.value === 'login') return 'Welcome Back';
    if (mode.value === 'register') return 'Join The Journey';
    return 'Reset Password';
});

const handleLogin = async () => {
    try {
        const response = await axios.post('/api/login', {
            email: form.value.email,
            password: form.value.password
        });
        
        // Simpan token (bisa menggunakan localStorage/Pinia)
        localStorage.setItem('auth_token', response.data.access_token);
        axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.access_token}`;
        
        // Redirect berdasarkan role
        if (response.data.user.role === 'admin') {
            router.push('/admin');
        } else {
            window.location.href = '/'; // Balik ke Landing Page
        }
    } catch (error) {
        alert('Login gagal. Periksa kembali email dan password Anda.');
    }
};

const handleRegister = async () => {
    alert('Fungsi register dipicu. Endpoint API register belum disiapkan di backend.');
};

const handleForgot = async () => {
    alert('Link reset password fiktif telah dikirim ke ' + form.value.email);
    mode.value = 'login';
};
</script>

<style scoped>
.animate-fade-in-up {
    animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-float {
    animation: float 10s ease-in-out infinite;
}
@keyframes float {
    0%, 100% { transform: translateY(0) scale(1); }
    50% { transform: translateY(-20px) scale(1.05); }
}
</style>