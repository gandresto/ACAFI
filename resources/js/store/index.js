import Vue from 'vue';
import Vuex from 'vuex';
import crearReunion from './crearReunion'

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        crearReunion
    }
});
