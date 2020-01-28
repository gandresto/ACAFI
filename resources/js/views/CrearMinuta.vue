<template>
  <div class="container" v-if="reunion.id">
    <div class="row">
      <div class="col-sm-12 text-center">
        <h5>Academia de {{reunion.academia.nombre}}</h5>
        <h4>Minuta para la reunión del {{reunion.inicio | fecha}}</h4>
      </div>
      <div class="col-sm-12" v-if="reunion.convocados">
        <minuta-lista-de-asistencia></minuta-lista-de-asistencia>
      </div>
      <div class="col-sm-12" v-if="reunion.temas">
        <div class="small-title">
          Temas que se trataron en la reunión
        </div>
        <ol>
          <li v-for="tema in reunion.temas" :key="tema.id">
            {{tema.descripcion}} <br>
          </li>
        </ol>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
import ESTADO_API from "../enum-estado-api";
import {format, parseISO} from 'date-fns';
import MinutaListaDeAsistencia from '../components/MinutaListaDeAsistencia.vue'

export default {
  components: {
    'minuta-lista-de-asistencia' : MinutaListaDeAsistencia,
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
    this.colocarReunion(this.reunionResource);
    console.log();
  },
  methods: {
    // ...mapActions(["ponerReunion"]),
    ...mapMutations(["colocarReunion"]),
  },
  computed: {
    ...mapGetters(["reunion"])
  },
  filters: {
    fecha: function (ISOstring) {
      return format(parseISO(ISOstring), 'd/m/y');
    }
  }
};
</script>
<style lang="css">

</style>
