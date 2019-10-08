<template>
    <div>
        <div class="form-group row">
            <label for="buscarUser" class="col-md-4 control-label text-md-right" v-text="labelInicial"></label>
            <div class="col-md-6">
                <input id="buscarUser" name="buscarUser"
                        type="text"
                        class="form-control"
                        placeholder="Buscar..."
                        v-model="busqueda"
                        @input="buscarUser"
                        v-on:keyup.delete="buscarUser" >
            </div>
        </div><!-- /form-group -->
        <div :class="[tieneErrores ? 'form-group is-invalid' : 'form-group']">
            <div class="col-md-8 offset-md-4">
                <div class="radio" v-for="(user, index) in users" :key="index">
                    <label :for="[user.id]">
                        <input type="radio" 
                                :name="inputName" 
                                :id="[user.id]" 
                                :value="[user.id]" 
                                required
                                :checked="index==0">
                            {{ user.grado + ' ' + user.nombre + ' ' + user.apellido_pat + ' ' + user.apellido_mat}}
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
            this.buscarUser();
        },

        props : ['errores', 'tieneErrores', 'busquedaInicial', 'inputTagName', 'labelInicial'],

        data : function () {
            return {
                busqueda : this.busquedaInicial,
                users : null,
                inputName : this.inputTagName
            }
        },

        methods: {
            buscarUser(){
                if(this.busqueda.length > 2){
                    axios.get('/users/buscar/' + this.busqueda)
                        .then(response => {
                            this.users = response.data;
                        });
                }
            }
        }
    }
</script>
