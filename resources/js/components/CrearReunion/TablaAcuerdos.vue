<template>
  <div>
    <b-form-group>
      <strong>Dar seguimiento a acuerdos pendientes</strong>
    </b-form-group>
    <b-form-group>
      <b-form-checkbox
        id="checkbox-revisar-todos"
        name="checkbox-revisar-todos"
        v-model="estanTodosMarcados"
        :indeterminate="estadoIndeterminado"
        @change="alternarSeleccionarTodos"
      >
        {{
        estanTodosMarcados
        ? "No dar seguimiento a ninguno"
        : "Dar seguimiento a todos"
        }}
      </b-form-checkbox>
    </b-form-group>
    <b-form-group>
      <b-table
        hover
        head-variant="dark"
        ref="tablaAcuerdos"
        selectable
        selected-variant="primary"
        select-mode="multi"
        :items="cAcuerdosPendientes"
        :fields="camposTablaAcuerdos"
        responsive="sm"
        @row-selected="actualizarAcuerdos"
      >
        <template v-slot:cell(revisar)="{ rowSelected }">
          <template v-if="rowSelected">
            <span aria-hidden="true">&check;</span>
            <span class="sr-only">Dar seguimiento</span>
          </template>
          <template v-else>
            <span aria-hidden="true">&nbsp;</span>
            <span class="sr-only">No dar seguimiento</span>
          </template>
        </template>
      </b-table>
    </b-form-group>
  </div>
</template>

<script>
import { createNamespacedHelpers } from 'vuex';
const { mapGetters, mapActions } = createNamespacedHelpers('crearReunion');
export default {
  mounted() {
    // console.log("Component mounted.");
  },
  data() {
    return {
      estanTodosMarcados: false,
      estadoIndeterminado: false,
      camposTablaAcuerdos: [
        {
          key: "revisar",
          label: "¿Dar seguimiento?"
        },
        {
          key: "descripcion",
          label: "Acuerdo"
        },
        {
          key: "fecha_compromiso",
          label: "Fecha comprimiso de resolución"
        },
        {
          key: "ultima_revision",
          label: "Fecha de última revisión"
        }
      ]
    };
  },
  methods: {
    ...mapActions(["ponerAcuerdosARevision"]),
    alternarSeleccionarTodos(checked) {
      // console.log(checked);
      if (checked) this.$refs.tablaAcuerdos.selectAllRows();
      else this.$refs.tablaAcuerdos.clearSelected();
    },
    actualizarAcuerdos(acuerdos) {
      if (acuerdos.length == 0) {
        this.estadoIndeterminado = false;
        this.estanTodosMarcados = false;
      } else if (acuerdos.length == this.acuerdosPendientes.length) {
        this.estadoIndeterminado = false;
        this.estanTodosMarcados = true;
      } else {
        this.estadoIndeterminado = true;
        this.estanTodosMarcados = false;
      }
    //   console.log(acuerdos);
      this.ponerAcuerdosARevision(acuerdos);
    }
  },
  computed: {
    ...mapGetters(["acuerdosPendientes"]),
    cAcuerdosPendientes() {
      return this.acuerdosPendientes ? this.acuerdosPendientes : [];
    }
  }
};
</script>
