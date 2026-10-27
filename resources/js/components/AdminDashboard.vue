<template>
    <div class="space-y-6">
        <!-- Top Metrics Cards Premium -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Card 1: Total Pendapatan (TIDAK BERUBAH) -->
            <div class="bg-gradient-to-br from-teal-700 to-teal-900 p-6 rounded-2xl shadow-lg text-white relative overflow-hidden transition-transform hover:-translate-y-1 duration-300">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                <p class="text-teal-100 text-sm font-medium mb-1 relative z-10">Total Pendapatan</p>
                <h3 class="text-3xl font-bold relative z-10">{{ metrics.totalPendapatan }}</h3>
                <div class="mt-4 flex items-center text-xs text-teal-200 bg-white/10 w-max px-2.5 py-1.5 rounded-full relative z-10 border border-teal-500/30">
                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    {{ metrics.pertumbuhanPendapatan }} dari bulan lalu
                </div>
            </div>

            <!-- Card 2: Tiket Terjual -->
            <div class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden transition-all hover:shadow-md hover:-translate-y-1 duration-300">
                <!-- Ornament Blur Halus di pojok kanan bawah -->
                <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-amber-50 rounded-full blur-2xl group-hover:bg-amber-100 transition-colors duration-500"></div>
                
                <div class="flex justify-between items-start relative z-10">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Tiket Terjual</p>
                        <!-- Ukuran font disamakan menjadi text-3xl -->
                        <h3 class="text-3xl font-bold text-gray-800">{{ metrics.tiketTerjual }}</h3>
                        <!-- Badge status tambahan -->
                        <div class="mt-4 flex items-center text-xs text-amber-600 bg-amber-50 w-max px-2.5 py-1.5 rounded-full border border-amber-100">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Total bulan ini
                        </div>
                    </div>
                    <div class="p-3 bg-amber-50 text-amber-600 rounded-xl shadow-inner border border-amber-100/50 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Card 3: Menunggu Verifikasi -->
            <div class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden transition-all hover:shadow-md hover:-translate-y-1 duration-300">
                <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-red-50 rounded-full blur-2xl group-hover:bg-red-100 transition-colors duration-500"></div>
                
                <div class="flex justify-between items-start relative z-10">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Menunggu Verifikasi</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ metrics.menungguVerifikasi }}</h3>
                        <div class="mt-4 flex items-center text-xs text-red-600 bg-red-50 w-max px-2.5 py-1.5 rounded-full border border-red-100">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span v-if="metrics.menungguVerifikasi > 0">Butuh tindakan</span>
                            <span v-else>Semua beres</span>
                        </div>
                    </div>
                    <div class="p-3 bg-red-50 text-red-600 rounded-xl shadow-inner border border-red-100/50 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Card 4: Kelas Aktif -->
            <div class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden transition-all hover:shadow-md hover:-translate-y-1 duration-300">
                <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-blue-50 rounded-full blur-2xl group-hover:bg-blue-100 transition-colors duration-500"></div>
                
                <div class="flex justify-between items-start relative z-10">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Kelas Aktif</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ metrics.kelasAktif }}</h3>
                        <div class="mt-4 flex items-center text-xs text-blue-600 bg-blue-50 w-max px-2.5 py-1.5 rounded-full border border-blue-100">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Jadwal berjalan
                        </div>
                    </div>
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-xl shadow-inner border border-blue-100/50 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Dashboard Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Chart Section (Lebar 2 Kolom) -->
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Tren Penjualan (30 Hari)</h3>
                    <select class="text-sm border-gray-200 rounded-lg text-gray-600 focus:ring-teal-500" v-model="chartFilter" @change="fetchDashboardData">
                        <option value="this_month">Bulan Ini</option>
                        <option value="last_month">Bulan Lalu</option>
                    </select>
                </div>
                <!-- V-if ditambahkan untuk menunggu data series terisi sebelum render grafik -->
                <apexchart v-if="series[0].data.length > 0" type="area" height="320" :options="chartOptions" :series="series"></apexchart>
                <div v-else class="h-[320px] flex items-center justify-center text-gray-400">Memuat data grafik...</div>
            </div>

            <!-- Jadwal Terdekat Section (Lebar 1 Kolom) -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col h-full">
                <div class="flex justify-between items-end mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Kelas Mendatang</h3>
                        <!-- Tanggal Real-time -->
                        <p class="text-sm text-gray-500 mt-1">{{ todayDate }}</p>
                    </div>
                    <!-- Badge Status -->
                    <span class="flex items-center gap-1.5 bg-teal-50 text-teal-700 text-xs px-2.5 py-1 rounded-full font-semibold border border-teal-100">
                        <span class="w-1.5 h-1.5 bg-teal-500 rounded-full animate-pulse"></span>
                        Live
                    </span>
                </div>
                
                <!-- Pembungkus untuk kondisi kelas -->    
                <div class="space-y-4 flex-grow">
                    <!-- Skeleton Loader Premium -->
                    <div v-if="isLoading">
                        <div v-for="i in 3" :key="i" class="flex gap-4 items-center p-3 animate-pulse">
                            <div class="bg-gray-200 h-16 w-16 rounded-xl"></div>
                            <div class="flex-1 space-y-2">
                                <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                                <div class="h-3 bg-gray-200 rounded w-1/2"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div v-else-if="upcomingClasses.length === 0" class="flex flex-col items-center justify-center py-8 text-center">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-3 text-gray-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <p class="text-sm font-medium text-gray-800">Belum Ada Jadwal</p>
                        <p class="text-xs text-gray-500 mt-1">Jadwal kelas akan muncul di sini.</p>
                    </div>
                    
                    <!-- Looping data dinamis menggunakan v-for -->
                    <div v-else v-for="kelas in upcomingClasses" :key="kelas.id" class="flex gap-4 items-center p-3 hover:bg-gray-50 rounded-xl transition cursor-pointer border border-transparent hover:border-gray-100">
                        <div class="bg-teal-50 text-teal-700 font-bold p-3 rounded-xl text-center min-w-[60px]">
                            <div class="text-sm">{{ kelas.month }}</div>
                            <div class="text-xl">{{ kelas.date }}</div>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-sm">{{ kelas.title }}</h4>
                            <p class="text-xs text-gray-500 mt-1">{{ kelas.quota }} Kuota • {{ kelas.time }} WIB</p>
                        </div>
                    </div>
                </div>

                <router-link :to="{ name: 'tickets' }" class="block text-center text-sm text-teal-600 font-bold mt-6 hover:underline">Kelola Semua Kelas &rarr;</router-link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import VueApexCharts from 'vue3-apexcharts';

