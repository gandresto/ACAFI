<template>
  <b-form 
    id="form-crear-minuta"
    v-if="reunion.id" 
    @submit.prevent="enviarFormulario" 
  >
    <aviso-error 
        v-if="estadoCreacionDeMinuta == estadoApi.ERROR"
        :error="errorMsg">
    </aviso-error>

    <!-- @keydown.ctrl.83.prevent.stop="saluda" -->
    <div class="form-group row">
      <div class="col-sm-12 text-center">
        <h5>Academia de {{reunion.academia.nombre}}</h5>
        <h4>Minuta para la reunión del {{reunion.inicio | fecha}}</h4>
      </div>
    </div>
    
    <aviso-error 
      v-if="tieneError('miembros_que_asistieron_ids')"
      :error="erroresDeValidacion.miembros_que_asistieron_ids[0]">
    </aviso-error>
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

    <!--  ----------- Seguimiento a acuerdos -------------- -->
    <div class="form-group row">
      <div class="col-sm-12" v-if="reunion.acuerdos_a_seguimiento">
        <seguimiento-a-acuerdos></seguimiento-a-acuerdos>
      </div>
    </div>

    <!--  ----------- Botones -------------- -->
    <div class="form-group row">
      <div class="col-sm-12 text-md-right">
        <b-button type="submit" variant="primary" :disabled="estadoCreacionDeMinuta == estadoApi.CARGANDO">
          <div
            v-if="estadoCreacionDeMinuta == estadoApi.CARGANDO"
            class="spinner-border spinner-border-sm mx-1"
            role="status"
          ><span class="sr-only">Creando minuta...</span>
          </div>
          Crear Minuta
        </b-button>
        <!-- <b-button type="submit" variant="primary">Crear Minuta</b-button> -->
      </div>
    </div>
  </b-form>
</template>

<script>
import ESTADO_API from "../enum-estado-api";
import api from "../services/api";
import {format, parseISO} from 'date-fns';

import { createNamespacedHelpers } from 'vuex'
const { mapGetters, mapActions, mapMutations } = createNamespacedHelpers('crearMinuta')
import ListaDeAsistencia from '../components/CrearMinuta/ListaDeAsistencia.vue'
import RevisionDeTemas from '../components/CrearMinuta/RevisionDeTemas.vue'
import SeguimientoAAcuerdos from '../components/CrearMinuta/SeguimientoAAcuerdos.vue'

export default {
  components: {
    'lista-de-asistencia' : ListaDeAsistencia,
    'revision-de-temas' : RevisionDeTemas,
    'seguimiento-a-acuerdos' : SeguimientoAAcuerdos,
  },
  props: ['reunion-resource'],
  data() {
    return {
      estadoApi : ESTADO_API,
      errorMsg: "",
      estadoCreacionDeMinuta: ESTADO_API.INICIADO,
    }
  },
  mounted() {
    this.ponerReunion(this.reunionResource);
    window.onbeforeunload = () => '¿Deseas salir? Puede que los cambios no se hayan guardado';
    // this.$nextTick(function(){
    //   $('#form-crear-minuta').focus();
    // });
  },
  methods: {
    ...mapMutations(["colocarErroresDeValidacion"]),
    ...mapActions(["ponerReunion"]),
    
    enviarFormulario(){
      this.estadoCreacionDeMinuta = ESTADO_API.CARGANDO;
      this.errorMsg = "";
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
          this.estadoCreacionDeMinuta = ESTADO_API.LISTO;
        })
        .catch(error => {
          window.scrollTo(0,0);
          window.onbeforeunload = () => '¿Deseas salir? Puede que los cambios no se hayan guardado.';
          if(error.response){
            console.log(error.response);
            this.estadoCreacionDeMinuta = ESTADO_API.ERROR;
            if( error.response.status = 422){
              this.errorMsg = "Corrige los errores del formulario e intenta de nuevo.";
              this.colocarErroresDeValidacion(error.response.data.errors);
            } else{
              this.errorMsg = "Ocurrió un error, intenta de nuevo más tarde.";
            }
          } else{
            console.log(error);
            this.errorMsg = "Ocurrió un error, intenta de nuevo más tarde.";
            this.estadoCreacionDeMinuta = ESTADO_API.ERROR;
          }
        })
    },

    tieneError(campo) {
      return this.erroresDeValidacion[campo] ? true : false;
    },
    // saluda(evt){
    //   evt.preventDefault();
    //   console.log(evt);
    // },
  },
  computed: {
    ...mapGetters([
      'reunion', 
      'miembrosQueAsistieron', 
      'invitadosExternosQueAsistieron',
      'erroresDeValidacion'
      ])
  },
  filters: {
    fecha: function (ISOstring) {
      return format(parseISO(ISOstring), 'dd/MM/y');
    }
  }
};
</script>
