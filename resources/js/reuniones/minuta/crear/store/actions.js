export default {
    ponerReunion({commit}, reunion){
        commit('colocarReunion', reunion);
    },
    ponerComentarioEnTema({commit}, {temaId, comentario}){
        commit('colocarComentarioEnTema', {temaId, comentario});
    },
    ponerAcuerdoEnTema({commit}, acuerdo){
        commit('colocarAcuerdoEnTema', acuerdo);
    },
    ponerNuevoAcuerdo({commit}, acuerdo){
        commit('colocarNuevoAcuerdo', acuerdo);
    },
    quitarAcuerdo({commit}, {tema_id, uuid}){
        commit('eliminarAcuerdo', {tema_id, uuid});
    },
};
