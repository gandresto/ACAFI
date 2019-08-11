<template>
    <div>
        <div class="form-group row">
            <label for="buscarDivision" class="col-md-4 control-label text-md-right" v-text="labelInicial"></label>
            <div class="col-md-6">
                <input id="buscarDivision" name="buscarDivision"
                        type="text"
                        class="form-control"
                        placeholder="Buscar..."
                        v-model="busqueda"
                        @input="buscarDivision"
                        v-on:keyup.delete="buscarDivision" >
            </div>
        </div><!-- /form-group -->
        <div :class="[tieneErrores ? 'form-group is-invalid' : 'form-group']">
            <div class="col-md-8 offset-md-4">
                <div class="radio" v-for="(division, index) in divisions" :key="index">
                    <label :for="[division.id]">
                        <input type="radio" :name="inputName" :id="[division.id]" :value="[division.id]" required>
                        {{ division.nombre}}
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
            this.buscarDivision();
            console.log(this.labelInicial);
        },

        props : ['errores', 'tieneErrores', 'busquedaInicial', 'inputTagName', 'labelInicial'],

        data : function () {
            return {
                busqueda : this.busquedaInicial,
                divisions : null,
                inputName : this.inputTagName
            }
        },

        methods: {
            buscarDivision(){
                if(this.busqueda.length > 2){
                    axios.get('/divisions/buscar/' + this.busqueda)
                        .then(response => {
                            this.divisions = response.data;
                            console.log(this.divisions);
                        });
                }
            }
        }
    }
</script>
