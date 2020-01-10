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
            @submit="procesarInvitado"
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
    <div  v-if="error"
            class="alert alert-danger"
        >
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{error}}</strong>
    </div>
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
    import {mapGetters, mapActions} from 'vuex';
    export default {
        mounted() {
            console.log(api.baseURL);
        },
        data() {
            return {
                // consulta: '',
                camposTablaInvitados: ['invitado','email','acciones'],
                invitadoSeleccionado: null,
                error: '',
                // invitados: [],
            }
        },
        methods: {
            ...mapActions(['agregarInvitado']),
            buscarInvitado(consulta){
                let uri = `${api.baseURL}/users/buscar/${consulta}`
                return new Promise((res, rej) => {
                    if (!consulta || consulta.length<3) return res([]);
                    axios.get(uri)
                    .then(r => r.data.data)
                    .then(resultadoBusqueda => {
                        this.error = ''
                        res(resultadoBusqueda);
                    })
                    .catch(error=>{
                        res([]);
                        // Error 😨
                        if (error.response) {
                            /*
                            * The request was made and the server responded with a
                            * status code that falls out of the range of 2xx
                            */
                            console.log(error.response.data);
                            console.log(error.response.status);
                            console.log(error.response.headers);
                            if (error.response.status == 404){
                                this.error = error.response.data.message;
                            }
                        } else if (error.request) {
                            /*
                            * The request was made but no response was received, `error.request`
                            * is an instance of XMLHttpRequest in the browser and an instance
                            * of http.ClientRequest in Node.js
                            */
                            console.log(error.request);
                            this.error = error.message;
                        } else {
                            // Something happened in setting up the request and triggered an Error
                            console.log('Error: ', error.message);
                        }
                        console.log(error.config);
                                    });
                });
            },
            obtenerNombreCompleto(invitado){ // Obtengo solo lo que me interesa del resultado de búsqueda
                return `${invitado.nombre} ${invitado.apellido_paterno} ${invitado.apellido_materno}`;
            },
            procesarInvitado(invitado){
                if(this.invitados && invitado )// Si hay invitados en lista e invitado seleccionado para agregar
                {
                    if(this.invitados.find(inv => inv.id == invitado.id)) // si está en la lista de invitados
                    {
                        this.error = 'Error: El usuario ya está en la lista de invitados';
                        return;
                    }
                    if (this.academia.miembrosActuales.find(miembro => miembro.id == invitado.id)) // Si el usuario es miembro de la academia
                    {
                        this.error = 'Error: Solo se pueden agregar usuarios que no sean miembros de la academia';
                        return;
                    }
                    this.error = '';
                    this.agregarInvitado(invitado);
                    console.log(`${invitado.nombre} ${invitado.apellido_paterno} ${invitado.apellido_materno}`);
                }
            }

        },
        computed: {
            ...mapGetters(['invitados', 'academia']),
        },
    }
</script>
