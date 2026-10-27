<template>
    <div class="min-h-screen bg-gray-50 py-12 px-4 font-sans">
        <div class="max-w-md mx-auto">
            
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Tiket Saya</h1>
                <router-link to="/" class="text-sm font-medium text-teal-600 hover:underline">Kembali ke Beranda</router-link>
            </div>

            <!-- Kartu Tiket (Boarding Pass Style) -->
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden relative">
                
                <!-- Lingkaran Potongan Tiket (Kiri Kanan) -->
                <div class="absolute top-[65%] -left-4 w-8 h-8 bg-gray-50 rounded-full border-r border-gray-100"></div>
                <div class="absolute top-[65%] -right-4 w-8 h-8 bg-gray-50 rounded-full border-l border-gray-100"></div>

                <!-- Bagian Atas: Info Kelas -->
                <div class="p-8 pb-10 bg-gradient-to-br from-teal-800 to-teal-900 text-white">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-bold tracking-wider uppercase backdrop-blur-sm">Yoga Reguler</span>
                        </div>
                        <span class="px-3 py-1 bg-amber-500 text-white rounded-md text-xs font-bold shadow-sm">
                            MENUNGGU VERIFIKASI
                        </span>
                    </div>
                    
                    <h2 class="text-2xl font-bold font-serif mb-1">Sunrise Vinyasa Flow</h2>
                    <p class="text-teal-100 text-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Candi Prambanan Park
                    </p>
                </div>

                <!-- Bagian Tengah: Detail Waktu & Pemesan -->
                <div class="px-8 py-6 bg-white relative">
                    <!-- Garis Putus-putus Pemisah -->
                    <div class="absolute top-0 left-6 right-6 border-t-2 border-dashed border-gray-200"></div>
                    
                    <div class="grid grid-cols-2 gap-y-6 gap-x-4 mt-2">
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Tanggal</p>
                            <p class="text-sm font-bold text-gray-900">Minggu, 18 Okt 2026</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Waktu</p>
                            <p class="text-sm font-bold text-gray-900">06:00 WIB</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Pemesan</p>
                            <p class="text-sm font-bold text-gray-900">Budi Santoso</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">No. Transaksi</p>
                            <p class="text-sm font-bold text-teal-700">YWJ-20260927-ZWUHG</p>
                        </div>
                    </div>
                </div>

                <!-- Bagian Bawah: QR Code Presensi -->
                <div class="p-8 bg-gray-50 flex flex-col items-center justify-center border-t border-gray-100">
                    <p class="text-xs text-gray-500 mb-4 text-center">Tunjukkan QR Code ini kepada Coach di lokasi untuk presensi.</p>
                    
                    <!-- Placeholder Barcode/QR Tiket -->
                    <div class="w-32 h-32 bg-white p-2 border border-gray-200 rounded-xl shadow-sm mb-2">
                        <!-- Nanti diganti dengan komponen QRCode generator berdasarkan ID Transaksi -->
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=YWJ-20260927-ZWUHG" alt="QR Code Tiket" class="w-full h-full opacity-50 grayscale">
                    </div>
                    <span class="text-[10px] font-mono text-gray-400">Scan at Gate</span>
                </div>
                
            </div>
            
            <button class="mt-6 w-full bg-white border border-gray-200 text-gray-700 font-bold py-3.5 rounded-xl shadow-sm hover:bg-gray-50 transition flex justify-center items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Simpan Tangkapan Layar (Screenshot)
            </button>

        </div>
    </div>
</template>