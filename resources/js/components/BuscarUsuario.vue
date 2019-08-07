<template>
    <div>
        <div class="form-group row">
            <label for="buscarJefe" class="col-md-4 control-label text-md-right">Jefe de División</label>
            <div class="col-md-6">
                <input id="buscarJefe" name="buscarJefe" v-model="busqueda" @input="buscarAcademico" v-on:keyup.delete="buscarAcademico" type="text" class="form-control" placeholder="Buscar...">
            </div>

        </div><!-- /form-group -->
        <div :class="[tieneerrores ? 'form-group is-invalid' : 'form-group']">
            <div class="col-md-8 offset-md-4">
                <div class="radio" v-for="(academico, index) in academicos" :key="index">
                    <label :for="[academico.id]">
                        <input type="radio" name="jefeDeDivision" :id="[academico.id]" :value="[academico.id]" required>
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
            console.log('Component mounted.')
        },

        props : ['errores', 'tieneerrores'],

        data : function () {
            return {
                busqueda : '',
                academicos : null
            }
        },

        methods: {
            buscarAcademico(){
                if(this.busqueda.length > 2){
                    axios.get('/academicos/buscar/' + this.busqueda)
                        .then(response => {
                            this.academicos = response.data;
                            console.log(this.academicos);
                        });
                }
            }
        }
    }
</script>
