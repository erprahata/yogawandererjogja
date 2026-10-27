<template>
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden relative">
            
            <!-- Tombol Close Modal -->
            <button v-if="!isSuccess" @click="$emit('close')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <!-- State 1: Form Konfirmasi Checkout -->
            <div v-if="!isSuccess" class="p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Konfirmasi Booking</h2>
                <p class="text-gray-600 text-sm mb-6">Detail pesanan kelas yoga Anda.</p>

                <div class="bg-gray-50 rounded-xl p-4 mb-6 border border-gray-100">
                    <h3 class="font-bold text-teal-800">{{ yogaClass.name }}</h3>
                    <p class="text-sm text-gray-600 mt-1">{{ formatDate(yogaClass.schedule) }}</p>
                    <div class="mt-4 flex justify-between items-center border-t border-gray-200 pt-4">
                        <span class="font-medium text-gray-700">Total Pembayaran:</span>
                        <span class="text-lg font-bold text-amber-600">Rp {{ formatPrice(yogaClass.price) }}</span>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Metode Pembayaran</label>
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Opsi Bank -->
                            <label :class="['flex items-center justify-center p-4 border rounded-xl cursor-pointer transition-all', paymentMethod === 'bank' ? 'border-teal-600 bg-teal-50 ring-2 ring-teal-600/20' : 'border-gray-200 hover:border-teal-300']">
                                <input type="radio" v-model="paymentMethod" value="bank" class="hidden">
                                <div class="text-center">
                                    <svg class="w-8 h-8 mx-auto mb-2" :class="paymentMethod === 'bank' ? 'text-teal-700' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                    <span :class="['text-sm font-bold', paymentMethod === 'bank' ? 'text-teal-800' : 'text-gray-600']">Transfer Bank</span>
                                </div>
                            </label>

                            <!-- Opsi QRIS -->
                            <label :class="['flex items-center justify-center p-4 border rounded-xl cursor-pointer transition-all', paymentMethod === 'qris' ? 'border-teal-600 bg-teal-50 ring-2 ring-teal-600/20' : 'border-gray-200 hover:border-teal-300']">
                                <input type="radio" v-model="paymentMethod" value="qris" class="hidden">
                                <div class="text-center">
                                    <svg class="w-8 h-8 mx-auto mb-2" :class="paymentMethod === 'qris' ? 'text-teal-700' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                                    <span :class="['text-sm font-bold', paymentMethod === 'qris' ? 'text-teal-800' : 'text-gray-600']">QRIS Dinamis</span>
                                </div>
                            </label>
                        </div>
                </div>

                <button @click="processCheckout" :disabled="isLoading" class="w-full bg-teal-700 hover:bg-teal-800 disabled:bg-teal-400 text-white font-bold py-3 px-4 rounded-xl transition flex justify-center items-center">
                    <span v-if="isLoading">Memproses...</span>
                    <span v-else>Konfirmasi & Pesan Sekarang</span>
                </button>
            </div>

            <!-- State 2: Sukses & Instruksi Pembayaran WA -->
            <div v-else class="p-8 text-center">
                <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Booking Berhasil!</h2>
                <p class="text-gray-600 text-sm mb-6">Pesanan Anda telah dicatat. Silakan lakukan pembayaran ke rekening berikut:</p>

                <!-- Jika Bank: -->
                <div v-if="paymentMethod === 'bank'" class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-left mb-6">
                    <p class="text-sm text-gray-500 mb-1">BCA - Atas Nama Yoga Wanderer</p>
                    <p class="text-lg font-mono font-bold text-gray-800 tracking-wider">123-456-7890</p>
                    <div class="mt-3 text-sm flex justify-between">
                        <span>Nominal Transfer:</span>
                        <span class="font-bold text-amber-600">Rp {{ formatPrice(yogaClass.price) }}</span>
                    </div>
                    <div class="mt-2 text-sm flex justify-between border-t border-gray-200 pt-2">
                        <span>No. Transaksi:</span>
                        <span class="font-bold text-teal-700">{{ transactionData.transaction_code }}</span>
                    </div>
                </div>

                <!-- Jika QRIS: -->
                <div v-else class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-center mb-6 flex flex-col items-center">
                    <p class="text-sm font-bold text-gray-800 mb-2">Scan QRIS Berikut</p>

                    <div class="w-48 h-48 bg-white border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center mb-4 p-2">
                        <qrcode-vue v-if="transactionData?.dynamic_qris" :value="transactionData.dynamic_qris" :size="170" level="M" />
                        <span v-else class="text-xs text-gray-400">Gagal memuat QRIS</span>
                    </div>

                    <div class="w-full text-sm flex justify-between border-t border-gray-200 pt-3">
                        <span>No. Transaksi:</span>
                        <span class="font-bold text-teal-700">{{ transactionData.transaction_code }}</span>
                    </div>
                </div>

                <p class="text-xs text-red-500 mb-6 font-medium">
                    *Kebijakan No-Show: Tiket yang telah dibayar akan hangus jika tidak hadir tanpa konfirmasi.
                </p>

                <button @click="confirmViaWhatsApp" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 rounded-xl transition flex justify-center items-center gap-2 mb-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
                    Konfirmasi via WhatsApp
                </button>

                <button @click="$emit('close')" class="text-sm font-medium text-gray-500 hover:text-gray-800 transition">
                    Tutup & Kembali ke Beranda
                </button>
            </div>

        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import QrcodeVue from 'qrcode.vue';

const props = defineProps({ yogaClass: { type: Object, required: true } });
const emit = defineEmits(['close']);
const router = useRouter();

const isLoading = ref(false);
const isSuccess = ref(false);
const transactionData = ref(null);
const paymentMethod = ref('bank'); // Default ke bank
const adminPhoneNumber = "6281234567890";

const processCheckout = async () => {
    isLoading.value = true;
    try {
        const response = await axios.post('/api/checkout', {
            yoga_class_id: props.yogaClass.id,
            payment_method: paymentMethod.value // Kirim pilihan user ke backend
        }, {
            headers: { 'Authorization': `Bearer ${localStorage.getItem('auth_token')}` }
        });
        
        transactionData.value = response.data.data;
        isSuccess.value = true;
    } catch (error) {
        alert(error.response?.data?.message || "Terjadi kesalahan.");
    } finally {
        isLoading.value = false;
    }
};

const confirmViaWhatsApp = () => {
    if (!transactionData.value) return;
    const textTemplate = `Halo Admin Yoga Wanderer Jogja, saya ingin mengkonfirmasi pembayaran tiket kelas yoga.%0A%0A*Detail Pesanan:*%0AKelas: ${props.yogaClass.name}%0AMetode: ${paymentMethod.value.toUpperCase()}%0ANo. Transaksi: *${transactionData.value.transaction_code}*%0A%0ABerikut saya lampirkan bukti pembayarannya. Terima kasih.`;
    
    // Buka WA di tab baru
    window.open(`https://wa.me/${adminPhoneNumber}?text=${textTemplate}`, '_blank');
    
    // Tutup modal dan langsung lempar ke halaman E-Ticket/Riwayat
    emit('close');
    router.push({ name: 'my-tickets' });
};

const formatDate = (dateString) => {
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
};

const formatPrice = (price) => {
    return Number(price).toLocaleString('id-ID');
};
</script>