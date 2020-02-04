<template>
  <div class="container">
    <!-- --------- Indicadores de carga y de error -----------  -->
    <div
      v-if="estadoAcademias == estadoApi.CARGANDO ||
            estadoAcademias == estadoApi.INICIADO"
      class="d-flex justify-content-center"
    >
      <div class="spinner-border" role="status">
        <span class="sr-only">Cargando...</span>
      </div>
    </div>
    <div v-if="estadoAcademias == estadoApi.ERROR" class="alert alert-danger">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>Hubo un problema, intenta de nuevo más tarde</strong>
    </div>
    <!-- --------- Formulario para seleccionar academia --------------- -->
    <b-form v-if="estadoAcademias == estadoApi.LISTO">
      <b-form-group id="academia" label="Academia" label-for="select-academia">
        <select
          class="form-control"
          id="select-academia"
          v-model="academiaSeleccionada"
          @change="seleccionarAcademia"
        >
          <option disabled selected value>Seleccione una academia</option>
          <option
            v-for="academia in cAcademias"
            :key="academia.id"
            :value="academia.id"
          >{{ academia.nombre }}</option>
        </select>
      </b-form-group>
    </b-form>

    <!-- --------- Indicadores de carga y de error -----------  -->
    <div v-if="estadoAcademia == estadoApi.CARGANDO" class="d-flex justify-content-center">
      <div class="spinner-border" role="status">
        <span class="sr-only">Cargando...</span>
      </div>
    </div>
    <div v-if="estadoAcademia == estadoApi.ERROR" class="alert alert-danger">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>Hubo un problema, intenta de nuevo más tarde</strong>
    </div>
    <!-- ----------- Formulario para crear la reunión (desplegable al seleccionar academia) --------- -->
    <b-form v-if="academiaSeleccionada && estadoAcademia == estadoApi.LISTO" @submit="submitForm">
      <b-row>
        <!-- ----------- Fecha y hora de inicio --------- -->
        <div class="col-sm-12 col-md-6">
          <div class="form-group">
            <label for="fecha-inicio">Fecha y hora de inicio *</label>
            <date-picker 
              id="fecha-inicio"
              name="fecha-inicio" 
              :class="claseValidacion('fechaInicio')"
              required="true"
              v-model="fechaInicio" :config="optionsPickerInicio"
              @dp-change="horaInicioCambio"
            >
            </date-picker>
            <span v-if="tieneError('fechaInicio')" class="invalid-feedback" role="alert">
              <strong>{{erroresDeValidacion.fechaInicio[0]}}</strong>
            </span>
          </div>
        </div>

        <!-- ----------- Fecha y hora de fin --------- -->
        <div class="col-sm-12 col-md-6" v-if="fechaInicio">
          <div class="form-grou">
            <label for="fecha-fin">Fecha y hora de finalización *</label>
            <date-picker
              id="fecha-fin"
              name="fecha-fin" 
              v-model="fechaFin" :config="optionsPickerFin"
            >
            </date-picker>
            <span v-if="tieneError('fechaFin')" class="invalid-feedback" role="alert">
              <strong>{{erroresDeValidacion.fechaFin[0]}}</strong>
            </span>
          </div>
        </div>
      </b-row>

      <!-- ----------- Lugar --------- -->
      <b-form-group id="lugar" label="Lugar *" label-for="text-lugar">
        <b-form-input id="text-lugar" v-model="lugar" type="text" required :class="claseValidacion('lugar')"></b-form-input>
        <span v-if="tieneError('lugar')" class="invalid-feedback" role="alert">
          <strong>{{erroresDeValidacion.lugar[0]}}</strong>
        </span>
      </b-form-group>
      <hr />

      <aviso-error 
        v-if="tieneError('convocados')"
        :error="erroresDeValidacion.convocados[0]">
      </aviso-error>
      <!-- ----------- Convocados --------- -->
      <agregar-convocados></agregar-convocados>

      <aviso-error 
        v-if="tieneError('invitados')"
        :error="erroresDeValidacion.convocados[0]">
      </aviso-error>
      <!-- ----------- Invitados --------- -->
      <agregar-invitados></agregar-invitados>

      <aviso-error 
        v-if="tieneError('temas')"
        :error="erroresDeValidacion.temas[0]">
      </aviso-error>
      <!-- ----------- Temas por revisar --------- -->
      <agregar-temas></agregar-temas>

      <aviso-error 
        v-if="tieneError('acuerdos')"
        :error="erroresDeValidacion.acuerdos[0]">
      </aviso-error>
      <!-- -- Acuerdos de reuniones pasadas sin resolver -- -->
      <tabla-acuerdos v-if="acuerdosPendientes.length > 0"></tabla-acuerdos>

      <!-- ------- Botones de vista previa y enviar formulario ----- -->
      <b-form-group class="text-md-right">
        <b-button variant="secondary" @click="vistaPrevia">
          <div
            v-if="estadoVistaPrevia == estadoApi.CARGANDO"
            class="spinner-border spinner-border-sm mx-1"
            role="status"
          >
            <span class="sr-only">Cargando vista previa...</span>
          </div>
          Generar vista previa de Orden del Día
        </b-button>
        <b-button :disabled="estadoVistaPrevia != estadoApi.LISTO"
          variant="danger" 
          :href="urlVistaPrevia"
          target="__blank"
        >
          <i v-if="estadoVistaPrevia == estadoApi.ERROR" 
            class="fa fa-times mr-1" 
            aria-hidden="true"
          >
            <span class="sr-only">Error al cargar vista previa...</span>
          </i>
          <i class="fas fa-file-pdf mr-1"></i>
          Vista Previa
        </b-button>
        <b-button type="submit" variant="primary">
          <div
            v-if="estadoCreacionReunion == estadoApi.CARGANDO"
            class="spinner-border spinner-border-sm mx-1"
            role="status"
          ><span class="sr-only">Creando reunión...</span>
          </div>
          <i class="fa fa-calendar-check mr-1"></i>
          Crear Reunión
        </b-button>
      </b-form-group>
      <aviso-error 
        v-if="hayErrorDeValidacion"
        :error="'Error: revisa tu formulario y corrige los campos que tienen errores'">
      </aviso-error>
    </b-form>
  </div>
