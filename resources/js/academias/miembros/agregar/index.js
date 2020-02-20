require('./../axiosconfig');
import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';

Vue.use(BootstrapVue);

Vue.component('agregar-usuario-form', require('./components/AgregarUsuarioForm.vue').default);
