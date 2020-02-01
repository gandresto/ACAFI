<template>
  <div>
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
          <!-- class="vuecal--blue-theme" -->
        <v-calendar
          v-if="estadoReuniones == estadoApi.LISTO"
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
    // console.log("Component mounted.");
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
  .vuecal__cell-events-count {
    width: 1.5rem;
    min-width: 0;
    height: 1.5rem;
    font-size: 0.9rem;
    padding-top: 0.4rem;
  }

  .vuecal__event{
    cursor: pointer;
    color: #212529;
  }

  /* Colores del tema */
  .vuecal__event{background-color: rgba(167, 78, 78, 0.3);}
  .vuecal__menu, .vuecal__cell-events-count {background-color: #cd171e;}
  .vuecal__menu button {border-bottom-color: #fff;color: #fff;}
  .vuecal__menu button.active {background-color: rgba(255, 255, 255, 0.15);}
  .vuecal__title-bar {background-color: #f5e4e4;}
  .vuecal__cell.today, .vuecal__cell.current {background-color: rgba(255, 254, 240, 0.4);}
  .vuecal:not(.vuecal--day-view) .vuecal__cell.selected {background-color: rgba(255, 235, 235, 0.4);}
  .vuecal__cell.selected:before {border-color: rgba(168, 20, 20, 0.5);}

</style>
