import { createRouter, createWebHistory } from 'vue-router';
import UserProfile from '@/views/UserProfile.vue';
import GenerateURL from '@/views/GenerateURL.vue';

const routes = [
    {
        path: '/',
        name: 'GenerateURL',
        component: GenerateURL
    },
    {
        path: '/profile',
        name: 'UserProfile',
        component: UserProfile
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
