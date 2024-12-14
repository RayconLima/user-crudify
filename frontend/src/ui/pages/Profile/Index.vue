<template>
    <v-container>
        <v-breadcrumbs :items="items">
          <template v-slot:prepend>
            <v-icon icon="$vuetify" size="small"></v-icon>
          </template>
        </v-breadcrumbs>
        <v-card flat class="border mb-4">
            <v-card-title> Minhas Informações </v-card-title>
            <v-card-text>
              <p><strong>Nome:</strong> {{ user.name }}</p><br/>
              <p><strong>Email:</strong> {{ user.email }}</p><br/>
              <p><strong>CPF:</strong> {{ formatITI(user.iti) }}</p><br/>
              <p><strong>Status:</strong> {{ getStatus(user.status) }}</p>
            </v-card-text>
        </v-card>
    </v-container>
</template>
<script setup>
import { useMeStore } from '@/stores/me'
import { getStatus } from '@/utils/status'
import { formatITI } from '@/utils/masks'

const user = computed(() => useMeStore().user)

const items = ref([
  {
    title: 'Perfil',
    disabled: false,
    to: { name: 'dashboard' },
  },
])
</script>