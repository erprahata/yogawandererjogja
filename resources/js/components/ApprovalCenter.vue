<template>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Antrean Verifikasi (Approval Center)</h2>
            <button @click="fetchPending" class="text-teal-600 hover:text-teal-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-sm uppercase tracking-wider">
                        <th class="p-4 font-semibold">No. Transaksi</th>
                        <th class="p-4 font-semibold">Pelanggan</th>
                        <th class="p-4 font-semibold">Kelas Yoga</th>
                        <th class="p-4 font-semibold">Nominal</th>
                        <th class="p-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr v-for="tx in transactions" :key="tx.id" class="hover:bg-gray-50 transition">
                        <td class="p-4 font-mono text-sm text-gray-700">{{ tx.transaction_code }}</td>
                        <td class="p-4 text-sm text-gray-800">{{ tx.user.name }}<br><span class="text-xs text-gray-500">{{ tx.user.phone_number }}</span></td>
                        <td class="p-4 text-sm text-gray-800">{{ tx.yoga_class.name }}</td>
                        <td class="p-4 text-sm font-bold text-amber-600">Rp {{ Number(tx.yoga_class.price).toLocaleString('id-ID') }}</td>
                        <td class="p-4 text-center">
                            <button @click="verifyPayment(tx.id)" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                                Verifikasi
                            </button>
                        </td>
                    </tr>
                    <tr v-if="transactions.length === 0">
                        <td colspan="5" class="p-8 text-center text-gray-500">Tidak ada antrean verifikasi saat ini.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const transactions = ref([]);

const fetchPending = async () => {
    try {
        // Asumsi endpoint mengembalikan transaksi berstatus 'pending' beserta relasi user & yoga_class
        const response = await axios.get('/api/admin/transactions/pending');
        transactions.value = response.data.data;
    } catch (error) {
        console.error("Gagal memuat data", error);
    }
};

const verifyPayment = async (id) => {
    if (!confirm('Apakah Anda yakin dana sudah masuk dan ingin memverifikasi transaksi ini?')) return;
    
    try {
        await axios.post(`/api/admin/transactions/${id}/verify`);
        transactions.value = transactions.value.filter(tx => tx.id !== id);
        alert('Transaksi berhasil diverifikasi. E-Ticket diterbitkan.');
    } catch (error) {
        alert(error.response?.data?.message || 'Terjadi kesalahan.');
    }
};

onMounted(fetchPending);
</script>