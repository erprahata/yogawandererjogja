<template>
    <div class="min-h-screen bg-[#f8fafc] font-sans selection:bg-brand selection:text-white overflow-hidden">
        
        <!-- Hero Section (Cinematic Auto-Slider) -->
        <section class="relative h-screen flex flex-col items-center justify-center text-center overflow-hidden">
            <!-- Background Images dengan Ken Burns Effect -->
            <div class="absolute inset-0 z-0 bg-black">
                <div v-for="(slide, index) in heroSlides" :key="index"
                     class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                     :class="{ 'opacity-100': currentSlide === index, 'opacity-0': currentSlide !== index }">
                    <img :src="slide" alt="Yoga Background" 
                         class="w-full h-full object-cover object-center transform transition-transform ease-linear"
                         :class="{ 'scale-110 duration-[10000ms]': currentSlide === index, 'scale-100 duration-0': currentSlide !== index }" />
                    
                    <!-- Overlay Premium (Gradient Gelap ke Transparan) -->
                    <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-brand/20 to-[#0f3b40]/80 mix-blend-multiply"></div>
                </div>
            </div>

            <!-- Hero Content (Premium Transparent Glass Panel) -->
            <div class="animate-fade-in-up relative z-10 max-w-4xl w-full mx-6 p-[1px] rounded-[2rem] bg-gradient-to-br from-white/30 to-white/5 shadow-[0_8px_32px_0_rgba(0,0,0,0.4)]">
                <div class="bg-black/20 backdrop-blur-2xl rounded-[2rem] p-10 md:p-14 border border-white/20 flex flex-col items-center text-center">
                    
                    <!-- Tempat Logo Klien -->
                    <img src="/logo.png" alt="Logo Yoga Wanderer" class="h-20 md:h-28 w-auto mb-6 drop-shadow-lg object-contain transition-transform duration-500 hover:scale-105" onerror="this.style.display='none'" />
                    
                    <h1 class="text-4xl md:text-6xl font-extrabold mb-6 text-white tracking-wide drop-shadow-xl" style="font-family: 'Playfair Display', Georgia, serif;">
                        {{ cms.hero_title || 'Yoga Wanderer Jogja' }}
                    </h1>
                    
                    <p class="text-lg md:text-xl font-light text-gray-100 mb-10 max-w-2xl mx-auto leading-relaxed drop-shadow-md">
                        {{ cms.hero_subtitle || 'Hiruplah udara segar dan temukan keseimbangan batin melalui sesi yoga eksklusif di alam terbuka Yogyakarta.' }}
                    </p>
                    
                    <a href="#classes" class="group relative inline-flex items-center justify-center px-8 py-3.5 text-base font-bold text-white transition-all duration-300 bg-brand rounded-full overflow-hidden hover:scale-105 hover:shadow-[0_0_20px_rgba(32,111,120,0.5)]">
                        <span class="absolute w-0 h-0 transition-all duration-500 ease-out bg-white rounded-full group-hover:w-56 group-hover:h-56 opacity-10"></span>
                        <span class="relative">Jelajahi Kelas Eksklusif</span>
                        <svg class="w-5 h-5 ml-2 transition-transform duration-300 group-hover:translate-x-1 relative" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
            
            <!-- Scroll Indicator -->
            <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce flex flex-col items-center opacity-70">
                <span class="text-white text-xs tracking-widest uppercase mb-2 font-semibold">Scroll</span>
                <div class="w-[1px] h-12 bg-gradient-to-b from-white to-transparent"></div>
            </div>
        </section>

        <!-- Sisa Konten Halaman -->
        <div class="relative z-10 bg-yoga-pattern">
            <!-- Ornamen Ambient Glow -->
            <div class="absolute top-20 left-[-10%] w-[500px] h-[500px] bg-brand/10 rounded-full mix-blend-multiply filter blur-[100px] opacity-70 animate-float"></div>
            <div class="absolute bottom-20 right-[-10%] w-[400px] h-[400px] bg-[#d97706]/10 rounded-full mix-blend-multiply filter blur-[100px] opacity-70 animate-float" style="animation-delay: 2s;"></div>

            <!-- Katalog Kelas -->
            <section id="classes" class="relative py-24 px-6 lg:px-24 max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <span class="text-brand font-semibold tracking-widest uppercase text-sm">Pilih Perjalanan Anda</span>
                    <h2 class="text-4xl font-bold mt-2 text-gray-900" style="font-family: 'Playfair Display', Georgia, serif;">Jadwal Kelas Aktif</h2>
                    <div class="w-24 h-1 bg-brand mx-auto mt-6 rounded-full"></div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    <!-- Premium Glass Card -->
                    <div v-for="yogaClass in yogaClasses" :key="yogaClass.id" 
                         :class="['group bg-white rounded-3xl shadow-sm border-2 overflow-hidden flex flex-col transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl relative', 
                                  yogaClass.type === 'event' ? 'border-orange-100 hover:border-orange-500' : 'border-teal-50 hover:border-teal-600']">
                        
                        <div class="h-56 relative overflow-hidden bg-gray-100">
                            <img :src="yogaClass.image" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
                            
                            <!-- Label Tipe Dinamis -->
                            <div :class="['absolute top-4 left-4 px-4 py-1.5 rounded-full text-xs font-black shadow-lg text-white uppercase tracking-wider', 
                                          yogaClass.type === 'event' ? 'bg-orange-500' : 'bg-teal-600']">
                                {{ yogaClass.type === 'event' ? 'Event Spesial' : 'Kelas Rutin' }}
                            </div>
                            
                            <!-- Gradien & Kuota -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                            <div class="absolute bottom-4 left-4 flex items-center gap-2">
                                <span class="bg-white/20 backdrop-blur-md text-white text-xs font-bold px-3 py-1.5 rounded-full border border-white/30">
                                    Sisa {{ yogaClass.quota }} Kuota
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-8 flex-grow flex flex-col bg-white z-10 relative">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2" style="font-family: 'Playfair Display', serif;">{{ yogaClass.name }}</h3>
                            
                            <!-- Tanggal Dinamis -->
                            <div class="text-sm font-medium text-gray-600 flex items-center gap-2 mb-4">
                                <svg class="w-5 h-5 flex-shrink-0" :class="yogaClass.type === 'event' ? 'text-orange-500' : 'text-teal-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>{{ renderScheduleText(yogaClass) }}</span>
                            </div>

                            <p class="text-sm text-gray-500 mb-6 line-clamp-3 leading-relaxed">{{ yogaClass.description }}</p>
                            
                            <div class="mt-auto flex items-center justify-between border-t border-gray-100 pt-6">
                                <div class="flex flex-col">
                                    <span class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Investasi</span>
                                    <span class="text-xl font-black text-gray-900">Rp {{ formatPrice(yogaClass.price) }}</span>
                                </div>
                                <button @click="attemptCheckout(yogaClass)"
                                        :class="['font-bold py-2.5 px-6 rounded-xl transition', 
                                                yogaClass.type === 'event' ? 'bg-orange-50 text-orange-600 hover:bg-orange-500 hover:text-white' : 'bg-teal-50 text-teal-700 hover:bg-teal-600 hover:text-white']">
                                    Pesan Tiket
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sponsorship & Collabs -->
            <section class="relative py-24 px-6 lg:px-24 border-t border-gray-200/60 bg-white/40">
                <div class="max-w-5xl mx-auto text-center">
                    <h2 class="text-sm font-semibold text-gray-400 tracking-widest uppercase mb-8">Dipercaya Oleh & Mitra Kolaborasi</h2>
                    
                    <!-- Bagian Grid Sponsor di Landing Page -->
                    <div class="flex flex-wrap justify-center items-center gap-8 mb-16 grayscale opacity-70 hover:grayscale-0 hover:opacity-100 transition-all duration-500">
                        <div v-for="sponsor in sponsors" :key="sponsor.key" class="flex items-center justify-center h-16">
                            <img v-if="sponsor.type === 'image'" :src="sponsor.value" class="max-h-full max-w-[120px] object-contain">
                            <span v-else class="text-2xl font-bold text-gray-700 tracking-wider uppercase">{{ sponsor.value }}</span>
                        </div>
                    </div>

                    <div class="p-[1px] bg-gradient-to-br from-brand/30 to-brand/5 rounded-3xl max-w-2xl mx-auto shadow-xl">
                        <div class="p-10 bg-white rounded-3xl">
                            <h3 class="text-2xl font-bold text-gray-900 mb-4" style="font-family: 'Playfair Display', Georgia, serif;">Tertarik Menjadi Sponsor?</h3>
                            <p class="text-gray-500 mb-8 font-light">Jangkau komunitas wellness yang aktif dan jadilah bagian dari perjalanan menuju harmoni bersama kami.</p>
                            <a href="mailto:collab@yogawanderer.com" class="inline-block bg-white border-2 border-brand text-brand hover:bg-brand hover:text-white font-bold py-3.5 px-10 rounded-full transition-all duration-300 shadow-sm hover:shadow-lg">
                                {{ cms.sponsor_cta || 'Open for Sponsorship' }}
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Footer Premium -->
                    <footer class="relative py-8 px-6 lg:px-24 bg-white/60 backdrop-blur-md border-t border-gray-200/60">
                        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
                            <div class="text-sm text-gray-500 font-light">
                                &copy; {{ new Date().getFullYear() }} Yoga Wanderer Jogja. All rights reserved.
                            </div>
                            
                            <!-- RHT Labs Support Credit -->
                            <div class="text-sm text-gray-500 font-light flex items-center gap-1.5">
                                <span>Engineered & Supported by</span>
                                <a href="https://rhtlabs.my.id" target="_blank" rel="noopener noreferrer" class="font-bold text-brand tracking-wide hover:text-[#13494f] transition-all duration-300 relative group">
                                    RHT Labs
                                    <span class="absolute -bottom-1 left-0 w-0 h-[1.5px] bg-brand transition-all duration-300 group-hover:w-full"></span>
                                </a>
                            </div>  
                        </div>
                    </footer>
        </div>

        <checkout-form v-if="selectedClass" :yoga-class="selectedClass" @close="selectedClass = null" />
    </div>
    <!-- Modal Peringatan Login -->
    <div v-if="showAuthWarning" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="bg-white w-full max-w-sm rounded-3xl shadow-2xl overflow-hidden p-8 text-center relative">
            <button @click="showAuthWarning = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="w-20 h-20 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Akses Terbatas</h3>
            <p class="text-sm text-gray-500 mb-8">Untuk memudahkan pendataan presensi, Anda diwajibkan masuk atau membuat akun terlebih dahulu sebelum memesan tiket.</p>
            <div class="space-y-3">
                <router-link to="/login" class="block w-full bg-teal-700 hover:bg-teal-800 text-white font-bold py-3 px-4 rounded-xl transition">
                    Masuk / Daftar Sekarang
                </router-link>
                <button @click="showAuthWarning = false" class="block w-full text-sm font-medium text-gray-500 hover:text-gray-800 transition py-2">
                    Nanti Saja
                </button>
            </div>
        </div>
    </div>

