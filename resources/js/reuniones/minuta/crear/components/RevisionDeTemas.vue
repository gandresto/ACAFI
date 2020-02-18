<template>
  <div>
    <div class="small-title">Temas que se trataron en la reunión</div>
    <ol>
      <li class="pt-3" v-for="(tema, index) in reunion.temas" :key="tema.id">
        {{tema.descripcion}}
        <br />
        <aviso-error 
          v-if="tieneError(`temas.${index}.comentario`)"
          :error="erroresDeValidacion[`temas.${index}.comentario`][0]">
        </aviso-error>
        <agregar-detalles
          :temaId="tema.id"
          :comentarioProp="tema.comentario"
        ></agregar-detalles>

      </li>
      <!-- <div>
        <b>Agregar nuevo tema</b>
      </div>
      <li>
        :D
      </li> -->
    </ol>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import AgregarDetalles from "./RevisionDeTemasAgregarDetalles.vue";

export default {
  components:{
    'agregar-detalles': AgregarDetalles,
  },
  mounted() {
    // console.log('Component mounted.')
    
  },
  data() {
    return {
      // comentario: '',
      // generarAcuerdos: false,
    };
  },
  methods: {
    // ...mapMutations(["colocarAsistentes"]),
    ...mapActions(['ponerComentario']),

    tieneError(campo) {
      return this.erroresDeValidacion[campo] ? true : false;
    },    
  },
  computed: {
    ...mapGetters(['reunion', 'erroresDeValidacion'])
  }
};
</script>
