<template>
    <v-progress-circular
      v-if="loading"
      indeterminate
      color="primary"
    />
</template>
  
<script setup>
  defineProps({
    loading: {
      type: Boolean,
      default: false,
    },
  });
</script>