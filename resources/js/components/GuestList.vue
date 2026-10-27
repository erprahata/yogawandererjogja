<template>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Guest List & Presensi</h2>
                <p class="text-sm text-gray-500">Daftar peserta yang telah lunas (Paid).</p>
            </div>
            
            <div class="flex gap-3 w-full md:w-auto">
                <select v-model="selectedClass" @change="fetchGuests" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-teal-500 focus:border-teal-500 text-sm outline-none flex-grow">
                    <option value="" disabled>Pilih Kelas Yoga...</option>
                    <option v-for="cls in classes" :key="cls.id" :value="cls.id">{{ cls.name }} - {{ formatDate(cls.schedule) }}</option>
                </select>
                
                <button @click="exportToExcel" :disabled="!selectedClass" class="bg-green-600 hover:bg-green-700 disabled:bg-gray-300 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2 shadow-sm whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export Excel
                </button>
            </div>
        </div>

        <div class="border rounded-lg overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-3 text-sm font-semibold text-gray-600">Nama Peserta</th>
                        <th class="p-3 text-sm font-semibold text-gray-600">No. HP / WA</th>
                        <th class="p-3 text-sm font-semibold text-gray-600">Kode Tiket</th>
                        <th class="p-3 text-sm font-semibold text-gray-600 text-center">Kehadiran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr v-for="guest in guests" :key="guest.id" class="hover:bg-gray-50">
                        <td class="p-3 text-sm font-medium text-gray-800">{{ guest.user.name }}</td>
                        <td class="p-3 text-sm text-gray-600">{{ guest.user.phone_number }}</td>
                        <td class="p-3 text-sm font-mono text-gray-500">{{ guest.transaction_code }}</td>
                        <td class="p-3 text-center">
                            <span v-if="guest.is_attended" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Hadir</span>
                            <span v-else class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Belum Check-in</span>
                        </td>
                    </tr>
                    <tr v-if="guests.length === 0 && selectedClass">
                        <td colspan="4" class="p-6 text-center text-gray-500">Belum ada peserta terdaftar.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const classes = ref([]);
const selectedClass = ref('');
const guests = ref([]);

onMounted(async () => {
    const res = await axios.get('/api/classes/active');
    classes.value = res.data.data;
});

const fetchGuests = async () => {
    if (!selectedClass.value) return;
    try {
        const res = await axios.get(`/api/admin/classes/${selectedClass.value}/guests`);
        guests.value = res.data.data;
    } catch (error) {
        console.error("Gagal memuat data tamu", error);
    }
};

const exportToExcel = () => {
    if (!selectedClass.value) return;
    // Redirect langsung ke endpoint Laravel yang mengembalikan response header download file (maatwebsite/excel)
    window.location.href = `/api/admin/export/class/${selectedClass.value}`;
};

const formatDate = (date) => new Date(date).toLocaleDateString('id-ID', { month: 'short', day: 'numeric' });
</script>