</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import CheckoutForm from './Checkout.vue';

const router = useRouter();
const showAuthWarning = ref(false);

// 1. State di-reset menjadi kosong, menunggu data dari database
const cms = ref({});
const yogaClasses = ref([]);
const heroSlides = ref([]);
const currentSlide = ref(0);
let slideInterval;
const selectedClass = ref(null);

const sponsors = ref([]);

const fetchData = async () => {
    // 1. Eksekusi pemuatan CMS secara independen
    try {
        const cmsRes = await axios.get('/api/cms-content');
        if (cmsRes.data.data) {
            cms.value = cmsRes.data.data;
            
            const dynamicSlides = [];
            sponsors.value = [];
            
            for (const [key, val] of Object.entries(cms.value)) {
                if (key.startsWith('hero_image_') && val) dynamicSlides.push(val);
                if (key.startsWith('sponsor_logo_') && val) sponsors.value.push({ key, value: val, type: 'image' });
                if (key.startsWith('sponsor_text_') && val) sponsors.value.push({ key, value: val, type: 'text' });
            }
            
            heroSlides.value = dynamicSlides.length > 0 ? dynamicSlides : ['https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=1920'];
        }
    } catch (error) {
        console.error("Gagal memuat layout CMS:", error);
    }

    // 2. Eksekusi pemuatan Kelas secara independen
    try {
        const classRes = await axios.get('/api/classes/active');
        if (classRes.data.data) {
            yogaClasses.value = classRes.data.data;
        }
    } catch (error) {
        console.error("Gagal memuat jadwal kelas:", error);
    }
};

