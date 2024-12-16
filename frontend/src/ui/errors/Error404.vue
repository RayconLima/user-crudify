<!-- src/components/NotFound.vue -->
<template>
    <v-container class="fill-height" fluid>
      <v-row align="center" justify="center">
        <v-col class="text-center">
          <!-- <v-img
            src="@/assets/404.png"
            max-width="400"
            contain
          ></v-img> -->
          <h1 class="display-1">404</h1>
          <h2>Página Não Encontrada</h2>
          <p>Desculpe, a página que você está procurando não existe.</p>
          <v-btn color="primary">
            <RouterLink :to="{ name: 'dashboard' }" class="text-decoration-none text-white">
              Voltar para o Dashboard
            </RouterLink>
          </v-btn>
        </v-col>
      </v-row>
    </v-container>
  </template>
  
  <script>
  export default {
    name: 'NotFound',
  }
  </script>
  
  <style scoped>
  .fill-height {
    height: 100vh;
  }
  </style>