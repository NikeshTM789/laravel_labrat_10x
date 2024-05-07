import Home from './pages/HomeRoute.vue';
import Test from './pages/TestRoute.vue';

import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/",
        component: Home,
    },
    {
        path: "/test",
        component: Test,
    }
];

export default createRouter({
    history: createWebHistory(),
    routes,
});

