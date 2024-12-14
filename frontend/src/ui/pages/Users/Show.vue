<template>
    <v-card-title>
      <v-btn @click="openDialog" variant="tonal" color="primary" size="small" :ripple="false"
        >Visualizar
      </v-btn>
  
      <v-dialog v-model="isDialogOpen" width="600px">
        <v-card>
            <v-card-title>Visualizar Informações</v-card-title>
            <v-card-text>
              <p><strong>Nome:</strong> {{ user.name }}</p>
              <p><strong>Email:</strong> {{ user.email }}</p>
              <p><strong>CPF:</strong> {{ formatITI(user.iti) }}</p>
              <p><strong>Status:</strong> {{ getStatus(user.status) }}</p>
            </v-card-text>      
            <v-card-actions>
              <v-spacer />
              <v-btn variant="text" @click="closeDialog">Cancelar</v-btn>
            </v-card-actions>
        </v-card>
      </v-dialog>
    </v-card-title>
</template>
<script setup>
import { ref, defineProps } from 'vue'
import { getStatus } from '@/utils/status'
import { formatITI } from '@/utils/masks'

const props = defineProps({
  isDialogOpen: {
    type: Boolean,
    default: false,
  },
  user: {
    type: Object,
    default: null,
  },
})

const isDialogOpen = ref(props.isDialogOpen)
const user = ref(props.user || {})

const openDialog = () => {
  isDialogOpen.value = true
}

const closeDialog = () => {
  isDialogOpen.value = false
}
</script>
