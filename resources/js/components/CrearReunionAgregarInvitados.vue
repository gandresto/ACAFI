<template>
<div>
    <b-form-group>
        <label><strong>Agregar invitados externos a la academia</strong></label>
    </b-form-group>
    <b-form-group>
        <autocomplete :search="buscarInvitado"
            placeholder="Buscar usuario"
            aria-label="Buscar usuario"
            :get-result-value="obtenerNombreCompleto"
            @submit="agregarInvitado"
        >
            <template #result="{ result, props }">
                <li
                    v-bind="props"
                    class="autocomplete-result"
                >
                    {{obtenerNombreCompleto(result)}}
                </li>
            </template>
        </autocomplete>
    </b-form-group>
    <b-form-group>
        <b-table
            head-variant="dark"
            ref="tablaInvitados"
            :fields="camposTablaInvitados"
            :items="invitados"
            responsive="sm"
        >
        <template v-slot:cell(invitado)="data">
            {{obtenerNombreCompleto(data.item)}}
        </template>
        </b-table>
    </b-form-group>
    <b-row>
        <b-container>
            <!-- {{consulta}}<br> -->
            <!-- {{resultadoBusqueda}}<br> -->
            <!-- {{invitados}}<br> -->
        </b-container>
    </b-row>
</div>
</template>

<script>
    import api from '../services/api';
    export default {
        mounted() {
            console.log(api.baseURL);
        },
        data() {
            return {
                // consulta: '',
                camposTablaInvitados: ['invitado','email','acciones'],
                invitadoSeleccionado: null,
                invitados: [],
            }
        },
        methods: {
            buscarInvitado(consulta){
                let uri = `${api.baseURL}/users/buscar/${consulta}`
                return new Promise((res, rej) => {
                    if (!consulta || consulta.length<3) return res([]);
                    axios.get(uri)
                    .then(r => r.data.data)
                    .then(resultadoBusqueda => {
                        res(resultadoBusqueda);
                    })
                    .catch(err=>{
                        console.log(err);
                        res([]);
                    });
                });
            },
            obtenerNombreCompleto(invitado){ // Obtengo solo lo que me interesa del resultado de búsqueda
                return `${invitado.nombre} ${invitado.apellido_paterno} ${invitado.apellido_materno}`;
            },
            agregarInvitado(invitado){
                if(this.invitados && invitado){
                    !this.invitados.find(inv => invitado.id == inv.id) ? this.invitados.push(invitado) : null;
                    console.log(`${invitado.nombre} ${invitado.apellido_paterno} ${invitado.apellido_materno}`);
                }
            }

        },
        computed: {
        },
    }
</script>
