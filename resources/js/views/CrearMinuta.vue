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
      <div class="col-sm-12" v-if="reunion.convocados">
        <lista-de-asistencia></lista-de-asistencia>
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
  },
  methods: {
    ...mapActions(["ponerReunion"]),
    enviarFormulario(){
      let asistentes_ids = this.asistentes ?
                          this.asistentes.map(asistente => asistente.id) :
                          [];
      let data = JSON.stringify({
        temas: this.reunion.temas,
        asistentes_ids,
      });
      let url = `${api.baseURL}/reuniones/${this.reunion.id}/minuta`;
      axios
        .post(url, {data})
        .then(data => data.data)
        .then(data => {
          console.log(data);
        })
        .catch(error => {
          if(error.response){
            console.log(error.response);
          } else{
            console.log(error);
          }
        })
    },
  },
  computed: {
    ...mapGetters(['reunion', 'asistentes'])
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
