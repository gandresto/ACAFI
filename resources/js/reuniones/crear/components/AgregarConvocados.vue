<template>
  <div>
    <b-form-group>
      <strong>Selecciona a los miembros convocados para esta reunión *</strong>
    </b-form-group>
    <b-form-group>
      <b-form-checkbox
        id="checkbox-convocar-todos"
        name="checkbox-convocar-todos"
        v-model="estanTodosConvocados"
        :indeterminate="estadoIndeterminado"
        @change="alternarSeleccionarTodos"
      >{{estanTodosConvocados ? 'Remover invitaciones' : 'Convocar a todos'}}</b-form-checkbox>
    </b-form-group>
    <b-form-group v-if="academia">
      <b-table
        hover
        head-variant="dark"
        ref="tablaConvocados"
        selectable
        selected-variant="primary"
        select-mode="multi"
        :items="academia.miembrosActuales"
        :fields="camposTablaConvocados"
        responsive="sm"
        @row-selected="actualizarConvocados"
      >
        <template v-slot:cell(convocado)="{ rowSelected }">
          <template v-if="rowSelected">
            <span aria-hidden="true">&check;</span>
            <span class="sr-only">Convocado</span>
          </template>
          <template v-else>
            <span aria-hidden="true">&nbsp;</span>
            <span class="sr-only">No convocado</span>
          </template>
        </template>
        <template
          v-slot:cell(miembro)="data"
        >{{obtenerNombreCompleto(data.item)}}</template>
      </b-table>
    </b-form-group>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import { obtenerNombreCompleto } from "../../../helpers";

export default {
  mounted() {
    
  },
  data() {
    return {
      estanTodosConvocados: false,
      estadoIndeterminado: false,
      camposTablaConvocados: [
        {
          key: "convocado",
          label: "¿Convocado?"
        },
        "miembro",
        "email"
      ]
    };
  },
  methods: {
    ...mapActions(["ponerConvocados"]),
    obtenerNombreCompleto,
    actualizarConvocados(miembrosSeleccionados) {
      // console.log(this.academia.miembrosActuales);
      if (miembrosSeleccionados.length == 0) {
        this.estadoIndeterminado = false;
        this.estanTodosConvocados = false;
      } else if (
        miembrosSeleccionados.length == this.academia.miembrosActuales.length
      ) {
        this.estadoIndeterminado = false;
        this.estanTodosConvocados = true;
      } else {
        this.estadoIndeterminado = true;
        this.estanTodosConvocados = false;
      }
      this.ponerConvocados(miembrosSeleccionados);
    },
    alternarSeleccionarTodos(checked) {
      // console.log(checked);
      if (checked) this.$refs.tablaConvocados.selectAllRows();
      else this.$refs.tablaConvocados.clearSelected();
    }
  },
  computed: {
    ...mapGetters(["academia", "convocados"]),
  }
};
</script>
