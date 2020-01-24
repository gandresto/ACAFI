import axios from 'axios'
import api from '../../services/api'
import ESTADO_API from '../../enum-estado-api'

export default {
    leerReunionesDeUsuario({commit}, user){
        let uri = `api/users/${user}/reuniones?vuecal=1`;
        commit('colocarEstadoReuniones', ESTADO_API.CARGANDO);
        axios
            .get(uri)
            .then(r => r.data.data)
            .then(reuniones => {
                commit('colocarReuniones', reuniones);
                commit('colocarEstadoReuniones', ESTADO_API.LISTO);
                // res();
            })
            .catch(err=>{
                commit('colocarEstadoReuniones', ESTADO_API.ERROR);
                console.log(err);
            });
    },
};
