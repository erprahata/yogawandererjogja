import { createRouter, createWebHistory } from 'vue-router';
import AuthView from './components/AuthView.vue';
import AdminLayout from './components/AdminLayout.vue';
import AdminOverview from './components/AdminDashboard.vue';
import ApprovalCenter from './components/ApprovalCenter.vue';
import GuestList from './components/GuestList.vue';
import ContentManager from './components/ContentManager.vue';
import TicketManager from './components/TicketManager.vue'; // 1. Import komponen baru

const routes = [
    { path: '/login', name: 'login', component: AuthView },
    { path: '/register', name: 'register', component: AuthView },
    { path: '/my-tickets', name: 'my-tickets', component: () => import('./components/MyTickets.vue') },
    {
        path: '/admin',
        component: AdminLayout,
        children: [
            { path: '', name: 'overview', component: AdminOverview },
            { path: 'approval', name: 'approval', component: ApprovalCenter },
            { path: 'guests', name: 'guests', component: GuestList },
            { path: 'cms', name: 'cms', component: ContentManager },
            { path: 'tickets', name: 'tickets', component: TicketManager }, // 2. Tambahkan rute
        ]
    }
];

export default createRouter({ history: createWebHistory(), routes });