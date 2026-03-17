
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

// window.Vue = require('vue');

import './bootstrap';

// import 'bootstrap/dist/js/bootstrap.bundle';

import $ from 'jquery';

window.$ = $;
window.jQuery = $;

// Bootstrap 3 JS
import 'bootstrap';

// Тест
console.log('VITE WORKS 🚀');
console.log('jQuery version:', window.$?.fn?.jquery);

import Vue from 'vue/dist/vue.esm.js';

import Example from './components/Example.vue'

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example', require('./components/Example.vue'));

// Vue.component('example', require('./components/Example.vue').default);

Vue.component('example', Example)

const app = new Vue({
    el: '#app',
});

import '../../public/js/script.js'
