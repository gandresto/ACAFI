<template>
  <div>
    <div class="form-group">
      <div class="form-check">
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="seleccion-formulario" id="nuevo-usuario-radio" value="0">
          Nuevo usuario
        </label>
        <label class="form-check-label">
          <input type="radio" class="form-check-input" name="seleccion-formulario" id="usuario-existente-radio" value="1" checked>
          Nuevo usuario
        </label>
      </div>
    </div>
    <!-- <autocomplete
      :search="buscarUsuario"
      :debounce-time="500"
      placeholder="Buscar usuario"
      aria-label="Buscar usuario"
      :get-result-value="obtenerNombreCompleto"
      @submit="procesarInvitado"
    ></autocomplete> -->
  </div>
</template>
<script>
export default {
  mounted() {},
  data() {
    return {};
  },
  methods: {
    // buscarInvitado(consulta) {
    //   return new Promise((res, rej) => {
    //     if (!consulta || consulta.length < 3) return res([]);
    //     let uri = `${api.baseURL}/users`;
    //     let params = {
    //       q: consulta
    //     };
    //     axios
    //       .get(uri, { params })
    //       .then(r => r.data.data)
    //       .then(resultadoBusqueda => {
    //         this.error = "";
    //         res(resultadoBusqueda);
    //       })
    //       .catch(error => {
    //         res([]);
    //         if (error.response) {
    //           if (error.response.status == 404) {
    //             this.error = error.response.data.message;
    //           } else this.error = error.message;
    //         } else if (error.request) {
    //           this.error = error.message;
    //         } else {
    //           console.log("Error: ", error.message);
    //           this.error = error.message;
    //         }
    //       });
    //   });
    // }, // End buscar usuario


  }, // End methods
};
</script>