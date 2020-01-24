import Vue from 'vue';
import Vuex from 'vuex';
import crearReunion from './crearReunion';
import calendario from './calendario';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        crearReunion,
        calendario,
    }
});
