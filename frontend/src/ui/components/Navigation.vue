<template>
  <v-navigation-drawer v-model="isDrawerOpen">
    <v-list>
      <v-list-subheader>Menu</v-list-subheader>
      <v-list-item prepend-icon="mdi-home">
        <router-link :to="{ name: 'dashboard' }" class="text-decoration-none text-white">Dashboard</router-link>
      </v-list-item>
      <v-list-item prepend-icon="mdi-account">
        <router-link :to="{ name: 'users' }" class="text-decoration-none text-white">Usuários</router-link>
      </v-list-item>
    </v-list>
  </v-navigation-drawer>

  <v-app-bar flat class="border-b" permanent>
    <v-app-bar-nav-icon @click="isDrawerOpen = !isDrawerOpen"></v-app-bar-nav-icon>
    <v-app-bar-title>{{ appName }}</v-app-bar-title>

    <template #append>
      <v-menu>
        <template #activator="{ props }">
          <v-avatar v-bind="props">
            <v-img
              cover
              :src="profile?.profile_photo_path || imageDefault"
              alt="Imagem de perfil"
            ></v-img>
          </v-avatar>
        </template>

        <v-card min-width="200px">
          <v-list :lines="false" density="compact" nav>
            <v-list-item prepend-icon="mdi-account-outline">
              <v-list-item-title>
                <router-link :to="{ name: 'profile' }" class="text-decoration-none text-white">Meu Perfil</router-link>
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
import { ref, computed } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { useMeStore } from '@/stores/me'
import { useRouter } from 'vue-router'

const router = useRouter()
const authStore = useAuthStore()
const meStore = useMeStore()
const appName = import.meta.env.VITE_APP_NAME
const isDrawerOpen = ref(false)
const imageDefault = 'https://thumbs.dreamstime.com/z/nerd-portrait-young-cheerful-businessman-smiling-36201399.jpg'

const profile = computed(() => meStore.user)

const logout = () => {
  authStore.logout().finally(() => router.go())
}
</script>