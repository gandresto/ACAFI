require('./../../../axiosconfig');
import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';
import Autocomplete from '@trevoreyre/autocomplete-vue';
import DatePicker from 'vue-bootstrap-datetimepicker';

Vue.use(BootstrapVue);
Vue.use(Autocomplete);
Vue.use(DatePicker);

Vue.component('agregar-miembro-form', require('./components/AgregarMiembroForm.vue').default);
Vue.component('crear-usuario-form', require('./../../../components/CrearUsuarioForm.vue').default);

const app = new Vue({
    el: '#app',
})
