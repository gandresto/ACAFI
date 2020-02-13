require('../../../bootstrap');
import Vue from 'vue';
import store from './store/';
import BootstrapVue from 'bootstrap-vue';
import Autocomplete from '@trevoreyre/autocomplete-vue'
import datePicker from 'vue-bootstrap-datetimepicker';

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
});

Vue.use(BootstrapVue);

Vue.use(Autocomplete);
Vue.use(datePicker);

Vue.component('formulario-reunion', require('./components/FormularioReunion.vue').default);
Vue.component('agregar-invitados', require('./components/AgregarInvitados.vue').default);
Vue.component('agregar-convocados', require('./components/AgregarConvocados.vue').default);
Vue.component('tabla-acuerdos', require('./components/TablaAcuerdos.vue').default);
Vue.component('agregar-temas', require('./components/AgregarTemas.vue').default);
Vue.component('agregar-temas-tema-item', require('./components/AgregarTemasTemaItem.vue').default);
Vue.component('aviso-error', require('./../../../components/AvisoDeError.vue').default);

const app = new Vue({
    store,
    el: '#app',
});