onMounted(() => {
    fetchData();
    
    // Auto-slide hanya berjalan jika ada gambar yang berhasil dimuat
    slideInterval = setInterval(() => {
        if (heroSlides.value.length > 0) {
            currentSlide.value = (currentSlide.value + 1) % heroSlides.value.length;
        }
    }, 6000);
});

onUnmounted(() => {
    clearInterval(slideInterval);
});

const attemptCheckout = (yogaClass) => {
    const token = localStorage.getItem('auth_token');
    if (!token) {
        showAuthWarning.value = true;
    } else {
        selectedClass.value = yogaClass;
    }
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('id-ID', { 
        weekday: 'long', day: 'numeric', month: 'long', hour: '2-digit', minute: '2-digit' 
    });
};

import { computed } from 'vue';

// Computed logic pemisah data
const regularClasses = computed(() => yogaClasses.value.filter(c => c.type === 'regular'));
const eventClasses = computed(() => yogaClasses.value.filter(c => c.type === 'event'));

// Helpers format
const translateDays = (daysArray) => {
    if (!daysArray || !daysArray.length) return '';
    const map = { Monday: 'Senin', Tuesday: 'Selasa', Wednesday: 'Rabu', Thursday: 'Kamis', Friday: 'Jumat', Saturday: 'Sabtu', Sunday: 'Minggu' };
    return daysArray.map(d => map[d]).join(', ');
};

