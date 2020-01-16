<template>
    <div>
        <b-form-group>
            <strong>Temas o asuntos por revisar en esta reunión</strong>
        </b-form-group>
        <b-form-group>
            <ol>
                <li class="my-2 px-2"
                    v-for="tema in temas" :key="tema.id"
                >
                    <crear-reunion-agregar-temas-tema-item
                        :tema="tema"
                    ></crear-reunion-agregar-temas-tema-item>
                </li>
                <li class="my-2 px-2">
                    <b-input-group>
                        <b-form-input v-model="nuevoTema"
                            :state="temaValido"
                            trim
                        >
                        </b-form-input>
                        <b-input-group-append>
                            <b-button variant="success"
                                title="Agregar tema"
                                :disabled="!temaValido"
                                @click="agregarNuevoTema(nuevoTema)"
                            >
                                <i class="fa fa-plus-circle" aria-hidden="true"><span class="sr-only">Agregar tema</span></i>
                            </b-button>
                        </b-input-group-append>
                        <div class="invalid-feedback">
                            {{mensajeError}}
                        </div>
                    </b-input-group>
                </li>
            </ol>
        </b-form-group>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
    export default {
        mounted() {
            // console.log('Component mounted.')
        },
        data(){
            return{
                nuevoTema : '',
            }
        },
        methods:{
            ...mapActions(['agregarTema']),
            agregarNuevoTema(tema){
                if(tema.length>3){
                    // console.log(tema);
                    this.agregarTema({
                        id: this.temas.length ? this.temas.length + 1 : 1,
                        descripcion: tema,
                    });
                }
            }

        },
        computed: {
            ...mapGetters(['temas']),
            temaValido(){
                return this.nuevoTema.length > 3 ? true : false;
            },
             mensajeError() {
                if (this.nuevoTema.length > 3) {
                    return ''
                } else if (this.nuevoTema.length > 0) {
                    return 'Ingresa al menos 3 caracteres'
                } else {
                    return 'Ingresa un tema'
                }
            },
        },
    }
</script>
