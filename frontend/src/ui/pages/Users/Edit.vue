<template>
  <v-card-title>
    <v-btn @click="openDialog" variant="tonal" color="orange" size="small" :ripple="false"
      >Alterar</v-btn
    >

    <v-dialog v-model="isDialogOpen" width="600px">
      <v-card>
        <v-form @submit.stop.prevent="submit">
          <v-card-title>Adicionar usuário</v-card-title>

          <v-card-text>
            <v-col>
              <v-text-field
                label="Nome"
                v-model="name"
                :error-messages="errors.name"
              ></v-text-field>
              <span class="text-red-500" v-if="errors.name">{{
                errors.name
              }}</span>
            </v-col>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn variant="text" @click="closeDialog">Cancelar</v-btn>
            <v-btn variant="tonal" color="success" @click="submit">
              <!-- Salvar -->
              <div v-if="isSubmitting" class="flex items-center justify-center">
                <Spinner :loading="isSubmitting" />
                <span class="ml-2">Salvando....</span>
              </div>
              <span v-else>Salvar</span>
            </v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
  </v-card-title>
</template>

<script setup>
import { notify } from '@kyvg/vue3-notification'
import { useRouter } from 'vue-router'
import { useUsersStore } from '@/stores/users'
import { useField, useForm } from 'vee-validate'
import { ref, defineProps } from 'vue'
import { object, string } from 'yup'

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

const router = useRouter()
const userStore = useUsersStore()

const schema = object({
  name: string().required().label('Nome'),
})

const { handleSubmit, errors, isSubmitting } = useForm({
  validationSchema: schema,
  initialValues: user.value,
})

const openDialog = (passedUser) => {
  user.value = { ...passedUser }
  isDialogOpen.value = true
}

const closeDialog = () => {
  isDialogOpen.value = false
}

const submit = handleSubmit(async (values) => {
  try {
    user.value = { ...user.value, ...values }

    const params = {
      ...user.value,
    }

    await userStore.updateUser(user.value.id, params)
    notify({
      title: 'Deu certo!',
      type: 'success',
    })
    router.push({ name: 'dashboard' })
  } catch (e) {
    notify({
      title: 'Falha ao autenticar',
      text: 'Falha na requisição',
      type: 'warn',
    })
  }
})

const { value: name } = useField('name')
</script>