</template>

<script>
import ESTADO_API from "../enum-estado-api";
import API from "../services/api";

import {set} from 'vue';
import { createNamespacedHelpers } from 'vuex';
const { mapGetters, mapActions, mapMutations } = createNamespacedHelpers('crearReunion');

import AgregarInvitados from './../components/CrearReunion/AgregarInvitados.vue';
import AgregarConvocados from './../components/CrearReunion/AgregarConvocados.vue';
import TablaAcuerdos from './../components/CrearReunion/TablaAcuerdos.vue';
import AgregarTemas from './../components/CrearReunion/AgregarTemas.vue';

export default {
  components: {
    'agregar-invitados' : AgregarInvitados,
    'agregar-convocados' : AgregarConvocados,
    'tabla-acuerdos' : TablaAcuerdos,
    'agregar-temas' : AgregarTemas,
  },
  data() {
    return {
      optionsPickerInicio: {
        locale: "es",
        daysOfWeekDisabled: [0],
        disabledHours: [0, 1, 2, 3, 4, 5, 21, 22, 23, 24],
        stepping: 15,
        sideBySide: true,
        showClose: true,
        minDate: moment(),
      },
      optionsPickerFin: {
        locale: "es",
        daysOfWeekDisabled: [0],
        disabledHours: [0, 1, 2, 3, 4, 5, 6, 22, 23, 24],
        stepping: 15,
        sideBySide: true,
        showClose: true,
        minDate: moment(),
        maxDate: false,
      },
      academiaSeleccionada: null,
      fechaInicio: null,
      fechaFin: null,
      estadoApi: ESTADO_API,
      estadoVistaPrevia: ESTADO_API.INICIADO,
      estadoCreacionReunion: ESTADO_API.INICIADO,
      limiteInferiorFecha: "",
      frases: {
        ok: "Aceptar",
        cancel: "Cancelar"
      },
      lugar: "",
      urlVistaPrevia: "#",
      hayErrorDeValidacion: false,
    };
  },
  mounted() {
    let date = new Date();
    this.limiteInferiorFecha = date.toISOString();
    this.leerAcademiasQuePreside(Laravel.authUserId);
  },
  methods: {
    ...mapMutations(['colocarErroresDeValidacion']),
    ...mapActions([
      "leerAcademiasQuePreside",
      "leerAcademia",
      "leerAcuerdosPendientes"
    ]),
    tieneError(campo) {
      return this.erroresDeValidacion[campo] ? true : false;
    },
    claseValidacion(campo) {
      return "form-control" + (this.tieneError(campo) ? " is-invalid" : "");
    },
    seleccionarAcademia() {
      if (this.academiaSeleccionada) {
        this.leerAcademia(this.academiaSeleccionada);
        this.leerAcuerdosPendientes(this.academiaSeleccionada);
        window.onbeforeunload = () => '¿Deseas salir? Puede que los cambios no se hayan guardado';
      }
    },
    horaInicioCambio({date}) { // date: fecha a la que cambió el evento
      // console.log(date);
      set(this, 'fechaFin', date.add(1, 'h'));
      set(this.optionsPickerFin, 'minDate', date);      
      // console.log(this.fin)
    },
    vistaPrevia(evt) {
      // evt.preventDefault();
      this.hayErrorDeValidacion = false;
      this.estadoVistaPrevia = ESTADO_API.CARGANDO;
      let url = API.baseURL + "/reuniones/crearPDFOrdenDelDia";
      // alert(url);
      let data = {
        academia_id: this.academia.id,
        fechaInicio: this.fechaInicio,
        fechaFin: this.fechaFin,
        lugar: this.lugar,
        convocados: this.convocados,
        invitados: this.invitados,
        temas: this.temas,
        acuerdosARevision: this.acuerdosARevision
      };
      axios({
        method: "post",
        responseType: "blob",
        url,
        data
      })
        .then(r => r.data)
        .then(data => {
          this.estadoVistaPrevia = ESTADO_API.LISTO;
          //Create a Blob from the PDF Stream
          const file = new Blob([data], { type: "application/pdf" });
          //Build a URL from the file
          const fileURL = URL.createObjectURL(file);
          //Open the URL on new Window
          this.urlVistaPrevia = fileURL;
        })
        .catch(err => {
          this.estadoVistaPrevia = ESTADO_API.ERROR;
          if (err.response){
            err.response.data.text().then(datosStr=>{
              let datosObj = JSON.parse(datosStr);
              if(err.response.status == 422){
                this.colocarErroresDeValidacion(datosObj.errors);
                this.hayErrorDeValidacion = true;
              } else {
                console.log(datosObj);
              }
            });
          } 
          else console.log(err);
        });
    },
    submitForm(evt) {
      this.hayErrorDeValidacion = false;
      evt.preventDefault();
      this.estadoCreacionReunion = ESTADO_API.CARGANDO;
      let url = API.baseURL + "/reuniones/";
      let data = {
        academia_id: this.academia.id,
        fechaInicio: this.fechaInicio,
        fechaFin: this.fechaFin,
        lugar: this.lugar,
        convocados: this.convocados,
        invitados: this.invitados,
        temas: this.temas,
        acuerdosARevision: this.acuerdosARevision
      };
      axios
        .post(url, data)
        .then(r => r.data)
        .then(data => {
          this.estadoCreacionReunion = ESTADO_API.LISTO;
          window.onbeforeunload = null;
          alert('Reunión creada satisfactoriamente');
          window.location = process.env.MIX_APP_URL+'/reuniones';
        })
        .catch(error => {
          window.onbeforeunload = () => '¿Deseas salir? Puede que los cambios no se hayan guardado';
          if (error.response) {
            this.estadoCreacionReunion = ESTADO_API.ERROR;
            /*
             * The request was made and the server responded with a
             * status code that falls out of the range of 2xx
             */
            if(error.response.status = 422){
              this.colocarErroresDeValidacion(error.response.data.errors);
              this.hayErrorDeValidacion = true;
            }
            else this.error = error.message;
            console.log(error.response.data);
          } else if (error.request) {
            /*
             * The request was made but no response was received, `error.request`
             * is an instance of XMLHttpRequest in the browser and an instance
             * of http.ClientRequest in Node.js
             */
            console.log(error.request);
          } else {
            // Something happened in setting up the request and triggered an Error
            console.log(error);
          }
        });
    }
  },
  computed: {
    ...mapGetters([
      "academias",
      "estadoAcademias",
      "academia",
      "estadoAcademia",
      "convocados",
      "invitados",
      "temas",
      "acuerdosPendientes",
      "acuerdosARevision",
      "erroresDeValidacion",
    ]),
    cAcademias() {
      return this.academias || null;
    }
  }
};
</script>
