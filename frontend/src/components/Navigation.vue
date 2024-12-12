<template>
  <v-navigation-drawer v-model="isDrawerOpen">
    <v-list-subheader>Menu</v-list-subheader>

    <v-list-item prepend-icon="mdi-home" to="/">Home</v-list-item>
    <v-list-item prepend-icon="mdi-account" to="/users">Usuários</v-list-item>
  </v-navigation-drawer>

  <v-app-bar flat class="border-b">
    <v-app-bar-nav-icon @click="isDrawerOpen = !isDrawerOpen"></v-app-bar-nav-icon>
    <v-app-bar-title>Meu app</v-app-bar-title>

    <template #append>
      <v-menu>
        <template #activator="{ props }">
          <v-avatar v-bind="props">
            <v-img cover src="https://thumbs.dreamstime.com/z/nerd-portrait-young-cheerful-businessman-smiling-36201399.jpg" />
          </v-avatar>
        </template>

        <v-card min-width="200px">
          <v-list :lines="false" density="compact" nav>
            <v-list-item prepend-icon="mdi-account-outline">
              <v-list-item-title>Meu perfil</v-list-item-title>
            </v-list-item>

            <v-list-item prepend-icon="mdi-chevron-left-box">
              <v-list-item-title>Sair</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-card>
      </v-menu>
    </template>
  </v-app-bar>
</template>

<script lang="ts" setup>
import { ref } from 'vue';

const isDrawerOpen = ref(false);
</script>

<style scoped>
/* Add any specific styles for the component here */
</style>