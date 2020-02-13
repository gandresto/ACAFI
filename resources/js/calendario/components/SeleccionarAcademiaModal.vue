<template>
  <div>
    <b-button variant="primary" v-b-modal.modal-seleccionar-academia>
      <i class="fa fa-calendar-plus" aria-hidden="true"></i>
        <span class="ml-2">Agendar reunión</span>
    </b-button>

    <b-modal id="modal-seleccionar-academia" title="Selecciona una academia" v-if="academias">
      <template v-slot:default>
        <div class="form-group">
          <label for="select-academia">Academia</label>
          <b-form-select
            v-model="academia_id"
            :options="academias"
            value-field="id"
            text-field="nombre"
            disabled-field="notEnabled"
          ></b-form-select>
        </div>
      </template>
      <template v-slot:modal-footer="{ cancel }">
        <div class="form-group">
          <b-button
            variant="danger"
            @click="cancel"
          >Cancelar</b-button>
          <b-button 
            :disabled="!academia_id"
            variant="primary"
            name="btn-seleccionar-academia" 
            id="btn-seleccionar-academia" 
            :href="rutaCrearReunion"
          >Aceptar</b-button>
        </div>
      </template>
    </b-modal>
  </div>
</template>

<script>
import API from "../../services/api";
export default {
  mounted() {
    let url = `${API.baseURL}/users/${window.Laravel.authUserId}/academiasQueHaPresidido?actual=1`;
    axios.get(url)
        .then(d => d.data)
        .then(data => {
          this.academias = data.data;
        })
        .catch(error => {

        });
  },
  data() {
    return {
      academias: null,
      academia_id: null,
      // academia_id: null
    }
  },
  methods: {

  },
  computed: {
    rutaCrearReunion(){
      return this.academia_id ? 
              `${process.env.MIX_APP_URL}/academias/${this.academia_id}/reuniones/crear` : 
              '#';
    }
  },
};
</script>
