<template>
  <div class="my-2">
    <b-form-group>
      <label :for="'textarea-comentario-'+temaId">Comentarios generales</label>
      <b-form-textarea
        :id="'textarea-comentario-'+temaId"
        :name="'textarea-comentario-'+temaId"
        debounce="600"
        v-model="comentario"
        :state="comentario.length >= 10 && comentario.length <= 500"
        placeholder="Descripción breve de lo hablado en la reunión acerca de este tema..."
        @change="actualizarComentario()"
        rows="3"
        trim
      ></b-form-textarea>
      <small class="text-muted form-text">{{comentario.length}}/500</small>
    </b-form-group>

    <b-form-group>
      <b-form-checkbox v-model="generarAcuerdos" name="check-button" switch>
        <b>¿Se llegó a algún acuerdo referente a este tema?</b>
      </b-form-checkbox>
    </b-form-group>
    
    <!-- ------ Formulario para generar nuevos acuerdos ---------------  -->
    <div v-if="generarAcuerdos" class="container-fluid py-2">
      <div class="row form-group">
        <div class="col-sm-12">
          <b>Nuevo acuerdo</b>
        </div>
      </div>

      <!-- Input para Descripción del acuerdo  -->
      <div class="row form-group">
        <label
          :for="'descripcion-txt-'+temaId"
          class="col-sm-12 col-md-3 col-form-label text-md-right"
        >Acuerdo</label>
        <div class="col-sm-12 col-md-6">
          <b-form-input 
            :id="'descripcion-txt-'+temaId" 
            :name="'descripcion-txt-'+temaId" 
            v-model="descripcion"
            trim
          ></b-form-input>
        </div>
      </div>
  
      <!-- Barra de búsqueda para responsable del acuerdo  -->
      <div class="row form-group" v-if="mostrarBusqueda">
        <label
          :for="'responsable-txt-'+temaId"
          class="col-sm-12 col-md-3 col-form-label text-md-right"
        >Responsable</label>
        <div class="col-sm-12 col-md-6">
          <autocomplete
            :search="buscarResponsable"
            :id="'responsable-search-'+temaId" 
            placeholder="Buscar usuario"
            aria-label="Buscar usuario"
            :get-result-value="obtenerNombreCompleto"
            @submit="procesarResponsable"
          >
            <template #result="{ result, props }">
              <li v-bind="props" class="autocomplete-result">{{result | nombreCompleto}}</li>
            </template>
          </autocomplete>
    
        </div>
      </div>

      <!-- Input para producto esperado del acuerdo  -->
      <div class="row form-group">
        <label
          :for="'producto-esperado-txt'+temaId"
          class="col-sm-12 col-md-3 col-form-label text-md-right"
        >Resultado/Producto esperado</label>
        <div class="col-sm-12 col-md-6">
          <b-form-input
            :id="'producto-esperado-txt'+temaId"
            :name="'producto-esperado-txt'+temaId"
            v-model="productoEsperado"
            trim
          ></b-form-input>
        </div>
      </div>

      <!-- Input para fecha compromiso de resolución del acuerdo  -->
      <div class="row form-group">
        <label
          :for="'fecha-compromiso'+temaId"
          class="col-sm-12 col-md-3 col-form-label text-md-right"
        >Fecha compromiso de resolución</label>
        <v-datetime
          :input-id="'fecha-compromiso'+temaId"
          class="col-sm-12 col-md-6"
          type="date"
          :min-datetime="hoy"
          v-model="fechaCompromiso"
          :phrases="frases"
          input-class="form-control"
        >
        </v-datetime>
      </div>

      <!-- Botón para agregar el acuerdo  -->
      <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-3">
          <b-button variant="success" @click="agregarAcuerdo" :disabled="botonAgregarDeshabilitado">
            <i class="fa fa-plus mx-1" aria-hidden="true"></i> Agregar acuerdo
          </b-button>
        </div>
      </div>
    </div>

    <!-- ----------------- Lista de acuerdos generados ---------------  -->
    <div v-if="generarAcuerdos" class="container-fluid py-2">
      <b-row>
      <!-- <transition-group name="tarjeta-acuerdo" tag="b-row"> -->
        <b-col 
          sm="6" md="4" lg="3"
          v-for="(acuerdo, index) in listaDeAcuerdos" 
          :key="`tema-${temaId}-acuerdo-${index}`"
        >
          <div class="card fondo-rojo-claro">
            <div class="card-header">
              <b>Acuerdo {{index+1}}</b>
              <button type="button" class="close">×</button>
            </div>
            <div class="card-body">
              <h5 class="card-title">{{acuerdo.descripcion}}</h5>
              <p class="card-text"><b>Fecha comprimiso de resolución:</b> {{acuerdo.fecha_compromiso | fecha}}</p>
              <p class="card-text"><b>Resultado/producto esperado:</b> {{acuerdo.producto_esperado}}</p>
              <p class="card-text"><b>Responsable:</b> {{acuerdo.responsable_id}}</p>
            </div>
          </div>
        </b-col>
      </b-row>
      <!-- </transition-group> -->
    </div>
  </div>
