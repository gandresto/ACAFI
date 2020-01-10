export default {
    colocarAcademias(state, academias){
        state.academias = academias;
    },
    colocarEstadoAcademias(state, estadoAcademias){
        state.estadoAcademias = estadoAcademias;
    },
    colocarAcademia(state, academia){
        state.academia = academia;
    },
    colocarEstadoAcademia(state, estadoAcademia){
        state.estadoAcademia = estadoAcademia;
    },
    colocarConvocados(state, convocados){
        state.convocados = convocados
    },
    colocarConvocado(state, convocado){
        state.convocados.push(convocado)
    },
    colocarInvitados(state, invitados){
        state.invitados = invitados
    },
    colocarInvitado(state, invitado){
        state.invitados.push(invitado)
    },
};
