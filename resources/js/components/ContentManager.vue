<template>
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
        
        <!-- BAGIAN KIRI: Form Editor CMS -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Manajemen Konten Website (CMS)</h2>
                <button @click="saveContent" :disabled="isSaving" class="bg-teal-700 hover:bg-teal-800 text-white px-5 py-2 rounded-lg font-bold transition shadow-sm text-sm disabled:opacity-50">
                    {{ isSaving ? 'Menyimpan...' : 'Simpan Perubahan' }}
                </button>
            </div>
            
            <div class="space-y-6">
                <!-- Editor Hero Section -->
                <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
                    <h3 class="font-bold text-gray-700 mb-4 border-b pb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Hero Section
                    </h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Utama (Headline)</label>
                        <input v-model="form.hero_title" type="text" class="w-full border border-gray-300 rounded-xl p-2.5 focus:ring-teal-500 focus:border-teal-500 text-sm">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sub-judul (Deskripsi)</label>
                        <textarea v-model="form.hero_subtitle" rows="3" class="w-full border border-gray-300 rounded-xl p-2.5 focus:ring-teal-500 focus:border-teal-500 text-sm"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Background Slider (Gambar Utama)</label>
                        <div class="flex flex-wrap gap-3 mb-3">
                            <!-- List Gambar yang sudah ada -->
                            <div v-for="(img, idx) in heroImages" :key="idx" class="relative w-24 h-16 rounded-lg overflow-hidden border-2 border-gray-200 group">
                                <img :src="img.url" class="w-full h-full object-cover">
                                <button @click="removeHeroImage(idx)" class="absolute inset-0 bg-red-500/80 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition">Hapus</button>
                            </div>
                        </div>
                        <input type="file" @change="uploadHeroImage" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 transition">
                    </div>
                </div>

                <!-- Editor Sponsorship -->
                <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
                    <h3 class="font-bold text-gray-700 mb-4 border-b pb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Sponsorship & Mitra
                    </h3>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Teks Tombol Kemitraan (CTA)</label>
                        <input v-model="form.sponsor_cta" type="text" class="w-full border border-gray-300 rounded-xl p-2.5 focus:ring-teal-500 focus:border-teal-500 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Daftar Sponsor (Klik untuk Lepas)</label>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span v-for="(sponsor, index) in sponsors" :key="sponsor.key" @click="removeSponsor(index)" class="px-3 py-1 bg-white border border-gray-300 rounded-full text-xs font-bold text-gray-600 cursor-pointer hover:bg-red-50 hover:text-red-600 transition flex items-center gap-2">
                                <img v-if="sponsor.type === 'image'" :src="sponsor.value" class="h-4 w-auto inline-block">
                                <span v-else>{{ sponsor.value }}</span>
                                &times;
                            </span>
                        </div>
                        
                        <!-- Input 1: Logo -->
                        <div class="mb-3 border-b border-gray-200 pb-3">
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Upload Logo Sponsor</label>
                            <input type="file" @change="uploadSponsorLogo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 transition">
                        </div>
                        
                        <!-- Input 2: Teks -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Atau Tambahkan Teks Merek (Tanpa Logo)</label>
                            <div class="flex gap-2">
                                <input v-model="newSponsorName" type="text" placeholder="Nama Brand/Sponsor" class="flex-1 border border-gray-300 rounded-lg p-2 text-sm focus:ring-teal-500">
                                <button @click="addTextSponsor" type="button" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-700">Tambah</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BAGIAN KANAN: Live Preview -->
        <div class="bg-gray-900 rounded-2xl shadow-xl overflow-hidden hidden xl:block relative h-[80vh]">
            <div class="absolute top-0 inset-x-0 h-10 bg-gray-800 flex items-center px-4 gap-2 z-20">
                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                <span class="ml-4 text-xs font-mono text-gray-400">Live Preview: Landing Page</span>
            </div>
            
            <!-- Scaling Container untuk memuat seluruh web di ruang sempit -->
            <div class="w-[1440px] h-[1080px] bg-white transform scale-[0.45] origin-top-left mt-10 pointer-events-none select-none overflow-hidden">
                <!-- Simulasi Hero Section -->
                <section class="relative h-[800px] flex flex-col items-center justify-center text-center">
                    <img :src="heroImages[0]?.url || 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=1920'" class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/40"></div>
                    
                    <div class="relative z-10 max-w-4xl w-full bg-white/20 backdrop-blur-xl border border-white/30 rounded-3xl p-12">
                        <h1 class="text-6xl font-extrabold mb-4 text-white font-serif">{{ form.hero_title }}</h1>
                        <p class="text-xl text-white mb-8">{{ form.hero_subtitle }}</p>
                        <span class="bg-[#206F78] text-white py-3 px-8 rounded-full">Jelajahi Kelas</span>
                    </div>
                </section>
                
                <!-- Simulasi Sponsor -->
                <section class="py-24 text-center">
                    <h2 class="text-3xl text-gray-400 uppercase font-bold mb-8">Sponsor Aktif</h2>
                    <div class="flex flex-wrap justify-center items-center gap-6 mb-12">
                        <!-- Perbaikan pemanggilan data sponsor -->
                        <div v-for="sponsor in sponsors" :key="sponsor.key" class="flex items-center justify-center">
                            <img v-if="sponsor.type === 'image'" :src="sponsor.value" class="h-16 w-auto object-contain">
                            <span v-else class="text-4xl font-black text-gray-300 uppercase">{{ sponsor.value }}</span>
                        </div>
                    </div>
                    <span class="border-2 border-[#206F78] text-[#206F78] py-4 px-12 rounded-full font-bold text-xl">{{ form.sponsor_cta }}</span>
                </section>
            </div>
        </div>

    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';

