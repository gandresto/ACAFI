<template>
  <div>
    <b-button
      variant="success"
      id="btn-abrir-formulario-usuario"
      @click="$bvModal.show('modal-crear-usuario')"
    >
      <i class="fa fa-user-plus mr-1" aria-hidden="true"></i>
      Crear nuevo usuario
    </b-button>

    <b-modal id="modal-crear-usuario" hide-footer size="lg" title="Crear usuario">
      <div class="d-block">
        <crear-usuario-form></crear-usuario-form>
      </div>
    </b-modal>
  </div>
</template>

<script>
import ESTADO_API from "../enum-estado-api";
import API from "../services/api";
import CrearUsuarioForm from "./CrearUsuarioForm.vue";
export default {
  components: {
    'crear-usuario-form': CrearUsuarioForm,
  },
};
</script>