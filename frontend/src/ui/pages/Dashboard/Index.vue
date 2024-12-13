<template>
  <v-container>
    <v-breadcrumbs :items="items">
      <template v-slot:prepend>
        <v-icon icon="$vuetify" size="small"></v-icon>
      </template>
    </v-breadcrumbs>
  </v-container>
</template>

<script setup>
const items = ref([
  {
    title: 'Dashboard',
    disabled: false,
    to: { name: 'dashboard' },
  },
])
</script>
