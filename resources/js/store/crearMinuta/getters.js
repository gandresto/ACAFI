export default {
    miembrosQueAsistieron: state => state.miembrosQueAsistieron,
    invitadosExternosQueAsistieron: state => state.invitadosExternosQueAsistieron,
    reunion: state => state.reunion,
    acuerdosPorTemaId: state => tema_id => state.reunion.temas.find(tema => tema.id == tema_id).acuerdos,
    estadoReunion: state=> state.estadoReunion,
}
