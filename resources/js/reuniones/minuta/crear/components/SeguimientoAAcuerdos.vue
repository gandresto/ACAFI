<template>
  <div class="my-2">
    <div class="row form-group">
      <div class="col-sm-12">
        <div class="small-title">Acuerdos a los que se les dio seguimiento</div>
      </div>
    </div>
    <div class="row form-group">
      <div class="col-sm-12">
        {{ acuerdosASeguimiento ? acuerdosASeguimiento : '' }}
      </div>
    </div>    
  </div>
</template>

<script>

import { mapGetters } from 'vuex';

export default {
  computed: {
    ...mapGetters(['acuerdosASeguimiento']),
  },
};
</script>
