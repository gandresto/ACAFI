<template>
  <div class="container">
    <aviso-error 
        v-if="error"
        :error="error">
    </aviso-error>

    <!-- ----------- Formulario para crear la reunión (desplegable al seleccionar academia) --------- -->
    <b-form @submit.prevent="submitForm">
      <div class="row">
        <!-- ----------- Fecha y hora de inicio --------- -->
        <div class="col-sm-12 col-md-6">
          <div class="form-group">
            <label for="fecha-inicio">Fecha y hora de inicio <span class="text-danger">*</span></label>
            <date-picker 
              id="fecha-inicio"
              name="fecha-inicio" 
              :class="claseValidacion('inicio')"
              required="true"
              v-model="inicio" :config="optionsPickerInicio"
              @dp-change="horaInicioCambio"
            >
            </date-picker>
            <span v-if="tieneError('inicio')" class="invalid-feedback" role="alert">
              <strong>{{erroresDeValidacion.inicio[0]}}</strong>
            </span>
          </div>
        </div>

        <!-- ----------- Fecha y hora de fin --------- -->
        <div class="col-sm-12 col-md-6">
          <div class="form-group">
            <label for="fecha-fin">Fecha y hora de finalización <span class="text-danger">*</span></label>
            <date-picker
              id="fecha-fin"
              name="fecha-fin" 
              v-model="fin" :config="optionsPickerFin"
            >
            </date-picker>
            <span v-if="tieneError('fin')" class="invalid-feedback" role="alert">
              <strong>{{erroresDeValidacion.fin[0]}}</strong>
            </span>
          </div>
        </div>
      </div>

      <!-- ----------- Lugar --------- -->
      <div class="form-group">
        <label for="text-lugar">Lugar <span class="text-danger">*</span></label>
        <b-form-input id="text-lugar" v-model="lugar" type="text" required :class="claseValidacion('lugar')"></b-form-input>
        <span v-if="tieneError('lugar')" class="invalid-feedback" role="alert">
          <strong>{{erroresDeValidacion.lugar[0]}}</strong>
        </span>
      </div>
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
      <tabla-acuerdos v-if="academia && academia.acuerdosPendientes.length > 0"></tabla-acuerdos>

      <!-- ------- Botones de vista previa y enviar formulario ----- -->
      <div class="form-group text-md-right">
        <b-button variant="secondary" @click="vistaPrevia">
          <div
            v-if="estadoVistaPrevia == ESTADO_API.CARGANDO"
            class="spinner-border spinner-border-sm mx-1"
            role="status"
          >
            <span class="sr-only">Cargando vista previa...</span>
          </div>
          Generar vista previa de Orden del Día
        </b-button>
        <b-button :disabled="estadoVistaPrevia != ESTADO_API.LISTO"
          variant="danger" 
          :href="urlVistaPrevia"
          target="__blank"
        >
          <i v-if="estadoVistaPrevia == ESTADO_API.ERROR" 
            class="fa fa-times mr-1" 
            aria-hidden="true"
          >
            <span class="sr-only">Error al cargar vista previa...</span>
          </i>
          <i class="fas fa-file-pdf mr-1"></i>
          Vista Previa
        </b-button>
        <b-button type="submit" variant="primary" :disabled="estadoCreacionReunion == ESTADO_API.CARGANDO">
          <div
            v-if="estadoCreacionReunion == ESTADO_API.CARGANDO"
            class="spinner-border spinner-border-sm mx-1"
            role="status"
          ><span class="sr-only">Creando reunión...</span>
          </div>
          <i class="fa fa-calendar-check mr-1"></i>
          Crear Reunión
        </b-button>
      </div>
    </b-form>
  </div>
</template>

<script>
import ESTADO_API from "../../../enum-estado-api";
import API from "../../../services/api";

import { mapGetters, mapActions, mapMutations } from 'vuex';
import { set } from 'vue';

