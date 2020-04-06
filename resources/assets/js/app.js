/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);
Vue.component('Room', require('./components/Room.vue').default);

const store = require('./store').default;

const app = new Vue({
    store,
}).$mount('#app');
