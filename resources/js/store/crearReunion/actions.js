import axios from 'axios'
import api from '../../services/api'
import ESTADO_API from '../../enum-estado-api'

export default {
    leerAcademiasQuePreside({commit}, user){
        let uri = `${api.baseURL}/users/${user}/academiasQueHaPresidido?actual=1`;
        commit('colocarEstadoAcademias', ESTADO_API.CARGANDO);
        axios
            .get(uri)
            .then(r => r.data.data)
            .then(academias => {
                commit('colocarAcademias', academias);
                commit('colocarEstadoAcademias', ESTADO_API.LISTO);
                // res();
            })
            .catch(err=>{
                commit('colocarEstadoAcademias', ESTADO_API.ERROR);
                console.log(err);
            });
    },
    leerAcademia({commit}, id){
        // console.log(api.baseURL);
        let uri = `${api.baseURL}/academias/${id}/`;
        // return new Promise((res, rej) => {
        commit('colocarEstadoAcademia', ESTADO_API.CARGANDO);
        axios
            .get(uri)
            .then(r => r.data.data)
            .then(academia => {
                commit('colocarAcademia', academia);
                commit('colocarEstadoAcademia', ESTADO_API.LISTO);
                // res();
            })
            .catch(err=>{
                commit('colocarEstadoAcademia', ESTADO_API.ERROR);
                console.log(err);
                // rej();
            });
        // });
    },
    ponerConvocados({commit}, convocados){
        commit('colocarConvocados', convocados);
    },
    agregarConvocado({commit}, convocado){
        commit('colocarConvocado', convocado);
    },
    agregarInvitado({commit}, invitado){
        commit('colocarInvitado', invitado);
    },
    eliminarInvitadoPorId({commit}, invitado){
        commit('removerInvitadoPorId', invitado);
    },
    agregarTema({commit}, tema){
        commit('colocarTema', tema);
    },
    eliminarTema({commit}, tema){
        commit('removerTema', tema);
    },
    editarTema({commit}, tema){
        commit('actualizarTema', tema);
    },
    leerAcuerdosPendientes({commit}, academia_id){
        let uri = `${api.baseURL}/academias/${academia_id}/acuerdos?estadofin=pend`;
        // commit('colocarEstadoAcademiasPendientes', ESTADO_API.CARGANDO);
        axios
            .get(uri)
            .then(r => r.data.data)
            .then(acuerdos => {
                commit('colocarAcuerdosPendientes', acuerdos);
                // commit('colocarEstadoAcademias', ESTADO_API.LISTO);
            })
            .catch(err=>{
                // commit('colocarEstadoAcademias', ESTADO_API.ERROR);
                console.log(err);
        });

    },
    ponerAcuerdosASeguimiento({commit}, acuerdos){
        commit('colocarAcuerdosASeguimiento', acuerdos);
    },
};
