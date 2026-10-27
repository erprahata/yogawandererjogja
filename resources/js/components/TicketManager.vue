<template>
    <div class="space-y-6">
        <!-- Form Pembuatan / Edit Tiket -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="text-xl font-bold text-gray-800 mb-6">
                {{ isEditing ? '✏️ Edit Tiket Kelas' : 'Buat Tiket Kelas Baru' }}
            </h2>
            
            <!-- Pilihan Tipe Kelas -->
            <div class="flex gap-4 mb-8">
                <label class="flex-1 cursor-pointer">
                    <input type="radio" v-model="form.type" value="regular" class="peer hidden" :disabled="isEditing">
                    <div class="p-4 rounded-xl border-2 peer-checked:border-teal-600 peer-checked:bg-teal-50 transition text-center font-bold text-gray-500 peer-checked:text-teal-700 shadow-sm opacity-100 peer-disabled:opacity-50">
                        🌿 Kelas Rutin (Reguler)
                    </div>
                </label>
                <label class="flex-1 cursor-pointer">
                    <input type="radio" v-model="form.type" value="event" class="peer hidden" :disabled="isEditing">
                    <div class="p-4 rounded-xl border-2 peer-checked:border-amber-500 peer-checked:bg-amber-50 transition text-center font-bold text-gray-500 peer-checked:text-amber-700 shadow-sm opacity-100 peer-disabled:opacity-50">
                        🔥 Event Spesial (Eksklusif)
                    </div>
                </label>
            </div>

            <form @submit.prevent="saveTicket" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kolom Kiri -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas / Event</label>
                        <input v-model="form.name" type="text" required class="w-full border border-gray-300 rounded-xl p-3 focus:ring-teal-500 focus:border-teal-500 text-sm" placeholder="Contoh: Sunset Vinyasa Flow">
                    </div>

                    <!-- Input Dinamis: Jika Reguler -->
                    <div v-if="form.type === 'regular'" class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hari Pelaksanaan (Pilih minimal 1)</label>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <label v-for="day in availableDays" :key="day.value" class="cursor-pointer">
                                <input type="checkbox" v-model="form.recurring_days" :value="day.value" class="peer hidden">
                                <span class="px-3 py-1.5 rounded-lg border text-xs font-semibold peer-checked:bg-teal-600 peer-checked:text-white transition">
                                    {{ day.label }}
                                </span>
                            </label>
                        </div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 mt-4">Jam Mulai</label>
                        <input v-model="form.start_time" type="time" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm" :required="form.type === 'regular'">
                    </div>

                    <!-- Input Dinamis: Jika Event -->
                    <div v-if="form.type === 'event'" class="p-4 bg-amber-50/50 rounded-xl border border-amber-200">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jadwal Pasti Event</label>
                        <input v-model="form.schedule" type="datetime-local" class="w-full border border-gray-300 rounded-xl p-3 text-sm focus:ring-amber-500" :required="form.type === 'event'">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi / Titik Kumpul</label>
                        <input v-model="form.location" type="text" required class="w-full border border-gray-300 rounded-xl p-3 focus:ring-teal-500 text-sm" placeholder="Contoh: Plataran Candi">
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                            <input v-model="form.price" type="number" required class="w-full border border-gray-300 rounded-xl p-3 focus:ring-teal-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Batas Kuota</label>
                            <input v-model="form.quota" type="number" required class="w-full border border-gray-300 rounded-xl p-3 focus:ring-teal-500 text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Poster Visual <span v-if="isEditing" class="text-xs text-amber-600 font-normal">(Kosongkan jika tidak ingin ganti)</span></label>
                        <input type="file" @change="handleFileUpload" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:font-semibold file:bg-teal-50 file:text-teal-700">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                        <textarea v-model="form.description" rows="4" required class="w-full border border-gray-300 rounded-xl p-3 focus:ring-teal-500 text-sm" placeholder="Jelaskan daya tarik kelas ini..."></textarea>
                    </div>
                </div>

                <div class="md:col-span-2 flex justify-end gap-3 mt-2">
                    <button v-if="isEditing" type="button" @click="cancelEdit" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-xl transition shadow-sm">
                        Batal
                    </button>
                    <button type="submit" :disabled="isSaving" class="bg-teal-700 hover:bg-teal-800 text-white font-bold py-3 px-10 rounded-xl transition shadow-md disabled:opacity-50">
                        {{ isSaving ? 'Memproses...' : (isEditing ? 'Simpan Perubahan' : 'Terbitkan Tiket') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Daftar Tiket -->
        <h3 class="text-lg font-bold text-gray-800 mt-8 mb-4">Manajemen Kelas Aktif</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="ticket in tickets" :key="ticket.id" class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition group flex flex-col justify-between">
                <div>
                    <div class="h-44 bg-gray-200 relative overflow-hidden">
                        <img v-if="ticket.image" :src="ticket.image" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
                        <div class="absolute top-3 left-3 px-3 py-1 rounded-full text-xs font-bold shadow-md" :class="ticket.type === 'event' ? 'bg-amber-500 text-white' : 'bg-teal-600 text-white'">
                            {{ ticket.type === 'event' ? 'Event FOMO' : 'Kelas Rutin' }}
                        </div>
                    </div>
                    <div class="p-5 pb-0">
                        <h4 class="font-bold text-gray-800 text-lg line-clamp-1">{{ ticket.name }}</h4>
                        <p class="text-sm text-gray-500 mt-1 flex items-center gap-1">📍 {{ ticket.location }}</p>
                        
                        <!-- Penampil Jadwal (Tanggal & Jam) -->
                        <div class="mt-3 bg-gray-50 p-2.5 rounded-lg border border-gray-100 text-xs font-medium text-gray-600">
                            <div v-if="ticket.type === 'regular'">
                                🗓️ {{ formatDays(ticket.recurring_days) }} <br>
                                ⏰ {{ ticket.start_time ? ticket.start_time.substring(0, 5) : '-' }} WIB
                            </div>
                            <div v-else>
                                🗓️ {{ formatEventDate(ticket.schedule) }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="p-5 mt-4 flex justify-between items-center border-t border-gray-100">
                    <span class="text-lg font-black text-teal-800">Rp {{ Number(ticket.price).toLocaleString('id-ID') }}</span>
                    <div class="flex gap-2">
                        <button @click="editTicket(ticket)" class="text-xs font-bold text-amber-600 hover:text-amber-800 transition bg-amber-50 px-3 py-1.5 rounded-lg">Edit</button>
                        <button @click="deleteTicket(ticket.id)" class="text-xs font-bold text-red-500 hover:text-red-700 transition bg-red-50 px-3 py-1.5 rounded-lg">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pemotong Gambar (vue-advanced-cropper) -->
    <div v-if="showCropper" class="fixed inset-0 z-[99] flex items-center justify-center bg-black/90 p-4">
        <div class="bg-white rounded-2xl w-full max-w-4xl overflow-hidden flex flex-col shadow-2xl">
            <div class="p-4 border-b flex justify-between items-center bg-gray-50">
                <h3 class="font-bold text-gray-800 text-lg">Sesuaikan Proporsi Poster (16:9)</h3>
                <button @click="cancelCrop" class="text-gray-400 hover:text-red-500 text-2xl font-black">&times;</button>
            </div>
            <div class="bg-gray-900 w-full h-[60vh] relative flex items-center justify-center overflow-hidden">
                <Cropper
                    ref="cropperRef"
                    class="w-full h-full"
                    :src="cropperImageUrl"
                    :stencil-props="{ aspectRatio: 16 / 9 }"
                    image-restriction="fit-area"
                />
            </div>
            <div class="p-4 border-t flex justify-end gap-3 bg-gray-50">
                <button type="button" @click="cancelCrop" class="px-6 py-2.5 text-gray-600 font-bold bg-gray-200 hover:bg-gray-300 rounded-xl transition">Batal</button>
                <button type="button" @click="applyCrop" class="px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl font-bold transition">Potong & Gunakan</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import { Cropper } from 'vue-advanced-cropper';
import 'vue-advanced-cropper/dist/style.css';

const tickets = ref([]);
const isSaving = ref(false);

// State Edit
const isEditing = ref(false);
const editingId = ref(null);

const availableDays = [
    { label: 'Sen', value: 'Monday' }, { label: 'Sel', value: 'Tuesday' }, { label: 'Rab', value: 'Wednesday' },
    { label: 'Kam', value: 'Thursday' }, { label: 'Jum', value: 'Friday' }, { label: 'Sab', value: 'Saturday' }, { label: 'Min', value: 'Sunday' }
];

const form = ref({
    type: 'regular', name: '', schedule: '', start_time: '', recurring_days: [], price: '', quota: '', location: '', description: '', imageFile: null
});

const Toast = Swal.mixin({
    toast: true, position: 'top-end', showConfirmButton: false, timer: 3000,
    customClass: { popup: 'bg-[#0f3b40]/95 backdrop-blur-lg border border-teal-500/30 text-white shadow-2xl rounded-xl' }
});

const loadTickets = async () => {
    try {
        const res = await axios.get('/api/classes/active');
        tickets.value = res.data.data;
    } catch (e) { console.error(e); }
};

onMounted(loadTickets);

// Helpers Formatter Jam dan Hari
const formatDays = (daysData) => {
    try {
        const parsed = typeof daysData === 'string' ? JSON.parse(daysData) : (daysData || []);
        const dayMap = { Monday: 'Sen', Tuesday: 'Sel', Wednesday: 'Rab', Thursday: 'Kam', Friday: 'Jum', Saturday: 'Sab', Sunday: 'Min' };
        return parsed.map(d => dayMap[d] || d).join(', ');
    } catch(e) { return '-'; }
};

const formatEventDate = (datetimeStr) => {
    if (!datetimeStr) return '-';
    // Menghapus huruf 'Z' di belakang string agar JS tidak menganggapnya UTC dan menambah 7 jam
    const cleanDateStr = datetimeStr.replace('Z', ''); 
    const date = new Date(cleanDateStr);
    
    // Format: "Sel, 26 Sep 2026 • 06:30 WIB"
    return date.toLocaleString('id-ID', {
        weekday: 'short', day: 'numeric', month: 'short', year: 'numeric',
        hour: '2-digit', minute: '2-digit'
    }).replace(',', ' •') + ' WIB';
};

// Cropper State
const showCropper = ref(false);
const cropperImageUrl = ref(null);
const cropperRef = ref(null);

const handleFileUpload = (e) => {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = (event) => {
        cropperImageUrl.value = event.target.result;
        showCropper.value = true;
    };
    reader.readAsDataURL(file);
};

const applyCrop = () => {
    const { canvas } = cropperRef.value.getResult();
    if (canvas) {
        canvas.toBlob((blob) => {
            const croppedFile = new File([blob], 'poster-terpotong.webp', { type: 'image/webp' });
            form.value.imageFile = croppedFile;
            showCropper.value = false;
        }, 'image/webp', 0.85);
    }
};

const cancelCrop = () => {
    showCropper.value = false;
    const fileInput = document.querySelector('input[type="file"]');
    if (fileInput) fileInput.value = '';
    form.value.imageFile = null;
};

// Fitur Edit & Cancel Edit
const editTicket = (ticket) => {
    isEditing.value = true;
    editingId.value = ticket.id;
    
    // Potong huruf Z dan detik untuk format input datetime-local standar (YYYY-MM-DDTHH:mm)
    const rawSchedule = ticket.schedule ? ticket.schedule.replace('Z', '').substring(0, 16) : '';
    
    form.value = {
        type: ticket.type,
        name: ticket.name,
        price: ticket.price,
        quota: ticket.quota,
        location: ticket.location,
        description: ticket.description,
        schedule: rawSchedule,
        start_time: ticket.start_time ? ticket.start_time.substring(0, 5) : '', // Potong agar jadi HH:mm
        recurring_days: typeof ticket.recurring_days === 'string' ? JSON.parse(ticket.recurring_days) : (ticket.recurring_days || []),
        imageFile: null
    };
    
    // Scroll ke atas otomatis
    window.scrollTo({ top: 0, behavior: 'smooth' });
};

const cancelEdit = () => {
    isEditing.value = false;
    editingId.value = null;
    form.value = { type: 'regular', name: '', schedule: '', start_time: '', recurring_days: [], price: '', quota: '', location: '', description: '', imageFile: null };
    const fileInput = document.querySelector('input[type="file"]');
    if(fileInput) fileInput.value = '';
};

// Modifikasi saveTicket untuk mendukung PUT/POST
const saveTicket = async () => {
    isSaving.value = true;
    try {
        const formData = new FormData();
        formData.append('type', form.value.type);
        formData.append('name', form.value.name);
        formData.append('price', form.value.price);
        formData.append('quota', form.value.quota);
        formData.append('location', form.value.location);
        formData.append('description', form.value.description);
        
        if (form.value.type === 'regular') {
            if(form.value.recurring_days.length === 0) {
                isSaving.value = false;
                return Toast.fire({ icon: 'warning', title: 'Pilih minimal 1 hari pelaksanaan' });
            }
            formData.append('recurring_days', JSON.stringify(form.value.recurring_days));
            formData.append('start_time', form.value.start_time.toString()); 
        } else {
            if(!form.value.schedule) {
                 isSaving.value = false;
                 return Toast.fire({ icon: 'warning', title: 'Jadwal pasti event belum diisi' });
            }
            formData.append('schedule', form.value.schedule);
        }
        
        if (form.value.imageFile) {
            formData.append('image', form.value.imageFile);
        }

        // Trik khusus Laravel: Kirim POST tapi beri tahu server ini adalah PUT
        if (isEditing.value) {
            formData.append('_method', 'PUT');
        }

        const url = isEditing.value ? `/api/admin/classes/${editingId.value}` : '/api/admin/classes';
        
        await axios.post(url, formData, {
            headers: { 
                'Content-Type': 'multipart/form-data', 
                'Authorization': `Bearer ${localStorage.getItem('auth_token')}` 
            }
        });
        
        Toast.fire({ icon: 'success', title: isEditing.value ? 'Perubahan disimpan!' : 'Tiket diterbitkan!' });
        
        cancelEdit(); // Reset form dan state
        loadTickets();

    } catch (error) {
        if (error.response && error.response.status === 422) {
            const errors = error.response.data.errors;
            const firstErrorMsg = Object.values(errors)[0][0]; 
            Toast.fire({ icon: 'error', title: 'Gagal: ' + firstErrorMsg });
        } else {
            Toast.fire({ icon: 'error', title: 'Terjadi kesalahan sistem' });
        }
    } finally {
        isSaving.value = false;
    }
};

// deleteTicket tetap sama
const deleteTicket = async (id) => {
    const confirm = await Swal.fire({
        title: 'Hapus Tiket?',
        text: "Data tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus!',
        background: '#ffffff',
        customClass: { popup: 'rounded-2xl' }
    });

    if (confirm.isConfirmed) {
        try {
            await axios.delete(`/api/admin/classes/${id}`, {
                headers: { 'Authorization': `Bearer ${localStorage.getItem('auth_token')}` }
            });
            Toast.fire({ icon: 'success', title: 'Tiket dihapus!' });
            loadTickets();
        } catch (error) {
            Toast.fire({ icon: 'error', title: 'Gagal menghapus tiket' });
        }
    }
};
</script>