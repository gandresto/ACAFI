<template>
  <div>
    <!-- --------- Indicadores de carga y de error -----------  -->
    <div
      v-if="
                estadoAcademias == estadoApi.CARGANDO ||
                    estadoAcademias == estadoApi.INICIADO
            "
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
    <b-form v-if="estadoAcademias == estadoApi.LISTO" target="_blank">
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
    <!-- ----------- Formulario al seleccionar academia --------- -->
    <b-form v-if="academiaSeleccionada && estadoAcademia == estadoApi.LISTO" @submit="submitForm">
      <!-- ----------- Fecha y hora de inicio --------- -->
      <b-row>
        <v-datetime
          class="form-group col-md-12"
          input-id="fecha-inicio-input"
          type="datetime"
          :min-datetime="limiteInferiorFecha"
          v-model="fechaInicio"
          :phrases="frases"
          required="true"
          input-class="form-control"
        >
          <label for="fecha-inicio-input" slot="before">Fecha y hora de inicio</label>
        </v-datetime>
      </b-row>

      <!-- ----------- Fecha y hora de fin --------- -->
      <b-row v-if="fechaInicio">
        <v-datetime
          class="form-group col-md-12"
          input-id="fecha-fin-input"
          type="datetime"
          :min-datetime="fechaInicio"
          v-model="fechaFin"
          :phrases="frases"
          required="true"
          input-class="form-control"
        >
          <label for="fecha-fin-input" slot="before">Fecha y hora de finalizacion</label>
        </v-datetime>
      </b-row>

      <!-- ----------- Lugar --------- -->
      <b-form-group id="lugar" label="Lugar" label-for="text-lugar">
        <b-form-input id="text-lugar" v-model="lugar" type="text" required></b-form-input>
      </b-form-group>
      <hr />

      <!-- ----------- Convocados --------- -->
      <crear-reunion-agregar-convocados></crear-reunion-agregar-convocados>

      <!-- ----------- Invitados --------- -->
      <crear-reunion-agregar-invitados></crear-reunion-agregar-invitados>

      <!-- ----------- Temas por revisar --------- -->
      <crear-reunion-agregar-temas></crear-reunion-agregar-temas>

      <!-- -- Acuerdos de reuniones pasadas sin resolver -- -->
      <crear-reunion-tabla-acuerdos v-if="acuerdosPendientes.length > 0"></crear-reunion-tabla-acuerdos>

      <!-- ------- Botones de vista previa y enviar formulario ----- -->
      <b-form-group class="text-md-right">
        <b-button variant="secondary" @click="vistaPrevia">
          <div
            v-if="estadoVistaPrevia == estadoApi.CARGANDO"
            class="spinner-border spinner-border-sm mx-1"
            role="status"
          >
            <span class="sr-only">Cargando vista previa...</span>
          </div>Vista Previa de Orden del Día
        </b-button>
        <b-button type="submit" variant="primary">Crear Reunión</b-button>
      </b-form-group>
    </b-form>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import ESTADO_API from "../enum-estado-api";
import API from "../services/api";

export default {
  data() {
    return {
      academiaSeleccionada: null,
      fechaInicio: null,
      fechaFin: null,
      estadoApi: ESTADO_API,
      estadoVistaPrevia: ESTADO_API.INICIADO,
      limiteInferiorFecha: "",
      frases: {
        ok: "Aceptar",
        cancel: "Cancelar"
      },
      lugar: ""
    };
  },
  mounted() {
    let date = new Date();
    this.limiteInferiorFecha = date.toISOString();
    this.leerAcademiasQuePreside(Laravel.authUserId);
  },
  methods: {
    ...mapActions([
      "leerAcademiasQuePreside",
      "leerAcademia",
      "leerAcuerdosPendientes"
    ]),
    seleccionarAcademia() {
      if (this.academiaSeleccionada) {
        this.leerAcademia(this.academiaSeleccionada);
        this.leerAcuerdosPendientes(this.academiaSeleccionada);
      }
    },
    vistaPrevia(evt) {
      // evt.preventDefault();
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
          window.open(fileURL);
          //   console.log(data);
        })
        .catch(err => {
          this.estadoVistaPrevia = ESTADO_API.ERROR;
          if (err.response) {
            // console.log(err.response);
            // console.log(err.response.data);
            const data = new Blob([err.response.data], {
              type: "application/json"
            });
            let fr = new FileReader();
            fr.onload = function() {
              console.log(JSON.parse(this.result));
            };
            fr.readAsText(data);
            // console.log(data);
            //   console.log(error.message)
          } else console.log(err);
        });
    },
    submitForm(evt) {
      evt.preventDefault();
      // this.estadoVistaPrevia = ESTADO_API.CARGANDO;
      let url = API.baseURL + "/reuniones/";
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
      axios
        .post(url, data)
        .then(r => r.data)
        .then(data => {
          console.log(data);
        })
        .catch(error => {
          if (error.response) {
            /*
             * The request was made and the server responded with a
             * status code that falls out of the range of 2xx
             */
            console.log(error.response.data);
            // console.log(error.response.status);
            // console.log(error.response.headers);
            // if (error.response.status == 404) {
            //   this.error = error.response.data.message;
            // } else this.error = error.message;
          } else if (error.request) {
            /*
             * The request was made but no response was received, `error.request`
             * is an instance of XMLHttpRequest in the browser and an instance
             * of http.ClientRequest in Node.js
             */
            console.log(error.request);
            // this.error = error.message;
          } else {
            // Something happened in setting up the request and triggered an Error
            console.log("Error: ", error.message);
            // this.error = error.message;
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
      "acuerdosARevision"
    ]),
    cAcademias() {
      return this.academias || null;
    }
  }
};
</script>