const isSaving = ref(false);
const form = ref({ hero_title: '', hero_subtitle: '', sponsor_cta: '' });
const newSponsorName = ref('');
const heroImages = ref([]);
const sponsors = ref([]);

const Toast = Swal.mixin({
    toast: true, position: 'top-end', showConfirmButton: false, timer: 3500, timerProgressBar: true,
    customClass: { popup: 'bg-[#0f3b40]/95 backdrop-blur-lg border border-teal-500/30 text-white shadow-2xl rounded-xl' }
});

// Hanya ADA SATU onMounted yang efisien
onMounted(async () => {
    try {
        const res = await axios.get('/api/cms-content');
        if(res.data.data) {
            form.value.hero_title = res.data.data.hero_title || '';
            form.value.hero_subtitle = res.data.data.hero_subtitle || '';
            form.value.sponsor_cta = res.data.data.sponsor_cta || '';
            
            heroImages.value = [];
            sponsors.value = [];
            
            for (const [k, v] of Object.entries(res.data.data)) {
                if (k.startsWith('hero_image_') && v) heroImages.value.push({ key: k, url: v });
                if (k.startsWith('sponsor_logo_') && v) sponsors.value.push({ key: k, value: v, type: 'image' });
                if (k.startsWith('sponsor_text_') && v) sponsors.value.push({ key: k, value: v, type: 'text' });
            }
        }
    } catch (e) { console.error("Gagal load CMS:", e); }
});

const saveContent = async () => {
    isSaving.value = true;
    try {
        for (const [key, value] of Object.entries(form.value)) {
            await axios.post('/api/admin/cms-content/update', { key, value }, {
                headers: { 'Authorization': `Bearer ${localStorage.getItem('auth_token')}` } // Wajib
            });
        }
        Toast.fire({ icon: 'success', title: 'Perubahan berhasil disimpan' });
    } catch (error) {
        Toast.fire({ icon: 'error', title: 'Gagal menyimpan perubahan' });
    } finally {
        isSaving.value = false;
    }
};

const uploadHeroImage = async (e) => {
    const file = e.target.files[0];
    if (!file) return;
    const formData = new FormData();
    formData.append('image', file);
    try {
        const res = await axios.post('/api/admin/cms-content/upload-hero', formData, {
            headers: { 'Content-Type': 'multipart/form-data', 'Authorization': `Bearer ${localStorage.getItem('auth_token')}` } // Wajib
        });
        heroImages.value.push({ key: res.data.key, url: res.data.url });
        Toast.fire({ icon: 'success', title: 'Gambar berhasil diunggah' });
    } catch (error) {
        Toast.fire({ icon: 'error', title: 'Gagal mengupload gambar' });
    }
};

const removeHeroImage = async (idx) => {
    const imageToDelete = heroImages.value[idx];
    if (imageToDelete.key) {
        try {
            await axios.post('/api/admin/cms-content/delete', { key: imageToDelete.key }, {
                headers: { 'Authorization': `Bearer ${localStorage.getItem('auth_token')}` } // Wajib
            });
        } catch (error) {
            return Toast.fire({ icon: 'error', title: 'Gagal menghapus gambar' });
        }
    }
    heroImages.value.splice(idx, 1);
    Toast.fire({ icon: 'info', title: 'Gambar dihapus' });
};

const uploadSponsorLogo = async (e) => {
    const file = e.target.files[0];
    if (!file) return;
    const formData = new FormData();
    formData.append('image', file);
    try {
        const res = await axios.post('/api/admin/cms-content/upload-sponsor', formData, {
            headers: { 'Content-Type': 'multipart/form-data', 'Authorization': `Bearer ${localStorage.getItem('auth_token')}` }
        });
        sponsors.value.push({ key: res.data.key, value: res.data.url, type: 'image' });
        Toast.fire({ icon: 'success', title: 'Logo sponsor diunggah' });
    } catch (error) {
        Toast.fire({ icon: 'error', title: 'Gagal mengupload logo' });
    }
};

const addTextSponsor = async () => {
    if (newSponsorName.value.trim() === '') return;
    const key = 'sponsor_text_' + Date.now();
    try {
        await axios.post('/api/admin/cms-content/update', { key: key, value: newSponsorName.value }, {
            headers: { 'Authorization': `Bearer ${localStorage.getItem('auth_token')}` }
        });
        sponsors.value.push({ key: key, value: newSponsorName.value, type: 'text' });
        newSponsorName.value = '';
        Toast.fire({ icon: 'success', title: 'Sponsor teks ditambahkan' });
    } catch (error) {
        Toast.fire({ icon: 'error', title: 'Gagal menambah sponsor' });
    }
};

const removeSponsor = async (idx) => {
    const sponsorToDelete = sponsors.value[idx];
    if (sponsorToDelete.key) {
        try {
            await axios.post('/api/admin/cms-content/delete', { key: sponsorToDelete.key }, {
                headers: { 'Authorization': `Bearer ${localStorage.getItem('auth_token')}` }
            });
        } catch (error) {
            return Toast.fire({ icon: 'error', title: 'Gagal menghapus data sponsor' });
        }
    }
    sponsors.value.splice(idx, 1);
    Toast.fire({ icon: 'info', title: 'Sponsor dihapus' });
};
</script>