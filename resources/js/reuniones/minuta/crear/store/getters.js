export default {
    miembrosQueAsistieron: state => state.miembrosQueAsistieron,
    invitadosExternosQueAsistieron: state => state.invitadosExternosQueAsistieron,
    reunion: state => state.reunion,
    acuerdosASeguimiento: state => state.reunion.acuerdos_a_seguimiento,
    acuerdosPorTemaId: state => tema_id => state.reunion.temas.find(tema => tema.id == tema_id).acuerdos,
    estadoReunion: state=> state.estadoReunion,
    erroresDeValidacion: state => state.erroresDeValidacion,
}
