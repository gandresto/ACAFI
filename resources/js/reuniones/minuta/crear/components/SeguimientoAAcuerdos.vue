<template>
  <div class="my-2">
    <div class="row">
      <div class="col-sm-12">
        <div class="small-title">Acuerdos de reuniones pasadas a los que se les dio seguimiento</div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-10">
        <ol>
          <li v-for="(acuerdo, index) in acuerdosASeguimiento" :key="index">
            <strong>{{ acuerdo.descripcion }}</strong><br/>
            Responsable: {{ acuerdo.responsable.nombre_completo }} <br/>
            Fecha de la reunión en que se acordó: {{ acuerdo.fecha_de_creacion | fecha }} <br/>
            Fecha compromiso de finalización: {{ acuerdo.fecha_compromiso | fecha }} <br/>
            Resultado/Producto esperado: {{ acuerdo.producto_esperado }} <br/>
            <seguimiento-a-acuerdos-form
              :acuerdo="acuerdo"
            >
            </seguimiento-a-acuerdos-form>
          </li>
        </ol>
      </div>
    </div>    
  </div>
</template>

<script>

import { mapGetters } from 'vuex';
import SeguimientoAAcuerdosForm from './SeguimientoAAcuerdosForm.vue';
import { formatoFecha } from "./../../../../helpers";

export default {
  components: {
    'seguimiento-a-acuerdos-form': SeguimientoAAcuerdosForm,
  },
  data() {
    return {

    }
  },
  computed: {
    ...mapGetters(['acuerdosASeguimiento']),
  },
  filters:{
    fecha: (datestring) => {
      return formatoFecha(datestring);
    }
  }
};
</script>
