<template>
  <b-form @submit="registrarUsuario">
    <!-- ------------- Mensajes de error ---------------- -->
    <div class="form-group row my-2" v-if="error">
      <div class="col-md-12">
        <div class="alert alert-danger">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <strong>{{error}}</strong>
        </div>
      </div>
    </div>

    <!-- ------------- Mensajes de confirmación ---------------- -->
    <div class="form-group row my-2" v-if="estadoForm == estadoApi.LISTO">
      <div class="col-md-12">
        <div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <strong>{{ mensaje_exito }}</strong>
        </div>
      </div>
    </div>

    <!-- ------------- Grado académico ---------------- -->
    <div class="form-group row" v-if="estadoGrados == estadoApi.LISTO">
      <label for="grado" class="col-md-4 col-form-label text-md-right">Grado académico</label>
      <div class="col-md-6">
        <select
          :class="claseValidacion('grado')"
          name="grado"
          v-model="form.grado"
          id="grado"
          required
        >
          <option value disabled selected>Selecciona Uno</option>
          <option v-for="(grado, index) in grados" :key="index" :value="grado">{{grado}}</option>
        </select>
        <span v-if="tieneError('grado')" class="invalid-feedback" role="alert">
          <strong>{{erroresDeValidacion.grado[0]}}</strong>
        </span>
      </div>
    </div>

    <!-- -------------------- Nombre  ---------------- -->
    <div class="form-group row">
      <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre</label>
      <div class="col-md-6">
        <input
          id="nombre"
          type="text"
          :class="claseValidacion('nombre')"
          name="nombre"
          v-model="form.nombre"
          value
          required
        />
        <span v-if="tieneError('nombre')" class="invalid-feedback" role="alert">
          <strong>{{erroresDeValidacion.nombre[0]}}</strong>
        </span>
      </div>
    </div>

    <!-- ------------- Apellido Paterno ---------------- -->
    <div class="form-group row">
      <label for="apellido_paterno" class="col-md-4 control-label text-md-right">Apellido Paterno</label>
      <div class="col-md-6">
        <input
          id="apellido_paterno"
          type="text"
          :class="claseValidacion('apellido_paterno')"
          name="apellido_paterno"
          v-model="form.apellido_paterno"
          value
          required
        />
        <span v-if="tieneError('apellido_paterno')" class="invalid-feedback" role="alert">
          <strong>{{erroresDeValidacion.apellido_paterno[0]}}</strong>
        </span>
      </div>
    </div>

    <!-- ------------- Apellido Materno ---------------- -->
    <div class="form-group row">
      <label for="apellido_materno" class="col-md-4 control-label text-md-right">Apellido Materno</label>
      <div class="col-md-6">
        <input
          id="apellido_materno"
          type="text"
          :class="claseValidacion('apellido_materno')"
          name="apellido_materno"
          v-model="form.apellido_materno"
          value
          required
        />
        <span v-if="tieneError('apellido_materno')" class="invalid-feedback" role="alert">
          <strong>{{erroresDeValidacion.apellido_materno[0]}}</strong>
        </span>
      </div>
    </div>

    <!-- -------------------- Correo ---------------- -->
    <div class="form-group row">
      <label for="email" class="col-md-4 col-form-label text-md-right">Correo</label>
      <div class="col-md-6">
        <input
          id="email"
          type="email"
          :class="claseValidacion('email')"
          name="email"
          v-model="form.email"
          value
          required
          autocomplete="email"
        />
        <span v-if="tieneError('email')" class="invalid-feedback" role="alert">
          <strong>{{erroresDeValidacion.email[0]}}</strong>
        </span>
      </div>
    </div>

    <!-- ----------------- Contraseña ---------------- -->
    <div class="form-group row">
      <label for="password" class="col-md-4 col-form-label text-md-right">Contraseña</label>
      <div class="col-md-6">
        <input
          id="password"
          type="password"
          :class="claseValidacion('password')"
          name="password"
          v-model="form.password"
          required
          autocomplete="new-password"
        />
        <span v-if="tieneError('password')" class="invalid-feedback" role="alert">
          <strong>{{erroresDeValidacion.password[0]}}</strong>
        </span>
      </div>
    </div>

    <!-- ------------- Confirmar Contraseña ---------------- -->
    <div class="form-group row">
      <label
        for="password-confirm"
        class="col-md-4 col-form-label text-md-right"
      >Confirmar contraseña</label>
      <div class="col-md-6">
        <input
          id="password-confirm"
          type="password"
          class="form-control"
          name="password_confirmation"
          v-model="form.password_confirmation"
          required
          autocomplete="new-password"
        />
      </div>
    </div>

    <!-- ------------- Botones de registro y cancelar ---------------- -->
    <div class="form-group row mb-0">
      <div class="col-md-6 offset-md-4 text-md-right">
        <b-button
          class="mx-2"
          variant="danger"
          :disabled="estadoForm == estadoApi.CARGANDO"
          @click="$bvModal.hide('modal-crear-usuario')"
        >Cancelar</b-button>

        <b-button type="submit" variant="primary" :disabled="estadoForm == estadoApi.CARGANDO">
          <span v-if="estadoForm == estadoApi.CARGANDO">
            <div class="spinner-border spinner-border-sm mx-1" role="status"></div>Registrando usuario...
          </span>
          <span v-else>Registrar Usuario</span>
        </b-button>
      </div>
    </div>
  </b-form>
