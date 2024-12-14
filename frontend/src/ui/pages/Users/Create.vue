<template>
  <v-card-title>
    <v-btn variant="tonal" size="small" :ripple="false" @click="openDialog">
      Adicionar usuário
    </v-btn>

    <v-dialog v-model="isDialogOpen" width="600px">
      <v-card>
        <v-form @submit.stop.prevent="submit">
          <v-card-title>Adicionar usuário</v-card-title>

          <v-card-text>
            <v-col>
              <v-text-field
                v-model="name"
                label="Nome"
                :error-messages="errors.name"
              />
              <span v-if="errors.name" class="text-red-500">{{
                errors.name
              }}</span>
            </v-col>
            <v-col>
              <v-text-field
                v-model="iti"
                v-maska="'###.###.###-##'"
                label="C.P.F"
                :error-messages="errors.iti"
              />
            </v-col>
            <v-col>
              <v-text-field
                v-model="email"
                label="Email"
                :error-messages="errors.email"
              />
            </v-col>
          </v-card-text>

          <v-card-actions>
            <v-spacer />
            <v-btn variant="text" @click="closeDialog"> Cancelar </v-btn>
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
})

const isDialogOpen = ref(props.isDialogOpen)

const router = useRouter()
const userStore = useUsersStore()

const schema = object({
  iti: string().required().label('C.P.F'),
  name: string().required().label('Nome'),
  email: string().required().email().label('E-mail'),
})

const { handleSubmit, errors, isSubmitting } = useForm({
  validationSchema: schema,
  initialValues: {
    iti: '',
    name: '',
    email: '',
  },
})

const openDialog = () => {
  isDialogOpen.value = true
}

const closeDialog = () => {
  isDialogOpen.value = false
}

const submit = handleSubmit(async (values) => {
  try {
    const itiParseNumber = parseInt(values.iti.replace(/\D/g, ''), 10);

    const params = {
      name: values.name,
      email: values.email,
      iti: itiParseNumber,
    }
    await userStore.saveUser(params)
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

const { value: iti } = useField('iti')
const { value: name } = useField('name')
const { value: email } = useField('email')
</script>
