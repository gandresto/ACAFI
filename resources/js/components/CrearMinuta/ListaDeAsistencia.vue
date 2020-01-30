<template>
  <div>
    <b-form-group>
      <div class="small-title">Lista de asistencia *</div>
    </b-form-group>
    <b-form-group>
      <b-form-checkbox
        id="checkbox-convocar-todos"
        name="checkbox-convocar-todos"
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
        :items="reunion.convocados"
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
          v-slot:cell(miembro)="data"
        >{{`${data.item.apellido_paterno} ${data.item.apellido_materno} ${data.item.nombre} ${data.item.grado}`}}</template>
      </b-table>
    </b-form-group>
  </div>
</template>

<script>
import { createNamespacedHelpers } from 'vuex'
const { mapGetters, mapMutations } = createNamespacedHelpers('crearMinuta')

export default {
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
        "miembro",
        "email"
      ]
    };
  },
  methods: {
    ...mapMutations(["colocarAsistentes"]),
    actualizarAsistencia(miembrosSeleccionados) {
      if (miembrosSeleccionados.length == 0) {
        this.estadoIndeterminado = false;
        this.asistieronTodos = false;
      } else if (
        miembrosSeleccionados.length == this.reunion.convocados.length
      ) {
        this.estadoIndeterminado = false;
        this.asistieronTodos = true;
      } else {
        this.estadoIndeterminado = true;
        this.asistieronTodos = false;
      }
      this.colocarAsistentes(miembrosSeleccionados);
    },
    alternarSeleccionarTodos(checked) {
      // console.log(checked);
      if (checked) this.$refs.tablaAsistencia.selectAllRows();
      else this.$refs.tablaAsistencia.clearSelected();
    }
  },
  computed: {
    ...mapGetters(["asistentes", "reunion"])
  }
};
</script>