const formatTime = (timeStr) => {
    if (!timeStr) return '';
    return timeStr.substring(0, 5); // Ubah 16:30:00 jadi 16:30
};

const renderScheduleText = (yogaClass) => {
    if (yogaClass.type === 'event' && yogaClass.schedule) {
        // Hapus huruf 'Z' di belakang string agar tidak ditambah 7 jam oleh JS
        const cleanDateStr = yogaClass.schedule.replace('Z', ''); 
        const date = new Date(cleanDateStr);
        
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const hours = date.getHours().toString().padStart(2, '0');
        const minutes = date.getMinutes().toString().padStart(2, '0');
        return `${days[date.getDay()]}, ${date.getDate()} ${months[date.getMonth()]} pukul ${hours}.${minutes} WIB`;
    } 
    else if (yogaClass.type === 'regular' && yogaClass.recurring_days) {
        const map = { Monday: 'Senin', Tuesday: 'Selasa', Wednesday: 'Rabu', Thursday: 'Kamis', Friday: 'Jumat', Saturday: 'Sabtu', Sunday: 'Minggu' };
        let daysArr = yogaClass.recurring_days;
        if (typeof daysArr === 'string') {
            try { daysArr = JSON.parse(daysArr); } catch(e) { daysArr = []; }
        }
        if (!Array.isArray(daysArr)) return 'Jadwal belum diatur';
        
        const dayStr = daysArr.map(d => map[d] || d).join(', ');
        const timeStr = yogaClass.start_time ? yogaClass.start_time.substring(0, 5).replace(':', '.') : '';
        return `${dayStr} pukul ${timeStr} WIB`;
    }
    return '-';
};

const formatPrice = (price) => {
    return Number(price).toLocaleString('id-ID');
};
</script>

<style scoped>
.bg-yoga-pattern {
    background-color: #f8fafc;
    /* Menggunakan SVG ter-encode agar lebih tajam dan ringan */
    background-image: url("data:image/svg+xml,%3Csvg width='40' height='69' viewBox='0 0 40 69' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23206f78' fill-opacity='0.05' fill-rule='evenodd'%3E%3Cpath d='M20 13l18 10.4v20.8L20 54.6 2 44.2V23.4L20 13zm0-2.3l-20 11.5v23.1l20 11.5 20-11.5V22.2L20 10.7zM0 23.1L20 11.6V0h-2v10.4L0 20.8v2.3zm0 21.9L20 56.6V69h-2V57.7L0 46.2v-1.2zm40-21.9L20 11.6V0h2v10.4l18 10.4v2.3zm0 21.9L20 56.6V69h2V57.7l18-11.5v-1.2z'/%3E%3C/g%3E%3C/svg%3E");
}

/* Animasi Custom Premium */
.animate-fade-in-up {
    animation: fadeInUp 1.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    opacity: 0;
    transform: translateY(30px);
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-float {
    animation: float 10s ease-in-out infinite;
}

@keyframes float {
    0% { transform: translateY(0px) translateX(0px) scale(1); }
    33% { transform: translateY(-30px) translateX(20px) scale(1.05); }
    66% { transform: translateY(20px) translateX(-20px) scale(0.95); }
    100% { transform: translateY(0px) translateX(0px) scale(1); }
}
</style>