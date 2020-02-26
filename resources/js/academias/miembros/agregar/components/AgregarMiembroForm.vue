<template>
  <div>
    <!-- -------- Input radio para intercambiar formulario ------ -->
    <div class="form-row">
      <label for="grado" class="col-md-4 col-form-label text-md-right">
        ¿El usuario ya está registrado o desea crear uno nuevo?
      </label>
      <b-form-group class="col-md-6 p-2">
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
      <label for="buscar-usuario" class="col-md-4 col-form-label text-md-right">
        Agregar usuario existente
      </label>
      <div class="col-md-6">
        <autocomplete
          id="buscar-usuario"
          :search="buscarUsuario"
          :debounce-time="500"
          placeholder="Buscar usuario"
          aria-label="Buscar usuario"
          :get-result-value="obtenerNombreCompleto"
          @submit="agregarNuevoMiembro"
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
    <span v-if="nuevosMiembros.length > 0">
      <div class="row">
        <label class="col-md-1 text-md-right">
        </label>
        <div class="col-md-9">
          <b-table
            head-variant="dark"
            ref="tablaMiembros"
            :fields="camposTablaNuevosMiembros"
            :items="nuevosMiembros"
            responsive="md"
          >
            <template v-slot:cell(nombre)="data">
              {{obtenerNombreCompleto(data.item)}}
            </template>
            <template v-slot:cell(fecha_ingreso)="data">
              <date-picker 
                id="fecha-ingreso"
                name="fecha-ingreso" 
                class="form-control"
                required="true"
                v-model="data.item.fecha_ingreso" :config="optionsDatePicker"
              >
              </date-picker>
            </template>
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
      </div>

      <div class="row">
        <div class="col-md-1 text-md-right" v-if="erroresDeValidacion != null">
        </div>
        <div class="col-md-9 px-2">
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
      </div>

      <!-- ------ Botón "submit" ------ -->
      <div class="row">
        <div class="col-sm-10 text-md-right">
          <b-button variant="primary" @click="submitMiembros">
            <i class="fa fa-users mr-1"></i>
            Agregar miembros
          </b-button>
        </div>
      </div>
    </span>
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
      camposTablaNuevosMiembros: ["nombre", "email", "fecha_ingreso", "remover"],
      optionsDatePicker: {
        locale: "es",
        format: "YYYY-MM-DD",
        daysOfWeekDisabled: [0],
        maxDate: moment(),
      },
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
      this.agregarNuevoMiembro(data.usuario);
    },
    agregarNuevoMiembro(usuario){
      if(this.nuevosMiembros.find(miembro => miembro.id == usuario.id)){
        return;
      }
      usuario['fecha_ingreso'] = moment();
      this.nuevosMiembros.push(usuario);
    },
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
        nuevosMiembros: this.nuevosMiembros.map(miembro => {
          return {
              id: miembro.id,
              fecha_ingreso: miembro.fecha_ingreso
            }
          }
        ),
      };
      axios
        .post(uri, {data})
        .then(r => r.data)
        .then(data => {
          console.log(data)
          window.onbeforeunload = null;
          let division_id = this.academiaProp.departamento.division_id;
          let departamento_id = this.academiaProp.departamento.id;
          let academia_id = this.academiaProp.id;
          alert('Usuarios agregados satisfactoriamente.');
          window.location = `${process.env.MIX_APP_URL}/divisions/${division_id}/departamentos/${departamento_id}/academias/${academia_id}`;
          // window.location = document.referrer;
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