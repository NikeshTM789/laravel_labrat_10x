import './bootstrap';

import Route from './route.js';
import App from "./App.vue";
import { createApp } from "vue";
import { createPinia } from 'pinia';

createApp(App).use(Route).use(createPinia()).mount("#app");

