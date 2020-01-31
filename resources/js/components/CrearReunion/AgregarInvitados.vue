<template>
  <div>
    <b-form-group>
      <label>
        <strong>Agregar invitados externos a la academia</strong>
      </label>
    </b-form-group>
    <b-form-group>
      <autocomplete
        :search="buscarInvitado"
        :debounce-time="500"
        placeholder="Buscar usuario"
        aria-label="Buscar usuario"
        :get-result-value="obtenerNombreCompleto"
        @submit="procesarInvitado"
      >
        <template #result="{ result, props }">
          <li v-bind="props" class="autocomplete-result">{{obtenerNombreCompleto(result)}}</li>
        </template>
      </autocomplete>
    </b-form-group>
    <div v-if="error" class="alert alert-danger">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{error}}</strong>
    </div>
    <b-form-group>
      <b-table
        head-variant="dark"
        ref="tablaInvitados"
        :fields="camposTablaInvitados"
        :items="invitados"
        responsive="sm"
      >
        <template v-slot:cell(invitado)="data">{{obtenerNombreCompleto(data.item)}}</template>
        <template v-slot:cell(acciones)="data">
          <div class="w-100 text-right">
            <b-button @click="removerInvitacion(data.item.id)" variant="danger">
              <i class="fa fa-trash" aria-hidden="true"></i>
              <span class="sr-only">Eliminar Invitación</span>
            </b-button>
          </div>
        </template>
      </b-table>
    </b-form-group>
  </div>
</template>

<script>
import api from "../../services/api";
import { createNamespacedHelpers } from 'vuex';
const { mapGetters, mapActions } = createNamespacedHelpers('crearReunion');

export default {
  mounted() {
    // console.log(api.baseURL);
  },
  data() {
    return {
      camposTablaInvitados: ["invitado", "email", "acciones"],
      invitadoSeleccionado: null,
      error: ""
    };
  },
  methods: {
    ...mapActions(["agregarInvitado", "eliminarInvitadoPorId"]),
    removerInvitacion(id) {
      this.eliminarInvitadoPorId(id);
    },
    // debounce(func, delay) {
    //   let inDebounce
    //   return function() {
    //     const context = this
    //     const args = arguments
    //     clearTimeout(inDebounce)
    //     inDebounce = setTimeout(() => func.apply(context, args), delay)
    //   }
    // },
    buscarInvitado(consulta) {
      return new Promise((res, rej) => {
        if (!consulta || consulta.length < 3) return res([]);
        let uri = `${api.baseURL}/users/buscar/${consulta}`;
        axios
          .get(uri)
          .then(r => r.data.data)
          .then(resultadoBusqueda => {
            this.error = "";
            res(resultadoBusqueda);
          })
          .catch(error => {
            res([]);
            // Error 😨
            if (error.response) {
              /*
               * The request was made and the server responded with a
               * status code that falls out of the range of 2xx
               */
              // console.log(error.response.data);
              // console.log(error.response.status);
              // console.log(error.response.headers);
              if (error.response.status == 404) {
                this.error = error.response.data.message;
              } else this.error = error.message;
            } else if (error.request) {
              /*
               * The request was made but no response was received, `error.request`
               * is an instance of XMLHttpRequest in the browser and an instance
               * of http.ClientRequest in Node.js
               */
              // console.log(error.request);
              this.error = error.message;
            } else {
              // Something happened in setting up the request and triggered an Error
              console.log("Error: ", error.message);
              this.error = error.message;
            }
            // console.log(error.config);
          });
      });
    },
    obtenerNombreCompleto(invitado) {
      // Obtengo solo lo que me interesa del resultado de búsqueda
      return `${invitado.apellido_paterno} ${invitado.apellido_materno} ${invitado.nombre} ${invitado.grado}`;
    },
    procesarInvitado(invitado) {
      if (this.invitados && invitado) {
        // Si hay invitados en lista e invitado seleccionado para agregar
        if (this.invitados.find(inv => inv.id == invitado.id)) {
          // si está en la lista de invitados
          this.error = "Error: El usuario ya está en la lista de invitados";
          return;
        }
        if (
          this.academia.miembrosActuales.find(
            miembro => miembro.id == invitado.id
          )
        ) {
          // Si el usuario es miembro de la academia
          this.error =
            "Error: Solo se pueden agregar usuarios que no sean miembros de la academia";
          return;
        } if (invitado.id == this.academia.presidente.id){
          this.error =
            "Error: Ya estás convocado a la reunión";
          return;
        }
        this.error = "";
        this.agregarInvitado(invitado);
        // console.log(`${invitado.nombre} ${invitado.apellido_paterno} ${invitado.apellido_materno}`);
      }
    }
  },
  computed: {
    ...mapGetters(["invitados", "academia"])
  }
};
</script>
