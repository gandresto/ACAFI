<template>
  <div class="row my-2">
    <div class="col-sm-12 col-md-6">
      <div class="form-group">
        <label :for="`estado-acuerdo-${acuerdo.id}`">
          Estado del acuerdo <span class="text-danger">*</span>
        </label>
        <b-form-radio-group
          v-show="modoEdicion"
          :id="`estado-acuerdo-${acuerdo.id}`"
          v-model="estadoAcuerdo"
          :options="opciones"
          :name="`estado-acuerdo-${acuerdo.id}`"
        ></b-form-radio-group>
        <div v-show="!modoEdicion">
          - {{ estadoAcuerdo == 0 ? 'Pendiente/En proceso' : 'Finalizado'}}
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-md-6">
      <div class="form-group" v-if="estadoAcuerdo == 1">
        <label :for="`fecha-fin-${acuerdo.id}`">
          Fecha de finalización <span class="text-danger">*</span>
        </label>
        <date-picker
            :disabled="!modoEdicion"
            :id="'fecha-fin-'+acuerdo.id"
            :name="'fecha-fin-'+acuerdo.id"
            v-model="fecha_finalizado" :config="optionsDatePicker"
          >
        </date-picker>
      </div>
    </div>
    <div class="col-sm-12">
      <div class="form-group">
        <label :for="`avance-resultado-${acuerdo.id}`">
          {{ labelComentario }} <span class="text-danger">*</span>
          </label>
        <input type="text"
          :disabled="!modoEdicion"
          v-model="avanceResultado"
          class="form-control" 
          :name="`avance-resultado-${acuerdo.id}`" 
          :id="`avance-resultado-${acuerdo.id}`" 
          :placeholder="labelComentario">
      </div>
    </div>
    <div class="col-sm-12">
      <div class="form-group text-sm-right">
        <b-button
          v-show="modoEdicion"
          variant="success"
          @click="agregarDetalles"
          :disabled="!validForm"
        >
        <i class="fa fa-check mr-1" aria-hidden="true"></i>
        Agregar {{ estadoAcuerdo == 0 ? 'avance' : 'resultado'}}
        </b-button>
        <b-button
          v-show="!modoEdicion"
          variant="primary"
          @click="modoEdicion = true"
          :disabled="!validForm"
        >
        <i class="fa fa-edit mr-1" aria-hidden="true"></i>
        Editar {{ estadoAcuerdo == 0 ? 'avance' : 'resultado'}}
        </b-button>
      </div>
    </div>
  </div>
</template>

<script>

import { mapGetters, mapMutations, mapActions } from 'vuex';

export default {
  props: ['acuerdo'],
  data() {
    return {
      avanceResultado: '',
      fecha_finalizado: null,
      modoEdicion: true,
      estadoAcuerdo: 0,
      opciones : [
        { value: 0, text: 'Pendiente/En proceso' },
        { value: 1, text: 'Finalizado/Terminado' },
      ],
        optionsDatePicker: {
        locale: "es",
        format: "DD/MM/YYYY",
        daysOfWeekDisabled: [0],
        minDate: moment(this.acuerdo.fecha_de_creacion),
        maxDate: moment(),
      },
    }
  },
  computed: {
    ...mapGetters(['acuerdosASeguimiento']),
    labelComentario(){
      return this.estadoAcuerdo===0 ? 'Avance en el desarrollo del acuerdo.' : 'Resultado obtenido.';
    },
    validForm(){
      let valido = this.avanceResultado.length > 3 && this.avanceResultado.length < 192;
      if( this.estadoAcuerdo == 1 )
        valido = valido && this.fecha_finalizado != null;
      return valido
    }
  },
  methods: {
    ...mapActions(['ponerAvanceEnAcuerdo', 'ponerResultadoEnAcuerdo']),
    agregarDetalles(){
      if (this.estadoAcuerdo == 0) {
        let payload = {
          acuerdo_id: this.acuerdo.id,
          avance: this.avanceResultado,
        };
        this.ponerAvanceEnAcuerdo(payload);
      } else if (this.estadoAcuerdo == 1) {
        let payload = {
          acuerdo_id: this.acuerdo.id,
          resultado: this.avanceResultado,
          fecha_finalizado: this.fecha_finalizado,
        };
        this.ponerResultadoEnAcuerdo(payload);
      }
      this.modoEdicion = false;
      return;
    },
  },
};
</script>