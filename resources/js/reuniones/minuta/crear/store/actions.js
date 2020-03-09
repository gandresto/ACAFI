export default {
  ponerReunion({ commit }, reunion) {
    commit('colocarReunion', reunion);
  },
  ponerComentarioEnTema({ commit }, { tema_id, comentario }) {
    commit('colocarComentarioEnTema', { tema_id, comentario });
  },
  ponerAcuerdoEnTema({ commit }, acuerdo) {
    commit('colocarAcuerdoEnTema', acuerdo);
  },
  ponerNuevoAcuerdo({ commit }, acuerdo) {
    commit('colocarNuevoAcuerdo', acuerdo);
  },
  quitarAcuerdo({ commit }, { tema_id, uuid }) {
    commit('eliminarAcuerdo', { tema_id, uuid });
  },
  ponerAvanceEnAcuerdo({ commit }, { acuerdo_id, avance }) {
    commit('colocarAvanceEnAcuerdo', { acuerdo_id, avance });
  },
  ponerResultadoEnAcuerdo({ commit }, { acuerdo_id, resultado, fecha_finalizado }) {
    commit('colocarResultadoEnAcuerdo', { acuerdo_id, resultado, fecha_finalizado });
  },
};
