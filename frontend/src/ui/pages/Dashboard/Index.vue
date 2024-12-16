<template>
  <v-container>
    <v-breadcrumbs :items="items">
      <template v-slot:prepend>
        <v-icon icon="$vuetify" size="small"></v-icon>
      </template>
    </v-breadcrumbs>

    <v-card flat class="border mb-4">
      <v-card-text>
        <v-row>
          <v-col cols="12" sm="12">
            <v-card flat class="border">
              <v-row>
                <v-col cols="12" sm="4">
                  <v-card flat class="border">
                    <v-card-title>Total de usuários</v-card-title>
                    <v-card-text>{{ totalUsers }}</v-card-text>
                  </v-card>
                </v-col>
                <v-col cols="12" sm="4">
                  <v-card flat class="border">
                    <v-card-title>Usuários pendentes</v-card-title>
                    <v-card-text>{{ pendingUsers }}</v-card-text>
                  </v-card>
                </v-col>
                <v-col cols="12" sm="4">
                  <v-card flat class="border">
                    <v-card-title>Usuários ativos</v-card-title>
                    <v-card-text>{{ activeUsers }}</v-card-text>
                  </v-card>
                </v-col>
              </v-row>
            </v-card>
          </v-col>
        </v-row>  
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script setup>
import { ref } from 'vue'
import { useUsersStore } from '@/stores/users'

const userStore = useUsersStore()

onMounted(() => userStore.getUsers())

const totalUsers = computed(() => userStore.getTotalUsers)
const pendingUsers = computed(() => userStore.getPendingUsers)
const activeUsers = computed(() => userStore.getActiveUsers)

const items = ref([
  {
    title: 'Dashboard',
    disabled: false,
    to: { name: 'dashboard' },
  },
])
</script>
