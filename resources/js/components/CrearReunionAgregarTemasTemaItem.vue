<template>
  <div>
    <b-input-group v-if="modoEdicion">
      <b-form-input v-model="textoTemaEnEdicion" :state="temaValido" trim></b-form-input>
      <b-input-group-append>
        <b-button variant="danger" @click="cancelarEdicion">
          <i class="fa fa-times-circle" aria-hidden="true"></i>
          <span class="sr-only">Cancelar</span>
        </b-button>
        <b-button
          variant="success"
          title="Agregar tema"
          @click="editarDescripcionTema(textoTemaEnEdicion)"
          :disabled="!temaValido"
        >
          <i class="fa fa-check-circle" aria-hidden="true">
            <span class="sr-only">Listo</span>
          </i>
        </b-button>
      </b-input-group-append>
      <div class="invalid-feedback">
        {{mensajeError}}
      </div>
    </b-input-group>
    <b-input-group v-else>
      <b-input-group-append class="form-control disabled-input">
        {{
        tema.descripcion
        }}
      </b-input-group-append>
      <b-input-group-append>
        <b-button variant="primary" @click="modoEdicion = true">
          <i class="fas fa-edit"></i>
          <span class="sr-only">Editar tema</span>
        </b-button>
        <b-button variant="danger" @click="eliminarTema(tema)">
          <i class="fa fa-trash" aria-hidden="true"></i>
          <span class="sr-only">Quitar tema</span>
        </b-button>
      </b-input-group-append>
    </b-input-group>
  </div>
</template>

<script>
import { mapActions } from "vuex";
export default {
  props: ["tema"],
  mounted() {
    // console.log('Component mounted.')
  },
  data() {
    return {
      textoTemaEnEdicion: this.tema.descripcion,
      modoEdicion: false
    };
  },
  methods: {
    ...mapActions(["editarTema", "eliminarTema"]),
    editarDescripcionTema(textoTema) {
      if (textoTema.length > 3) {
        // console.log(tema);
        this.editarTema({
          id: this.tema.id,
          descripcion: textoTema,
        });
        this.modoEdicion = false;
      }
    },
    cancelarEdicion(){
      this.textoTemaEnEdicion = this.tema.descripcion;
      this.modoEdicion = false;
    },
  },
  computed: {
    temaValido() {
      return this.textoTemaEnEdicion.length > 3 ? true : false;
    },
    mensajeError() {
        if (this.textoTemaEnEdicion.length > 3) {
          return ''
        } else if (this.textoTemaEnEdicion.length > 0) {
          return 'Ingresa al menos 3 caracteres'
        } else {
          return 'Ingresa algo'
        }
      },
  }
};
</script>
<style lang="scss">
.disabled-input {
  background-color: #e9ecef;
}
</style>