export default {
  props: ['academia-prop'],
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
      },
      inicio: "",
      fin: "",
      lugar: "",
      ESTADO_API,
      estadoVistaPrevia: ESTADO_API.INICIADO,
      estadoCreacionReunion: ESTADO_API.INICIADO,
      error: "",
      urlVistaPrevia: "#",
    };
  },
  mounted() {
    // let academia = JSON.parse(this.academiaProp);
    this.colocarAcademia(this.academiaProp);
    window.onbeforeunload = () => '¿Deseas salir? Puede que los cambios no se hayan guardado';
  },
  methods: {
    ...mapMutations(['colocarErroresDeValidacion', 'colocarAcademia']),
    tieneError(campo) {
      return this.erroresDeValidacion[campo] ? true : false;
    },
    claseValidacion(campo) {
      return "form-control" + (this.tieneError(campo) ? " is-invalid" : "");
    },
    horaInicioCambio({date}) { // date: fecha a la que cambió el evento
      // console.log(date);
      // set(this, 'fin', date.add(28, 'minutes'));
      set(this.optionsPickerFin, 'minDate', date);      
      // console.log(this.fin)
    },
    vistaPrevia(evt) {
      // Variables para monitorear estado del servidor
      this.estadoVistaPrevia = ESTADO_API.CARGANDO;
      // Limpiar campo de error
      this.error = "";
      // Preparar url y datos para enviarlos a backend
      let url = API.baseURL + "/reuniones/crearPDFOrdenDelDia";
      let data = this.prepararDatosParaEnvio();
      axios({
        method: "post",
        responseType: "blob",
        url,
        data: {data},
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
          window.scrollTo(0,0);
          this.estadoVistaPrevia = ESTADO_API.ERROR;
          if (err.response){
            // Convertir de blob a string
            err.response.data.text().then(datosStr=>{
              let datosObj = JSON.parse(datosStr);
              if(err.response.status == 422){
                console.log(datosObj.errors);
                this.colocarErroresDeValidacion(datosObj.errors);
                this.error = "Error: revisa tu formulario y corrige los campos que contengan errores.";
              } else {
                console.log(datosObj);
              }
            });
          } 
          else{
            this.error = "Error con la conexión al servidor, intente de nuevo más tarde.";
          } console.log(err);
        });
    },
    submitForm(evt) {
      window.onbeforeunload = null;
      if( ! confirm('¿Deseas agendar la reunión? Esto enviará '+
                  'invitaciones por correo a todos los convocados ' + 
                  'y generará el PDF de la orden del día.') )
        return false;
      // Variables de estado
      this.estadoCreacionReunion = ESTADO_API.CARGANDO;
      // Limpiar errores
      this.error = "";
      // Preparar url y datos para enviarlos a backend
      let url = API.baseURL + "/reuniones";
      let data = this.prepararDatosParaEnvio();
      // Enviar peticion
      axios
        .post(url, {data})
        .then(r => r.data)
        .then(data => {
          this.estadoCreacionReunion = ESTADO_API.LISTO;
          alert(data.message);
          window.location = process.env.MIX_APP_URL+'/reuniones';
        })
        .catch(error => {
          window.scrollTo(0,0);
          window.onbeforeunload = () => '¿Deseas salir? Puede que los cambios no se hayan guardado';
          if (error.response) {
            this.estadoCreacionReunion = ESTADO_API.ERROR;
            /*
             * The request was made and the server responded with a
             * status code that falls out of the range of 2xx
             */
            if(error.response.status == 422){
              this.colocarErroresDeValidacion(error.response.data.errors);
              this.error = "Error: revisa tu formulario y corrige los campos que contengan errores.";
            } else { 
              this.error = error.message
            };
            console.log(error.response.data);

          } else if (error.request) {
            /*
             * The request was made but no response was received, `error.request`
             * is an instance of XMLHttpRequest in the browser and an instance
             * of http.ClientRequest in Node.js
             */
            console.log(error.request);
            this.error = "Error en la conexión al servidor. Intente de nuevo más tarde.";
          } else {
            // Something happened in setting up the request and triggered an Error
            this.error = "Ocurrió un error inesperado. Intente de nuevo más tarde.";
            console.log(error);
          }
        });
    },
    prepararDatosParaEnvio(){
      let data = {
        academia_id: this.academia.id,
        inicio: this.inicio,
        fin: this.fin,
        lugar: this.lugar,
        convocados: this.convocados,
        invitados: this.invitados,
        temas: this.temas,
        acuerdosASeguimiento: this.acuerdosASeguimiento
      };
      return JSON.stringify(data);
    },
  },
  computed: {
    ...mapGetters([
      "academia",
      "estadoAcademia",
      "convocados",
      "invitados",
      "temas",
      "acuerdosASeguimiento",
      "erroresDeValidacion",
    ]),
  }
};
</script>
