<template>
  <div>
    <!-- -------- Input radio para intercambiar formulario ------ -->
    <div class="form-row">
      <b-form-group label="¿El usuario ya está registrado o desea crear uno nuevo?">
        <b-form-radio v-model="formSeleccionado" name="seleccion-form-radio" value="existente">Usuario existente</b-form-radio>
        <b-form-radio v-model="formSeleccionado" name="seleccion-form-radio" value="nuevo">Nuevo usuario</b-form-radio>
      </b-form-group>
    </div>

    <!-- -------- Formulario de creación de nuevo usuario ------ -->
    <div class="row" v-if="formSeleccionado === 'nuevo'">
      <div class="col-sm-12">
        <crear-usuario-form
          @exito="agregarDesdeNuevo"
        ></crear-usuario-form>
      </div>
    </div>

    <!-- -------- Barra de búsqueda de usuarios ------ -->
    <div class="form-row" v-else>
      <label for="grado" class="col-md-4 col-form-label text-md-right">
        Agregar usuario existente
      </label>
      <div class="col-md-6">
        <autocomplete
          :search="buscarUsuario"
          :debounce-time="500"
          placeholder="Buscar usuario"
          aria-label="Buscar usuario"
          :get-result-value="obtenerNombreCompleto"
          @submit="agregarDesdeExistente"
        >
          <template #result="{ result, props }">
            <li v-bind="props" class="autocomplete-result">{{obtenerNombreCompleto(result)}}</li>
          </template>
        </autocomplete>
        <div class="alert alert-danger" role="alert" v-if="error">
          <strong>{{error}}</strong>
        </div>
      </div>
    </div>
    <hr/>

    <!-- --------   Tabla de miembros por agregar ------ -->
    <div class="form-row" v-if="nuevosMiembros.length > 0">
      <label class="col-md-4 text-md-right">
        Usuarios por ser agregados
      </label>
      <div class="col-md-6">
        <b-table
          head-variant="dark"
          ref="tablaMiembros"
          :fields="camposTablaNuevosMiembros"
          :items="nuevosMiembros"
          responsive="sm"
        >
          <template v-slot:cell(nombre)="data">{{obtenerNombreCompleto(data.item)}}</template>
          <template v-slot:cell(remover)="data">
            <div class="w-100 text-right">
              <b-button @click="removerMiembro(data.item.id, data.index)" variant="danger">
                <i class="fa fa-trash" aria-hidden="true"></i>
                <span class="sr-only">Quitar miembro</span>
              </b-button>
            </div>
          </template>
        </b-table>
      </div>

      <div class="col-md-4 text-md-right" v-if="erroresDeValidacion != null">
        Errores
      </div>
      <div class="col-md-6 px-2">
        <div class="alert alert-danger" role="alert" v-if="erroresDeValidacion != null">
            
            <!-- 
            -- Errores de validación
            --  
            -- Obtengo las llaves del objeto "erroresDeValidacion", estas tienen una estructura "nuevosMiembros.{$id}"   
            -- Para obtener la posición en el arreglo de nuevos miembros, divido la cadena separándola por el punto
            -- y la uso como llave para el objeto nuevosMiembros. Con ello obtengo el objeto miembro correspondiente,
            -- y con ello su nombre.
            -- 
            -->
            <div v-for="(errKey, index) in Object.keys(erroresDeValidacion)" :key="index">
              <strong>
                {{ obtenerNombreCompleto( nuevosMiembros[errKey.split('.')[1]] ) }}
              </strong>
              - {{erroresDeValidacion[errKey][0]}}
            </div>
        </div>
      </div>

      <!-- ------ Botón "submit" ------ -->
      <div class="col-sm-10 text-md-right">
        <b-button variant="primary" @click="submitMiembros">
          <i class="fa fa-users mr-1"></i>
          Agregar miembros
        </b-button>
      </div>
    </div>
  </div>
</template>
<script>
import api from '../../../../services/api'
import { obtenerNombreCompleto } from '../../../../helpers'

export default {
  props: ['academiaProp'],
  mounted() {},
  data() {
    return {
      formSeleccionado: 'existente',
      error: null,
      erroresDeValidacion: null,
      nuevosMiembros: [],
      camposTablaNuevosMiembros: ["nombre", "email", "remover"],
    };
  },
  methods: {
    obtenerNombreCompleto,
    removerMiembro(id, index) {
      if (window.confirm('¿Deseas quitar al usuario de la lista?')){
        delete this.erroresDeValidacion[`nuevosMiembros.${index}`]
        this.nuevosMiembros = this.nuevosMiembros.filter(miembro => miembro.id != id);
      }
    },
    agregarDesdeNuevo(data){
      this.nuevosMiembros.push(data['usuario']);
    },
    agregarDesdeExistente(usuario){
      this.nuevosMiembros.push(usuario);
    },
    // obtenerNombreCompleto(usuario) {
    //   // Obtengo solo lo que me interesa del resultado de búsqueda
    //   return `${usuario.apellido_paterno} ${usuario.apellido_materno} ${usuario.nombre} ${usuario.grado}`;
    // },
    buscarUsuario(consulta) {
      return new Promise((res, rej) => {
        if (!consulta || consulta.length < 3) return res([]);
        let uri = `${api.baseURL}/users`;
        let params = {
          q: consulta
        };
        axios
          .get(uri, { params })
          .then(r => r.data.data)
          .then(resultadoBusqueda => {
            this.error = "";
            res(resultadoBusqueda);
          })
          .catch(error => {
            res([]);
            if (error.response) {
              if (error.response.status == 404) {
                this.error = error.response.data.message;
              } else this.error = error.message;
            } else if (error.request) {
              this.error = error.message;
            } else {
              console.log("Error: ", error.message);
              this.error = error.message;
            }
          });
      });
    }, // End buscar usuario
    submitMiembros(evt){
      let uri = `${api.baseURL}/academias/${this.academiaProp.id}/miembros`;
      this.erroresDeValidacion = null; // Limpio errores
      this.error = '';
      let data = {
        nuevosMiembros: this.nuevosMiembros.map(miembro => miembro.id)
      };
      axios
        .post(uri, {data})
        .then(r => r.data.data)
        .then(data => {
          // this.error = "";
          console.log(data)
        })
        .catch(error => {
          if (error.response) {
            console.log(error.response.data);
            if (error.response.status == 422) {
              this.erroresDeValidacion = error.response.data.errors;
              // this.error = error.response.data.message;
            } else
              console.log(error.response.data)
              // this.error = error.message;
              ;
          } else if (error.request) {
            console.log(error.message);
            // this.error = error.message;
          } else {
            console.log("Error: ", error.message);
            // this.error = error.message;
          }
        });
    }, // End submit miembros
    tieneErroresDeValidacion(key){
      return this.erroresDeValidacion[`nuevosMiembros.${key}`] ? true : false;
    },
  }, // End methods

  watch: {
    nuevosMiembros: function (newValue, oldValue) {
      if( newValue.length > 0 ){
        window.onbeforeunload = () => '¿Deseas abandonar la página? Los cambios aún no se guardan';
      } else 
        window.onbeforeunload = null;
    }
  },

  // filters: {
  //   nombreDeMiembroConError: function (errKey){
  //     // return this.nuevosMiembros[ errKey.split('.')[1] ];
  //     return this.obtenerNombreCompleto(this.nuevosMiembros[ errKey.split('.')[1] ]);
  //   }
  // },
};
</script>