const apexchart = VueApexCharts;
const isLoading = ref(true);
const chartFilter = ref('this_month');

// Membuat tanggal real-time format Indonesia
const todayDate = ref(new Intl.DateTimeFormat('id-ID', {
    weekday: 'long', 
    day: 'numeric', 
    month: 'long', 
    year: 'numeric'
}).format(new Date()));

// State untuk menyimpan data dinamis
const metrics = ref({
    totalPendapatan: 'Rp 0',
    pertumbuhanPendapatan: '+0%',
    tiketTerjual: 0,
    menungguVerifikasi: 0,
    kelasAktif: 0
});

const upcomingClasses = ref([]);

// State default grafik, namun datanya dikosongkan terlebih dahulu
const series = ref([{ name: 'Tiket Terjual', data: [] }]);
const chartOptions = ref({
    chart: { type: 'area', fontFamily: 'inherit', toolbar: { show: false }, parentHeightOffset: 0 },
    colors: ['#0f766e'],
    fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 90, 100] } },
    dataLabels: { enabled: false },
    stroke: { curve: 'smooth', width: 3 },
    grid: { borderColor: '#f3f4f6', strokeDashArray: 4, yaxis: { lines: { show: true } } },
    xaxis: { categories: [], axisBorder: { show: false }, axisTicks: { show: false } }
});

// Fungsi untuk mengambil data dari backend
const fetchDashboardData = async () => {
    isLoading.value = true;
    try {
        const token = localStorage.getItem('auth_token');
        // Endpoint ini disesuaikan dengan API Anda nanti
        const response = await axios.get(`/api/admin/dashboard?filter=${chartFilter.value}`, {
            headers: { 'Authorization': `Bearer ${token}` }
        });
        
        const data = response.data;
        
        // Memasukkan respons backend ke State
        metrics.value = data.metrics;
        upcomingClasses.value = data.upcomingClasses;
        
        // Memperbarui grafik dengan data baru
        series.value = [{ name: 'Tiket Terjual', data: data.chart.series }];
        chartOptions.value = {
            ...chartOptions.value,
            xaxis: {
                ...chartOptions.value.xaxis,
                categories: data.chart.categories
            }
        };
        
    } catch (error) {
        console.error('Gagal mengambil data dashboard:', error);
    } finally {
        isLoading.value = false;
    }
};

// Jalankan fetch saat komponen dimuat pertama kali
onMounted(() => {
    fetchDashboardData();
});
</script>