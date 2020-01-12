<template>
    <div>
        <!-- --------- Indicadores de carga y de error -----------  -->
        <div v-if="estadoAcademias==estadoApi.CARGANDO || estadoAcademias==estadoApi.INICIADO"
            class="d-flex justify-content-center"
        >
            <div class="spinner-border" role="status">
                <span class="sr-only">Cargando...</span>
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
        </b-form>

        <!-- --------- Indicadores de carga y de error -----------  -->
        <div v-if="estadoAcademia==estadoApi.CARGANDO"
            class="d-flex justify-content-center"
        >
            <div class="spinner-border" role="status">
                <span class="sr-only">Cargando...</span>
            </div>
        </div>
        <div  v-if="estadoAcademia==estadoApi.ERROR"
            class="alert alert-danger"
        >
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Hubo un problema, intenta de nuevo más tarde</strong>
        </div>
        <!-- ----------- Formulario al seleccionar academia --------- -->
        <b-form v-if="academiaSeleccionada && estadoAcademia==estadoApi.LISTO">
            <!-- ----------- Fecha y hora --------- -->
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
            <!-- ----------- Lugar --------- -->
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
            <hr>
            <!-- ----------- Convocados --------- -->
            <crear-reunion-agregar-convocados></crear-reunion-agregar-convocados>
            <hr>
            <!-- ----------- Invitados --------- -->
            <crear-reunion-agregar-invitados></crear-reunion-agregar-invitados>
            <!-- ----------- Temas por revisar --------- -->
            <crear-reunion-agregar-temas></crear-reunion-agregar-temas>
            <b-row>
                <b-container>
                <!-- {{academiaSeleccionada}} <br> -->
                <!-- {{fechaInicio}} <br> -->
                <!-- {{lugar}} <br> -->
                <!-- {{convocados}}<br> -->
                </b-container>
            </b-row>
        </b-form>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
    import ESTADO_API from '../enum-estado-api';

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
        },
        methods: {
            ...mapActions(
                ['leerAcademiasQuePreside', 'leerAcademia']
            ),
            seleccionarAcademia(){
                if(this.academiaSeleccionada) this.leerAcademia(this.academiaSeleccionada);
            },
        },
        computed:{
            ...mapGetters(
                ['academias', 'estadoAcademias', 'academia', 'estadoAcademia']
            ),
            cAcademias(){
                return this.academias || null;
            },
        }
    }
</script>
