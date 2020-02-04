<template>
  <div>
    <div class="form-group row">
      <label for="fecha-inicio">Fecha y hora de inicio</label>
      <date-picker 
        id="fecha-inicio"
        name="fecha-inicio" 
        v-model="inicio" :config="optionsPickerInicio"
        @dp-change="horaInicioCambio"
      >
      </date-picker>
    </div>
    <div class="form-group row" v-if="inicio">
      <label for="fecha-fin">Fecha y hora de finalización</label>
      <date-picker
        id="fecha-fin"
        name="fecha-fin" 
        v-model="fin" :config="optionsPickerFin"></date-picker>
    </div>
    <div class="form-group row">
      <b-button @click="clickme">Holis</b-button>
    </div>
  </div>
</template>

<script>
import {set} from 'vue';
export default {
  mounted() {
    console.log("Component mounted.");
  },
  data() {
    return {
      inicio: "",
      fin: "",
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
      }
    };
  },
  methods: {
    clickme() {
      console.log(this.inicio, this.fin);
    },
    horaInicioCambio({date}) { // date: fecha a la que cambió el evento
      // console.log(date);
      set(this, 'fin', date.add(1, 'h'));
      set(this.optionsPickerFin, 'minDate', date);      
      // console.log(this.fin)
    },
  }
};
</script>
