import './bootstrap';
import '../css/app.css';
import { createApp } from 'vue';
import router from './router'; // Import router yang baru dibuat
import VueApexCharts from 'vue3-apexcharts';

import LandingPage from './components/LandingPage.vue';
import Checkout from './components/Checkout.vue';
import AdminDashboard from './components/AdminDashboard.vue'; // Import komponen admin

const app = createApp({});

app.use(router); // Gunakan router
app.use(VueApexCharts);
app.component('landing-page', LandingPage);
app.component('checkout-form', Checkout);
app.component('admin-dashboard', AdminDashboard); // Daftarkan komponen admin

app.mount('#app');