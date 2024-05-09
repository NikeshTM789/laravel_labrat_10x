import Home from './pages/Home.vue';
import Contact from './pages/Contact.vue';

import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/",
        component: Home,
    },
    {
        path: "/contact",
        component: Contact,
    }
];

export default createRouter({
    history: createWebHistory(),
    routes,
});

