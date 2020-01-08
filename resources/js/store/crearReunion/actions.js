import axios from 'axios'
import api from '../../services/api'
import ESTADO_API from '../../enum-estado-api'

export default {
    leerAcademiasQuePreside({commit}, user){
        console.log(api.baseURL);
        let uri = `${api.baseURL}/users/${user}/academiasQueHaPresidido?actual=true`
        return new Promise((res, rej) => {
        commit('colocarEstadoAcademias', ESTADO_API.CARGANDO);
        axios
            .get(uri)
            .then(r => r.data)
            .then(academias => {
                commit('colocarAcademias', academias);
                commit('colocarEstadoAcademias', ESTADO_API.LISTO);
                res();
            })
            .catch(err=>{
                commit('colocarEstadoAcademias', ESTADO_API.ERROR);
                console.log(err);
                rej();
            });
        });
    },
};
