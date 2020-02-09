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
        state.convocados = convocados;
    },
    colocarConvocado(state, convocado){
        state.convocados.push(convocado);
    },
    colocarInvitados(state, invitados){
        state.invitados = invitados;
    },
    colocarInvitado(state, invitado){
        state.invitados.push(invitado);
    },
    removerInvitadoPorId(state, invitado_id){
        state.invitados = state.invitados.filter(inv => inv.id != invitado_id);
    },
    colocarTema(state, tema){
        state.temas.push(tema);
    },
    actualizarTema(state, tema){
        state.temas = state.temas.map(t => t.id == tema.id ? tema : t); // Si el id coincide, actualizamos
    },
    removerTema(state, tema){
        state.temas = state.temas.filter(t => t.id != tema.id);
    },
    colocarAcuerdosPendientes(state, acuerdos){
        state.acuerdosPendientes = acuerdos;
    },
    colocarAcuerdosASeguimiento(state, acuerdos){
        state.acuerdosASeguimiento = acuerdos;
    },

    colocarErroresDeValidacion(state, errores){
        state.erroresDeValidacion = errores;
    },

};
