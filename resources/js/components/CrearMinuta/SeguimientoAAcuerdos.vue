<template>
  <div class="my-2">
    {{acuerdosASeguimiento}}
  </div>
</template>

<script>
// import {format, parseISO} from 'date-fns';
// import { obtenerNombreCompleto } from '../../helpers';

import { createNamespacedHelpers } from 'vuex'
const { mapActions, mapGetters, mapMutations } = createNamespacedHelpers('crearMinuta')

export default {
  computed: {
    ...mapGetters(['acuerdosASeguimiento']),
  },
};
</script>
