<template>
  <b-form v-if="reunion.id" @submit.prevent="enviarFormulario">
    <div class="form-group row">
      <div class="col-sm-12 text-center">
        <h5>Academia de {{reunion.academia.nombre}}</h5>
        <h4>Minuta para la reunión del {{reunion.inicio | fecha}}</h4>
      </div>
    </div>
    
    <!--  ----------- Lista de asistencia -------------- -->
    <div class="form-group row">
      <div class="col-sm-12">
        <lista-de-asistencia 
          tipo-de-datos="conv"
          :datos="reunion.convocados"
        ></lista-de-asistencia>
      </div>
    </div>
  
    <!--  ----------- Lista de asistencia -------------- -->
    <div class="form-group row" v-if="reunion.invitadosExternos.length > 0">
      <div class="col-sm-12">
        <lista-de-asistencia 
          tipo-de-datos="inv"
          :datos="reunion.invitadosExternos"
        ></lista-de-asistencia>
      </div>
    </div>

    <!--  ----------- Revisión de temas existentes en reunión -------------- -->
    <div class="form-group row">
      <div class="col-sm-12" v-if="reunion.temas">
        <revision-de-temas></revision-de-temas>
      </div>
    </div>

    <!--  ----------- Revisión de temas existentes en reunión -------------- -->
    <div class="form-group row">
      <div class="col-sm-12 text-md-right">
        <b-button type="submit" variant="primary">Crear Minuta</b-button>
      </div>
    </div>

  </b-form>
</template>

<script>
import ESTADO_API from "../enum-estado-api";
import api from "../services/api";
import {format, parseISO} from 'date-fns';

import { createNamespacedHelpers } from 'vuex'
const { mapGetters, mapActions } = createNamespacedHelpers('crearMinuta')
import ListaDeAsistencia from '../components/CrearMinuta/ListaDeAsistencia.vue'
import RevisionDeTemas from '../components/CrearMinuta/RevisionDeTemas.vue'

export default {
  components: {
    'lista-de-asistencia' : ListaDeAsistencia,
    'revision-de-temas' : RevisionDeTemas,
  },
  props: ['reunion-resource'],
  data() {
    return {
      estadoApi : ESTADO_API,
    }
  },
  mounted() {
    this.ponerReunion(this.reunionResource);
    window.onbeforeunload = () => '¿Deseas salir? Puede que los cambios no se hayan guardado';
  },
  methods: {
    ...mapActions(["ponerReunion"]),
    enviarFormulario(){
      window.onbeforeunload = null;
      let miembros_que_asistieron_ids = this.miembrosQueAsistieron.length > 0 ?
                          this.miembrosQueAsistieron.map(asistente => asistente.id) :
                          [];
      let invitados_externos_que_asistieron_ids = this.invitadosExternosQueAsistieron.length > 0 ?
                          this.invitadosExternosQueAsistieron.map(asistente => asistente.id) :
                          [];
      let data = JSON.stringify({
        temas: this.reunion.temas,
        miembros_que_asistieron_ids,
        invitados_externos_que_asistieron_ids,
      });
      let url = `${api.baseURL}/reuniones/${this.reunion.id}/minuta`;
      axios
        .post(url, {data})
        .then(data => data.data)
        .then(data => {
          console.log(data);
        })
        .catch(error => {
          window.scrollTo(0,0);
          window.onbeforeunload = () => '¿Deseas salir? Puede que los cambios no se hayan guardado';
          if(error.response){
            console.log(error.response);
          } else{
            console.log(error);
          }
        })
    },
  },
  computed: {
    ...mapGetters(['reunion', 'miembrosQueAsistieron', 'invitadosExternosQueAsistieron'])
  },
  filters: {
    fecha: function (ISOstring) {
      return format(parseISO(ISOstring), 'dd/MM/y');
    }
  }
};
</script>
<style lang="css">

</style>
