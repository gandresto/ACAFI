<template>
  <div>
    <div class="small-title">Temas que se trataron en la reunión</div>
    <ol>
      <li class="pt-3" v-for="tema in temas" :key="tema.id">
        {{tema.descripcion}}
        <br />

        <agregar-detalles
          :temaId="tema.id"
        ></agregar-detalles>

      </li>
    </ol>
  </div>
</template>

<script>
import { createNamespacedHelpers } from 'vuex'
const { mapGetters, mapActions } = createNamespacedHelpers('crearMinuta')
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
      comentario: '',
      // generarAcuerdos: false,
    };
  },
  methods: {
    // ...mapMutations(["colocarAsistentes"]),
    ...mapActions(['ponerComentario'])
    
  },
  computed: {
    ...mapGetters(['temas'])
  }
};
</script>
