require('../../../axiosconfig');

import Vue from 'vue';
import store from './store';
import BootstrapVue from 'bootstrap-vue';

Vue.use(BootstrapVue);

Vue.component('crear-minuta-form', require('./components/CrearMinutaForm.vue').default);
Vue.component('aviso-error', require('./../../../components/AvisoDeError.vue').default);

const app = new Vue({
    store,
    el: '#app',
});