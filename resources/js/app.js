/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import 'vue-cal/dist/i18n/es.js';


import Vue from 'vue';
import VueAxios from 'vue-axios';
import axios from 'axios';
import BootstrapVue from 'bootstrap-vue';
import store from './store/';

import { Datetime } from 'vue-datetime';
import Autocomplete from '@trevoreyre/autocomplete-vue'
import VueCal from 'vue-cal';

Vue.use(VueAxios, axios);
Vue.use(BootstrapVue);
Vue.use(Autocomplete);
Vue.use(VueCal);

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest',
    'Authorization': 'Bearer ' + Laravel.apiToken,
    'Accept' : 'application/json',
};

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Componentes de dependencias
Vue.component('v-datetime', Datetime);
Vue.component('v-calendar', VueCal);

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('buscar-usuario', require('./components/BuscarUsuario.vue').default);
Vue.component('buscar-division', require('./components/BuscarDivision.vue').default);
Vue.component('editar-division', require('./components/EditarDivision.vue').default);
Vue.component('modal', require('./components/PlantillaModal.vue').default);

Vue.component('calendario-index', require('./views/Calendario.vue').default);

Vue.component('crear-reunion', require('./views/CrearReunion.vue').default);

Vue.component('crear-usuario-modal', require('./components/CrearUsuarioModal.vue').default);

Vue.component('crear-minuta', require('./views/CrearMinuta.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    store,
    el: '#app',
});
