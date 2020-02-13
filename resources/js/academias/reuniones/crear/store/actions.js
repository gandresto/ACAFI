export default {
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
    ponerAcuerdosASeguimiento({commit}, acuerdos){
        commit('colocarAcuerdosASeguimiento', acuerdos);
    },
};
