<template>
  <div class="form-group row my-2">
    <div class="col-md-12">
      <div class="alert alert-danger">
        <!-- <button type="button" class="close" @click="eliminarError" data-dismiss="alert">×</button> -->
        <strong>{{error}}</strong>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['error'],
  methods: {
    eliminarError(){
      console.log('eliminar: ', this.error);
    }
  },
}
</script>