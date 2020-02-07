import { uuidv4} from '../../helpers';

export default {
    colocarMiembrosQueAsistieron(state, miembrosQueAsistieron){
        // state.reunion.convocados = 
        //     state.reunion.convocados.map( convocado => {
        //         if ( miembrosQueAsistieron.includes(convocado) ){
        //             convocado.asistio_convocado = 1;
        //             miembrosQueAsistieron = 
        //                 miembrosQueAsistieron
        //                     .filter(asistente => asistente.id != convocado.id);
        //         }
        //         return convocado;
        // });
        state.miembrosQueAsistieron = miembrosQueAsistieron;
    },
    colocarInvitadosExternosQueAsistieron(state, invitadosExternosQueAsistieron){
        // state.reunion.invitados = 
        //     state.reunion.invitados.map( invitado => {
        //         if ( invitadosExternosQueAsistieron.includes(invitado) ){
        //             invitado.asistio_invitado_externo = 1;
        //             invitadosExternosQueAsistieron = 
        //                 invitadosExternosQueAsistieron
        //                     .filter(asistente => asistente.id != invitado.id);
        //         }
        //         return invitado;
        // });
        state.invitadosExternosQueAsistieron = invitadosExternosQueAsistieron;
    },
    colocarReunion(state, reunion){
        state.reunion = reunion;
    },
    colocarEstadoReunion(state, estadoReunion){
        state.estadoReunion = estadoReunion;
    },
    colocarComentarioEnTema(state, {temaId, comentario}){
        state.reunion.temas = state.reunion.temas.map(tema => {
            if (tema.id == temaId) tema.comentario = comentario;
            return tema;
        });
    },
    colocarAcuerdoEnTema(state, acuerdo){
        state.reunion.temas = state.reunion.temas.map(tema => {
            if (tema.id == acuerdo.tema_id) tema.acuerdos.push(acuerdo);
            return tema;
        });
    },
    colocarNuevoAcuerdo(state, acuerdo){
        acuerdo.uuid = uuidv4();
        state.reunion
            .temas
            .filter(tema => tema.id == acuerdo.tema_id)[0]
            .acuerdos.push(acuerdo);
    },
    eliminarAcuerdo(state, {tema_id, uuid}){
        state.reunion
            .temas
            .filter(tema => tema.id == tema_id)[0]
            .acuerdos = state.reunion
                            .temas
                            .filter(tema => tema.id == tema_id)[0]
                            .acuerdos
                            .filter(acuerdo => acuerdo.uuid != uuid);
    },
};
