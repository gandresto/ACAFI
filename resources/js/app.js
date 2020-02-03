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

// Importar modulos externos
import { Datetime } from 'vue-datetime';
import Autocomplete from '@trevoreyre/autocomplete-vue'
import VueCal from 'vue-cal';
import datePicker from 'vue-bootstrap-datetimepicker';

Vue.use(VueAxios, axios);
Vue.use(BootstrapVue);
Vue.use(Autocomplete);
Vue.use(VueCal);
Vue.use(datePicker);

// Configurar headers para Axios
axios.defaults.headers.common = {
    'X-CSRF-TOKEN': Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest',
    'Authorization': 'Bearer ' + Laravel.apiToken,
    'Accept' : 'application/json',
};

// Configurar iconos de vue-bootstrap-datetimepicker
jQuery.extend(true, jQuery.fn.datetimepicker.defaults, {
    icons: {
        time: 'fa fa-clock',
        date: 'fa fa-calendar',
        up: 'fa fa-arrow-up',
        down: 'fa fa-arrow-down',
        previous: 'fas fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-calendar-check',
        clear: 'fa fa-trash-alt',
        close: 'fa fa-times-circle'
    }
    // icons: {
    //     time: 'far fa-clock',
    //     date: 'far fa-calendar',
    //     up: 'fas fa-arrow-up',
    //     down: 'fas fa-arrow-down',
    //     previous: 'fas fa-chevron-left',
    //     next: 'fas fa-chevron-right',
    //     today: 'fas fa-calendar-check',
    //     clear: 'far fa-trash-alt',
    //     close: 'far fa-times-circle'
    // }
});

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

// Componentes propios
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('buscar-usuario', require('./components/BuscarUsuario.vue').default);
Vue.component('buscar-division', require('./components/BuscarDivision.vue').default);
Vue.component('editar-division', require('./components/EditarDivision.vue').default);
Vue.component('modal', require('./components/PlantillaModal.vue').default);
Vue.component('crear-usuario-modal', require('./components/CrearUsuarioModal.vue').default);
Vue.component('aviso-error', require('./components/AvisoDeError.vue').default);

// Componentes "vista"
Vue.component('calendario-index', require('./views/Calendario.vue').default);
Vue.component('crear-reunion', require('./views/CrearReunion.vue').default);
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
