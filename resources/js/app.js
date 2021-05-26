

require('./bootstrap');

import Vue from 'vue'
import router from './router/index'
import store from './store/index'

import './plugins/vue-progress-bar'
import './plugins/sweetalert'
import './plugins/filters'


window.Vue = Vue;


const app = new Vue({
    el: '#app',
    router,
    store
});
