<template>
    <div class="container">
        <b-form-group>
            <label><strong>Selecciona a los convocados a la reunión</strong></label>
            <b-table hover head-variant="dark"
                ref="tablaConvocados"
                selectable
                selected-variant="primary"
                select-mode="multi"
                :items="cAcademia.miembrosActuales"
                :fields="camposTablaConvocados"
                responsive="sm"
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
        <!-- <b-form-group>
            {{convocados}}
        </b-form-group> -->
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data(){
            return{
                camposTablaConvocados: [
                    {
                        key:'convocado',
                        label:'¿Convocado?'
                    },
                    'miembro',
                    'email'
                ],
            }
        },
        methods:{
            ...mapActions(['ponerConvocados']),
            actualizarConvocados(items){
                this.ponerConvocados(items);
            }
        },
        computed: {
            ...mapGetters(
                ['academia', 'convocados']
            ),
            cAcademia(){
                return this.academia || null;
            },
        },
    }
</script>
