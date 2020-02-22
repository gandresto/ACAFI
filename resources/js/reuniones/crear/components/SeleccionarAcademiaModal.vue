<template>
  <div>
    <b-button variant="primary" @click="abrirModal">
      <i class="fa fa-calendar-plus" aria-hidden="true"></i>
        <span class="ml-2">Agendar reunión</span>
    </b-button>

    <b-modal id="modal-seleccionar-academia" title="Agendar reunión">
      <template v-slot:default>
        <!--  ---------- Icono y mensaje de carga ------------ -->
        <div class="form-group text-center" v-if="estadoAcademias == ESTADO.CARGANDO">
          <div class="col-sm-12">
            <div class="spinner-border spinner-border-sm mx-1" role="status"></div>
          </div>
          <div class="col-sm-12">
            Cargando academias...
          </div>
        </div>
        <!--  ---------- Select academia ------------ -->
        <div class="form-group" v-if="estadoAcademias == ESTADO.LISTO">
          <label for="select-academia">Academia</label>
          <b-form-select
            v-model="academia_id"
            :options="academias"
            value-field="id"
            text-field="nombre"
            disabled-field="notEnabled"
          >
            <template v-slot:first>
              <b-form-select-option :value="null" disabled>-- Selecciona una academia --</b-form-select-option>
            </template>
          </b-form-select>
        </div>
      </template>
      <template v-slot:modal-footer="{ cancel }">
        <div class="form-group">
          <b-button
            variant="danger"
            @click="cancel"
          >Cancelar</b-button>
          <b-button 
            :disabled="!academia_id"
            variant="primary"
            name="btn-seleccionar-academia" 
            id="btn-seleccionar-academia" 
            :href="rutaCrearReunion"
          >Continuar</b-button>
        </div>
      </template>
    </b-modal>
  </div>
</template>

<script>
import API from "../../../services/api";
import ESTADO from "./../../../enum-estado-api";
export default {
  mounted() {
    
  },
  data() {
    return {
      academias: null,
      academia_id: null,
      ESTADO,
      estadoAcademias: ESTADO.INICIADO,
      // academia_id: null
    }
  },
  methods: {
    abrirModal(){
      this.$bvModal.show('modal-seleccionar-academia');
      if( !this.academias ){
        this.estadoAcademias = this.ESTADO.CARGANDO;
        this.obtenerAcademiasDeApi();
      }
    },
    obtenerAcademiasDeApi(){
      let url = `${API.baseURL}/users/${window.Laravel.authUserId}/academiasQueHaPresidido?actual=1`;
      axios.get(url)
        .then(d => d.data)
        .then(data => {
          this.academias = data.data;
          this.estadoAcademias = this.ESTADO.LISTO;
        })
        .catch(error => {
          this.estadoAcademias = this.ESTADO.ERROR;
        });
    },
  },
  computed: {
    rutaCrearReunion(){
      return this.academia_id ? 
        `${process.env.MIX_APP_URL}/academias/${this.academia_id}/reuniones/crear` : 
        '#';
    }
  },
};
</script>
