<template>
    <div class="flex h-screen bg-gray-50 font-sans">
        <!-- Sidebar -->
        <aside class="w-64 bg-teal-900 text-white flex flex-col shadow-xl">
            <div class="p-6 text-center border-b border-teal-800">
                <h1 class="text-2xl font-bold tracking-tight">Coach Panel</h1>
                <p class="text-teal-300 text-sm mt-1">Yoga Wanderer Jogja</p>
            </div>
            <nav class="flex-grow p-4 space-y-2">
                <router-link :to="{ name: 'overview' }" exact-active-class="bg-teal-800 font-bold border-l-4 border-amber-400" class="block py-2.5 px-4 rounded transition hover:bg-teal-800 text-sm">Dashboard Overview</router-link>
                <router-link :to="{ name: 'approval' }" exact-active-class="bg-teal-800 font-bold border-l-4 border-amber-400" class="block py-2.5 px-4 rounded transition hover:bg-teal-800 text-sm">Approval Center</router-link>
                <router-link :to="{ name: 'guests' }" exact-active-class="bg-teal-800 font-bold border-l-4 border-amber-400" class="block py-2.5 px-4 rounded transition hover:bg-teal-800 text-sm">Guest List & Presensi</router-link>
                <router-link :to="{ name: 'tickets' }" exact-active-class="bg-teal-800 font-bold border-l-4 border-amber-400" class="block py-2.5 px-4 rounded transition hover:bg-teal-800 text-sm">Manajemen Tiket</router-link>
                <router-link :to="{ name: 'cms' }" exact-active-class="bg-teal-800 font-bold border-l-4 border-amber-400" class="block py-2.5 px-4 rounded transition hover:bg-teal-800 text-sm">Content Manager</router-link>
            </nav>
            <div class="p-4 border-t border-teal-800">
                <a href="/" class="block text-center py-2 text-sm text-teal-300 hover:text-white transition">Lihat Website &rarr;</a>
            </div>
        </aside>

        <!-- Main Content Area yang dinamis berubah sesuai klik menu -->
        <main class="flex-1 overflow-y-auto p-8">
            <header class="flex justify-between items-center mb-8 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 capitalize">{{ $route.name }}</h2>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-600 font-medium">Coach Admin</span>
                    <button @click="handleLogout" class="px-4 py-2 bg-red-50 text-red-600 hover:bg-red-100 font-bold rounded-lg transition text-sm">
                        Logout
                    </button>
                </div>
            </header>

            <!-- Komponen Halaman akan dimuat di dalam sini -->
            <router-view></router-view>
        </main>
    </div>
</template>

<script setup>
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();

const handleLogout = async () => {
    try {
        // Beri tahu backend untuk menghapus token aktif di database
        await axios.post('/api/logout', {}, {
            headers: { 'Authorization': `Bearer ${localStorage.getItem('auth_token')}` }
        });
    } catch (error) {
        console.warn('Sesi di backend sudah kedaluwarsa.');
    } finally {
        // WAJIB: Hapus token dari browser dan reset header Axios
        localStorage.removeItem('auth_token');
        delete window.axios.defaults.headers.common['Authorization'];
        
        // Arahkan kembali ke halaman login
        router.push('/login');
    }
};
</script>