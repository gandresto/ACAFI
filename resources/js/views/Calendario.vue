<template>
  <div class="container">
    <!-- <div class="row justify-content-center"> -->
    <div class="row">
      <div class="col-xs-12 col-md-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Filtrar reuniones</h5>
            <p class="card-text">WIP</p>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-md-12 py-3">
        <div class="container-fluid"
          v-if="estadoReuniones == estadoApi.CARGANDO 
                  || estadoReuniones == estadoApi.INICIADO"
        >
          <div class="d-flex justify-content-center">
            <div class="spinner-border" role="status"></div>
          </div>
          <div class="text-center">
            <h4>Cargando calendario...</h4>
          </div>
        </div>
        <v-calendar
          v-if="estadoReuniones == estadoApi.LISTO"
          class="vuecal--blue-theme"
          style="height: 600px"
          locale="es"
          default-view="month"
          events-on-month-view="short"
          events-count-on-year-view
          :events="reuniones"
        ></v-calendar>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import ESTADO_API from "../enum-estado-api";

export default {
  data() {
    return {
      estadoApi : ESTADO_API,
    }
  },
  mounted() {
    console.log("Component mounted.");
    this.leerReunionesDeUsuario(window.Laravel.authUserId);
  },
  methods: {
    ...mapActions(["leerReunionesDeUsuario"])
  },
  computed: {
    ...mapGetters(["reuniones", "estadoReuniones"])
  }
};
</script>
<style lang="css">
  .vuecal__event{
    background-color: rgba(0,165,188,.3);
  }
  /* .vuecal__cell-events-count {
    width: 4px;
    min-width: 0;
    height: 4px;
    padding: 0;
    color: transparent;
   } */
</style>
