require('./../axiosconfig');

import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';

Vue.use(BootstrapVue);

import 'vue-cal/dist/i18n/es.js';
import VueCal from 'vue-cal';

Vue.component('seleccionar-academia-modal', require('./components/SeleccionarAcademiaModal.vue').default);

Vue.component('v-calendar', VueCal);
Vue.component('calendario-index', require('./components/Calendario.vue').default);

import store from './store/';
const app = new Vue({
    store,
    el: '#app',
});