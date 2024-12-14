<template>
  <v-navigation-drawer v-model="isDrawerOpen">
    <v-list>
      <v-list-subheader>Menu</v-list-subheader>
      <v-list-item prepend-icon="mdi-home"
        ><router-link :to="{ name: 'dashboard' }"
          >Dashboard</router-link
        ></v-list-item
      >
      <v-list-item prepend-icon="mdi-account">
        <router-link :to="{ name: 'users' }">
          Usuários
        </router-link>
      </v-list-item>
    </v-list>
  </v-navigation-drawer>
  <v-app-bar flat class="border-b" permanent>
    <v-app-bar-nav-icon
      @click="isDrawerOpen = !isDrawerOpen"
    ></v-app-bar-nav-icon>
    <v-app-bar-title>{{ appName }}</v-app-bar-title>

    <template #append>
      <v-btn icon class="mr-2">
        <v-badge dot color="info">
          <v-icon icon="mdi-bell-outline"></v-icon>
        </v-badge>
      </v-btn>

      <v-menu>
        <template #activator="{ props }">
          <v-avatar v-bind="props">
            <v-img
              cover
              src="https://thumbs.dreamstime.com/z/nerd-portrait-young-cheerful-businessman-smiling-36201399.jpg"
            ></v-img>
          </v-avatar>
        </template>

        <v-card min-width="200px">
          <v-list :lines="false" density="compact" nav>
            <v-list-item prepend-icon="mdi-account-outline">
              <v-list-item-title>
                <router-link :to="{ name: 'profile' }">
                  Meu Perfil
                </router-link>
              </v-list-item-title>
            </v-list-item>

            <v-list-item prepend-icon="mdi-logout" @click.prevent="logout">
              <v-list-item-title>Sair</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-card>
      </v-menu>
    </template>
  </v-app-bar>
</template>
<script setup>
import { ref } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { useRouter } from 'vue-router'

const router = useRouter()
const authStore = useAuthStore()
const appName = import.meta.env.VITE_APP_NAME
const isDrawerOpen = ref(false)

const logout = () => {
  authStore.logout().finally(() => router.go())
}
</script>
