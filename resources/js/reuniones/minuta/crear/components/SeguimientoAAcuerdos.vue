<template>
  <div class="my-2">
    {{acuerdosASeguimiento}}
  </div>
</template>

<script>
// import {format, parseISO} from 'date-fns';
// import { obtenerNombreCompleto } from '../../helpers';

import { mapGetters } from 'vuex';

export default {
  computed: {
    ...mapGetters(['acuerdosASeguimiento']),
  },
};
</script>
