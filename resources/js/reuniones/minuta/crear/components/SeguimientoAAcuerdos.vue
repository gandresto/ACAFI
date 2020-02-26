<template>
  <div class="my-2">
    {{ acuerdosASeguimiento ? acuerdosASeguimiento : '' }}
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
