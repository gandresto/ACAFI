require('../axiosconfig');

import Vue from 'vue';
import { BButton, BModal, BFormSelect } from 'bootstrap-vue';
import { ModalPlugin, FormSelectPlugin } from 'bootstrap-vue'

Vue.use(FormSelectPlugin);
Vue.use(ModalPlugin);
Vue.component('b-button', BButton);
Vue.component('seleccionar-academia-modal', require('./crear/components/SeleccionarAcademiaModal.vue').default);

const app = new Vue({
   el: '#app', 
});