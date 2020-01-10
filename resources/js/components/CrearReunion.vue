<template>
    <div>
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
            <b-form-group>
                <label><strong>Selecciona a los convocados a la reunión</strong></label>
                <b-table hover head-variant="dark"
                    ref="tablaConvocados"
                    selectable
                    select-mode="multi"
                    :items="cAcademia.miembrosActuales"
                    :fields="camposTablaConvocados"
                    @row-selected="actualizarConvocados"
                >
                    <template v-slot:cell(convocado)="{ rowSelected }">
                        <template v-if="rowSelected">
                        <span aria-hidden="true">&check;</span>
                        <span class="sr-only">Convocado</span>
                        </template>
                        <template v-else>
                        <span aria-hidden="true">&nbsp;</span>
                        <span class="sr-only">No convocado</span>
                        </template>
                    </template>
                    <template v-slot:cell(miembro)="data">
                        {{`${data.item.nombre} ${data.item.apellido_paterno} ${data.item.apellido_materno}`}}
                    </template>
                </b-table>
            </b-form-group>
            <hr>
            <!-- ----------- Invitados --------- -->
            <crear-reunion-agregar-invitados>
            </crear-reunion-agregar-invitados>
            <b-row>
                <b-container>
                <!-- {{academiaSeleccionada}} <br> -->
                <!-- {{fechaInicio}} <br> -->
                <!-- {{lugar}} <br> -->
                {{convocados}}<br>
                </b-container>
            </b-row>
        </b-form>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
    import ESTADO_API from '../enum-estado-api';
    // import API from '../services/api';
    export default {
        data() {
            return {
                camposTablaConvocados: [
                    {
                        key:'convocado',
                        label:'¿Convocado?'
                    },
                    'miembro',
                    'email'
                ],
                academiaSeleccionada: null,
                fechaInicio: null,
                estadoApi: ESTADO_API,
                limiteInferiorFecha: '',
                frases: {
                    ok: 'Aceptar',
                    cancel: 'Cancelar'
                },
                lugar: '',
                convocados: [],
            }
        },
        mounted() {
            let date = new Date();
            this.limiteInferiorFecha = date.toISOString();
            this.leerAcademiasQuePreside(Laravel.authUserId);
            // console.log(API.baseURL);
            // console.log(Laravel.authUserId);
            // console.log(this.cAcademias);
        },
        methods: {
            ...mapActions(
                ['leerAcademiasQuePreside', 'leerAcademia']
            ),
            seleccionarAcademia(){
                // console.log(this.academiaSeleccionada);
                if(this.academiaSeleccionada) this.leerAcademia(this.academiaSeleccionada);
            },
            actualizarConvocados(items){
                this.convocados = items;
            }
        },
        computed:{
            ...mapGetters(
                ['academias', 'estadoAcademias', 'academia', 'estadoAcademia']
            ),
            cAcademias(){
                return this.academias || null;
            },
            cAcademia(){
                return this.academia || null;
            },
        }
    }
</script>
