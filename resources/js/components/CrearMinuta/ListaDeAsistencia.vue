<template>
  <div>
    <b-form-group>
      <div class="small-title">
        Lista de asistencia de {{tipoDeDatos == "conv" ? "convocados": "invitados externos",}}*
      </div>
    </b-form-group>
    <b-form-group>
      <b-form-checkbox
        :id="`checkbox-asistieron-todos-${tipoDeDatos}`"
        :name="`checkbox-asistieron-todos-${tipoDeDatos}`"
        v-model="asistieronTodos"
        :indeterminate="estadoIndeterminado"
        @change="alternarSeleccionarTodos"
      >{{asistieronTodos ? 'Desmarcar todos' : 'Marcar todos'}}</b-form-checkbox>
    </b-form-group>
    <b-form-group>
      <b-table
        hover
        head-variant="dark"
        ref="tablaAsistencia"
        selectable
        selected-variant="primary"
        select-mode="multi"
        :items="datos"
        :fields="camposTablaAsistencia"
        responsive="sm"
        @row-selected="actualizarAsistencia"
      >
        <template v-slot:cell(asistio)="{ rowSelected }">
          <template v-if="rowSelected">
            <span aria-hidden="true">&check;</span>
            <span class="sr-only">Asistió</span>
          </template>
          <template v-else>
            <span aria-hidden="true">&nbsp;</span>
            <span class="sr-only">No asistió</span>
          </template>
        </template>
        <template
          v-slot:cell(asistente)="data"
        >{{`${data.item.apellido_paterno} ${data.item.apellido_materno} ${data.item.nombre} ${data.item.grado}`}}</template>
      </b-table>
    </b-form-group>
  </div>
</template>

<script>
import { createNamespacedHelpers } from 'vuex'
const { mapGetters, mapMutations } = createNamespacedHelpers('crearMinuta')

export default {
  props: ['tipoDeDatos', 'datos'],
  mounted() {
    // console.log('Component mounted.')
  },
  data() {
    return {
      asistieronTodos: false,
      estadoIndeterminado: false,
      camposTablaAsistencia: [
        {
          key: "asistio",
          label: "¿Asistió?"
        },
        {
          key: "asistente",
          label: "Nombre",
        },
        "email"
      ]
    };
  },
  methods: {
    ...mapMutations(
      [
        "colocarMiembrosQueAsistieron", 
        "colocarInvitadosExternosQueAsistieron"
      ]
    ),
    actualizarAsistencia(asistentesSeleccionados) {
      if (asistentesSeleccionados.length == 0) {
        this.estadoIndeterminado = false;
        this.asistieronTodos = false;
      } else if (
        asistentesSeleccionados.length == this.datos.length
      ) {
        this.estadoIndeterminado = false;
        this.asistieronTodos = true;
      } else {
        this.estadoIndeterminado = true;
        this.asistieronTodos = false;
      }
      if (this.tipoDeDatos == "conv")
        this.colocarMiembrosQueAsistieron(asistentesSeleccionados);
      else if (this.tipoDeDatos == "inv")
        this.colocarInvitadosExternosQueAsistieron(asistentesSeleccionados);
    },
    alternarSeleccionarTodos(checked) {
      // console.log(checked);
      if (checked) this.$refs.tablaAsistencia.selectAllRows();
      else this.$refs.tablaAsistencia.clearSelected();
    }
  },
  computed: {
    ...mapGetters(
      [
        "reunion",
      ]
    ),
  }
};
</script>