</template>

<script>
import { createNamespacedHelpers } from 'vuex'
import {format, parseISO} from 'date-fns';
const { mapActions, mapGetters, mapMutations } = createNamespacedHelpers('crearMinuta')

export default {
  props: ["temaId"],
  mounted() {
    // console.log('Component mounted.')
  },
  data() {
    return {
      hoy: (new Date()).toISOString(),
      comentario: "",
      generarAcuerdos: false,
      mostrarBusqueda: true,
      descripcion: "",
      responsable: null,
      productoEsperado: "",
      fechaCompromiso: "",
      frases: {
        ok: "Aceptar",
        cancel: "Cancelar"
      },
    };
  },
  methods: {
    ...mapMutations(['colocarNuevoAcuerdo']),
    ...mapActions(['ponerComentarioEnTema']),

    actualizarComentario() {
      if (this.comentario.length >= 10 && this.comentario.length <= 500) {
        // console.log(this.temaId, this.comentario);
        this.ponerComentarioEnTema({
          temaId: this.temaId,
          comentario: this.comentario
        });
      }
    },

    // ------ Método para agregar acuerdo a la lista de acuerdos en el estado -----------
    agregarAcuerdo() {
      this.colocarNuevoAcuerdo(this.acuerdo);
      // Limpiar formulario
      this.descripcion = "";
      this.responsable = null;
      this.productoEsperado = "";
      this.fechaCompromiso = "";
      this.mostrarBusqueda = false;
      this.$nextTick(() => {
          this.mostrarBusqueda = true
      });
    },
    
    obtenerNombreCompleto(usuario) {
      return usuario.id ? `${usuario.apellido_paterno} ${usuario.apellido_materno} ${usuario.nombre} ${usuario.grado}` : '';
    },

    buscarResponsable(busqueda){
      let resultado = [this.reunion.academia.presidente, ...this.reunion.convocados];
      if(busqueda){
        busqueda = busqueda.toLowerCase()
        // Busco el nombre del presidente
        let resultadoPresidente = this.obtenerNombreCompleto(this.reunion.academia.presidente)
                                      .toLowerCase()
                                      .includes(busqueda) 
                                      ? [this.reunion.academia.presidente] : [];

        // Busco el nombre en los convocados
        let resultadoConvocados = this.reunion.convocados.filter(
          convocado => this.obtenerNombreCompleto(convocado).toLowerCase().includes(busqueda)
        )
        resultado = [...resultadoPresidente, ...resultadoConvocados];
      }
      return resultado;
    },
    procesarResponsable(responsable){
      this.responsable = responsable;
    },
    longitudDeCadenaValida(cadena){
      return cadena 
            ? (cadena.length > 3 && cadena.length < 191) 
            : false;
    }
  },
  computed: {
    ...mapGetters(['reunion', 'nuevosAcuerdos']),
    acuerdo(){
      return {
        tema_id: this.temaId,
        responsable_id: this.responsable ? (this.responsable.id ? this.responsable.id : null) : null,
        descripcion: this.descripcion,
        producto_esperado: this.productoEsperado,
        fecha_compromiso: this.fechaCompromiso,
      };
    },
    botonAgregarDeshabilitado(){
      return !(this.acuerdo.tema_id 
            && this.acuerdo.responsable_id
            && this.longitudDeCadenaValida(this.acuerdo.descripcion)
            && this.longitudDeCadenaValida(this.acuerdo.producto_esperado)
            && this.acuerdo.fecha_compromiso);
    },
    listaDeAcuerdos(){
      return this.nuevosAcuerdos.filter(acuerdo => acuerdo.tema_id == this.temaId);
    }
  },
  filters:{
    nombreCompleto: function (usuario) {
      return usuario.id ? `${usuario.apellido_paterno} ${usuario.apellido_materno} ${usuario.nombre} ${usuario.grado}` : '';
    },
    filters: {
      fecha: function (ISOstring) {
        return format(parseISO(ISOstring), 'd/m/y');
      }
    },
  },
};
</script>

<style lang="scss">
// @import './../../../sass/variables';
  // .tarjeta-acuerdo-item {
  //   background-color: rgba(52, 207, 52, 0.164);
  //   border-color: rgba(0, 189, 0, 0.12);
  // }
  // .tarjeta-acuerdo-enter-active, .tarjeta-acuerdo-leave-active {
  //   transition: all 2s;
  // }
  // .tarjeta-acuerdo-enter {
  //   // opacity: 0.5;
  //   background-color: rgba(52, 207, 52, 0.466);
  //   border-color: rgb(0, 189, 0);
  // }
  // .tarjeta-acuerdo-leave {
  //   background-color: rgba(255, 30, 30, 0.562);
  //   border-color: red;
  // }
  // .tarjeta-acuerdo-leave-to {
  //   opacity: 0;
  // }
</style>
