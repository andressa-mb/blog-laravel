/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import '../bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHashHistory } from 'vue-router';
import routes from './routes/index.js';

const app = createApp({});

const router = createRouter({
  history: createWebHashHistory(),
  routes,
})


app.use(router);
app.mount("#vue-users");

// Reativar dropdowns e colapses do Bootstrap 4 depois que o Vue montar
document.addEventListener('DOMContentLoaded', () => {
    $(document).ready(() => {
        $('[data-toggle="dropdown"]').dropdown();
        $('[data-toggle="collapse"]').collapse();
    });
});

// E também reativar sempre que o Vue trocar de rota
router.afterEach(() => {
    $('[data-toggle="dropdown"]').dropdown();
    $('[data-toggle="collapse"]').collapse();
});
