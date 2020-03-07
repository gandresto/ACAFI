require('../../../axiosconfig');

import Vue from 'vue';
import store from './store';
import BootstrapVue from 'bootstrap-vue';
import Autocomplete from '@trevoreyre/autocomplete-vue';
import VueDatePicker from 'vue-bootstrap-datetimepicker';

Vue.use(BootstrapVue);
Vue.use(Autocomplete);
Vue.use(VueDatePicker);

Vue.component('crear-minuta-form', require('./components/CrearMinutaForm.vue').default);
Vue.component('aviso-error', require('./../../../components/AvisoDeError.vue').default);

const app = new Vue({
    store,
    el: '#app',
});