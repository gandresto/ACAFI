import { uuidv4} from '../../helpers';

export default {
    colocarAsistentes(state, asistentes){
        state.asistentes = asistentes;
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
        state.nuevosAcuerdos.push(acuerdo);
    },
    eliminarAcuerdoPorUUID(state, uuid){
        state.nuevosAcuerdos = state.nuevosAcuerdos.filter(acuerdo => acuerdo.uuid != uuid); 
    },
};
