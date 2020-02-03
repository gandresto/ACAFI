<template>
    <div>
        <form class="form-horizontal"  @submit.prevent="editarDivision">

            <div class="form-group row">
                <label for="siglas" class="col-md-4 col-form-label text-md-right">Siglas</label>

                <div class="col-md-6">
                    <input id="siglas" type="text" class="form-control" name="siglas" value="" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre Completo</label>

                <div class="col-md-6">
                    <input id="nombre" type="text" class="form-control" name="nombre" value="" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="fecha_ingreso" class="col-md-4 col-form-label text-md-right">Fecha de inicio de su cargo</label>

                <div class="col-md-6">
                    <input id="fecha_ingreso" type="date" class="form-control" name="fecha_ingreso" value="" required>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4 text-md-right">
                    <a class="btn btn-danger" role="button" href="">
                            <i class="fa fa-undo" aria-hidden="true"></i>
                            Regresar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Actualizar División
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<style>

</style>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                
            }
        },
        methods: {
            editarDivision(){
                
            }
        },
    }
</script>
