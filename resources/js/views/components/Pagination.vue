<!-- @format -->

<template>
  <b-button-group>
    <b-button
      size="lg"
      :disabled="isFirstPage || loadingPrev"
      @click="$emit('previous')"
      class="b_prev mr-2"
      ><b-spinner v-if="loadingPrev" label="Loading..."> </b-spinner
      ><template v-else>PREVIOUS</template></b-button
    >
    <b-button
      size="lg"
      :disabled="isRetrieving"
      @click="$emit('next')"
      class="b_next ml-2"
      ><b-spinner v-if="loadingNext" label="Loading..."></b-spinner>
      <template v-else>NEXT</template>
    </b-button>
  </b-button-group>
</template>

<style scoped>
.b_prev {
  background-color: #2c53ff;
}
.b_next {
  background-color: #2c53ff;
}
</style>

<script>
export default {
  props: {
    isFirstPage: {
      type: Boolean,
      required: true
    },
    isRetrieving: {
      type: Boolean,
      required: true
    },
    loadingPrev: {
      type: Boolean,
      required: true
    },
    loadingNext: {
      type: Boolean,
      required: true
    }
  }
}
</script>
