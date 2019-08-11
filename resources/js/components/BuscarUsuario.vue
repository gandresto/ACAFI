<template>
    <div>
        <div class="form-group row">
            <label for="buscarAcademico" class="col-md-4 control-label text-md-right" v-text="labelInicial"></label>
            <div class="col-md-6">
                <input id="buscarAcademico" name="buscarAcademico"
                        type="text"
                        class="form-control"
                        placeholder="Buscar..."
                        v-model="busqueda"
                        @input="buscarAcademico"
                        v-on:keyup.delete="buscarAcademico" >
            </div>
        </div><!-- /form-group -->
        <div :class="[tieneErrores ? 'form-group is-invalid' : 'form-group']">
            <div class="col-md-8 offset-md-4">
                <div class="radio" v-for="(academico, index) in academicos" :key="index">
                    <label :for="[academico.id]">
                        <input type="radio" 
                                :name="inputName" 
                                :id="[academico.id]" 
                                :value="[academico.id]" 
                                required
                                :checked="index==0">
                            {{ academico.grado_id + ' ' + academico.nombre + ' ' + academico.apellido_pat + ' ' + academico.apellido_mat}}
                    </label>
                </div>

                <span class="help-block" v-if="errores">
                    <strong>{{ errores }}</strong>
                </span>

            </div>
        </div>

    </div>
</template>

<script>
    export default {
        mounted() {
            this.buscarAcademico();
        },

        props : ['errores', 'tieneErrores', 'busquedaInicial', 'inputTagName', 'labelInicial'],

        data : function () {
            return {
                busqueda : this.busquedaInicial,
                academicos : null,
                inputName : this.inputTagName
            }
        },

        methods: {
            buscarAcademico(){
                if(this.busqueda.length > 2){
                    axios.get('/academicos/buscar/' + this.busqueda)
                        .then(response => {
                            this.academicos = response.data;
                        });
                }
            }
        }
    }
</script>