</template>

<script>
import ESTADO_API from "../enum-estado-api";
import API from "../services/api";

export default {
  mounted() {
    this.leerGradosDeApi();
  },
    data() {
      return {
        estadoApi: ESTADO_API,
        grados: [],
        estadoGrados: ESTADO_API.INICIADO,
        estadoForm: ESTADO_API.INICIADO,
        erroresDeValidacion: {
          grado: "",
          nombre: "",
          apellido_paterno: "",
          apellido_materno: "",
          email: "",
          password: "",
        },
        error: null,
        mensaje_exito: "",
        form: {
          grado: "",
          nombre: "",
          apellido_paterno: "",
          apellido_materno: "",
          email: "",
          password: "",
          password_confirmation: ""
        },
      };
    },
    methods: {
      tieneError(campo) {
        return this.erroresDeValidacion[campo] ? true : false;
      },
      claseValidacion(campo) {
        return "form-control" + (this.tieneError(campo) ? " is-invalid" : "");
      },
      leerGradosDeApi() {
        let url = `${API.baseURL}/grados`;
        this.estadoGrados = ESTADO_API.CARGANDO;
        axios
          .get(url)
          .then(r => r.data)
          .then(data => {
            // console.log(data);
            this.grados = data.map(grado => grado.id);
            this.estadoGrados = ESTADO_API.LISTO;
          })
          .catch(err => {
            this.estadoGrados = ESTADO_API.ERROR;
            if (err.response) {
              console.log(err.response);
              this.error = err.response.data;
            } else {
              console.log(err);
              this.error = err;
            }
          });
      },
      registrarUsuario(event) {
        event.preventDefault();
        // console.log("Enviar Formulario");
        let url = `${API.baseURL}/users`;
        this.estadoForm = ESTADO_API.CARGANDO;
        // this.mute = true;
        this.error= '';
        this.erroresDeValidacion = {
          grado: "",
          nombre: "",
          apellido_paterno: "",
          apellido_materno: "",
          email: "",
          password: "",
        },
        this.mensaje_exito = "";
        axios
          .post(url, this.form)
          .then(r => r.data)
          .then(data => {
            this.estadoForm = ESTADO_API.LISTO;
            this.form = {
              grado: "",
              nombre: "",
              apellido_paterno: "",
              apellido_materno: "",
              email: "",
              password: "",
              password_confirmation: ""
            }
            this.mensaje_exito = data.message;
            this.$emit('exito', data);
          })
          .catch(err => {
            this.estadoForm = ESTADO_API.ERROR;
            if (err.response) {
              // console.log(err.response);
              if(err.response.status = 422) this.erroresDeValidacion = err.response.data.errors;
              else this.error = err.message;
            } else {
              console.log(err);
              this.error = "Error de red. Intente de nuevo más tarde";
            }
            this.$emit('error', err);
          });
      }, // End methods
    }, // End methods
}
</script>