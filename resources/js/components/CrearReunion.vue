<template>
    <div>
        <div v-if="estadoAcademias==estadoApi.CARGANDO || estadoAcademias==estadoApi.INICIADO"
            class="d-flex justify-content-center"
        >
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div  v-if="estadoAcademias==estadoApi.ERROR"
              class="alert alert-danger"
        >
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Hubo un problema, intenta de nuevo más tarde</strong>
        </div>
        <b-form v-if="estadoAcademias==estadoApi.LISTO">
            <b-form-group
                id="academia"
                label="Academia"
                label-for="select-academia"
            >
                <select class="form-control"
                    id="select-academia"
                    v-model="academiaSel"
                    @change="console.log(academia.id)"
                >
                    <option disabled selected value="">Seleccione una academia</option>
                    <option v-for="academia in cAcademias" :key="academia.id"
                        :value="academia.id"
                    >
                        {{academia.nombre}}
                    </option>
                </select>
            </b-form-group>
            <div>
                <b-form-group>

                </b-form-group>
            </div>
        </b-form>
        <div v-text="academiaSel"></div>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
    import ESTADO_API from '../enum-estado-api'
    export default {
        data() {
            return {
                academiaSel: null,
                estadoApi: ESTADO_API
            }
        },
        mounted() {
            this.leerAcademiasQuePreside(Laravel.authUserId);
            console.log(Laravel.authUserId);
            console.log(this.cAcademias);
        },
        methods: {
            ...mapActions(
                ['leerAcademiasQuePreside']
            ),
        },
        computed:{
            ...mapGetters(
                ['academias', 'estadoAcademias']
            ),
            cAcademias(){
                return this.academias || null;
            },
        }
    }
</script>
