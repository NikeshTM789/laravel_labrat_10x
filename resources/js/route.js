import Home from './pages/Home.vue';
import Contact from './pages/Contact.vue';
import SingleProduct from './pages/SingleProduct.vue';
import Auth from './pages/Auth.vue';

import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/",
        name: 'home',
        component: Home,
    },
    {
        path: "/contact",
        component: Contact,
    },
    {
        path: "/single-product/:uuid",
        name: "single_product",
        component: SingleProduct,
    },
    {
        path: "/auth",
        name: 'auth',
        component: Auth,
    }
];

export default createRouter({
    history: createWebHistory(),
    routes,
});

