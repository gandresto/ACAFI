<template>
  <div class="container" v-if="reunion.id">
    <div class="row">
      <div class="col-sm-12 text-center">
        <h5>Academia de {{reunion.academia.nombre}}</h5>
        <h4>Minuta para la reunión del {{reunion.inicio | fecha}}</h4>
      </div>

      <!--  ----------- Lista de asistencia -------------- -->
      <div class="col-sm-12" v-if="reunion.convocados">
        <lista-de-asistencia></lista-de-asistencia>
      </div>
      
      <!--  ----------- Revisión de temas existentes en reunión -------------- -->
      <div class="col-sm-12" v-if="reunion.temas">
        <revision-de-temas></revision-de-temas>
      </div>
    </div>
  </div>
</template>

<script>
import { createNamespacedHelpers } from 'vuex'
const { mapGetters, mapActions } = createNamespacedHelpers('crearMinuta')
// import { mapActions, mapGetters, mapMutations } from "vuex";
import ESTADO_API from "../enum-estado-api";
import {format, parseISO} from 'date-fns';
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
    // console.log(this.reunionResource);
    // JSON.parseISO(this.reunionResource);
    this.ponerReunion(this.reunionResource);
    console.log();
  },
  methods: {
    ...mapActions(["ponerReunion"]),
    // ...mapMutations(["colocarReunion"]),
  },
  computed: {
    ...mapGetters(["reunion"])
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
