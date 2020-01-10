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
                    v-model="academiaSeleccionada"
                    @change="seleccionarAcademia"
                >
                    <option disabled selected value="">Seleccione una academia</option>
                    <option v-for="academia in cAcademias" :key="academia.id"
                        :value="academia.id"
                    >
                        {{academia.nombre}}
                    </option>
                </select>
            </b-form-group>
            <div v-if="academiaSeleccionada">
                <b-row>
                    <v-datetime
                        class="form-group col-md-12"
                        input-id="fecha-inicio-input"
                        type="datetime"
                        :min-datetime="limiteInferiorFecha"
                        v-model="fechaInicio"
                        :phrases="frases"
                        required="true"
                        input-class="form-control"
                    >
                        <label for="fecha-inicio-input" slot="before">Fecha y hora de inicio</label>
                    </v-datetime>
                </b-row>
                <b-form-group
                    id="lugar"
                    label="Lugar"
                    label-for="text-lugar"
                >
                    <b-form-input
                        id="text-lugar"
                        v-model="lugar"
                        type="text"
                        required
                    >
                    </b-form-input>
                </b-form-group>
            </div>
        </b-form>
        <div>
            {{academiaSeleccionada}} <br>
            {{fechaInicio}} <br>
            {{lugar}} <br>
        </div>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
    import ESTADO_API from '../enum-estado-api'
    export default {
        data() {
            return {
                academiaSeleccionada: null,
                fechaInicio: null,
                estadoApi: ESTADO_API,
                limiteInferiorFecha: '',
                frases: {
                    ok: 'Aceptar',
                    cancel: 'Cancelar'
                },
                lugar: '',
            }
        },
        mounted() {
            let date = new Date();
            this.limiteInferiorFecha = date.toISOString();
            this.leerAcademiasQuePreside(Laravel.authUserId);
            console.log(Laravel.authUserId);
            console.log(this.cAcademias);
        },
        methods: {
            ...mapActions(
                ['leerAcademiasQuePreside']
            ),
            seleccionarAcademia(){
                console.log(this.academiaSeleccionada);
            },
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
