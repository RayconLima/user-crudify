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
              <p><strong>Nome:</strong> {{ profile.name }}</p>
              <p><strong>Email:</strong> {{ profile.email }}</p>
              <p><strong>CPF:</strong> {{ formatITI(profile.iti) }}</p>
              <p><strong>Status:</strong> {{ getStatus(profile.status) }}</p>
          </v-card-text>
      </v-card>

      <v-card flat class="border mb-4">
          <v-card-title> Atualizar Senha </v-card-title>
          <v-card-text>
              <v-form @submit.stop.prevent="submit" class="space-y-4 md:space-y-6">
                  <v-col cols="12">
                      <v-label class="font-weight-bold mb-1">Senha</v-label>
                      <v-text-field
                          v-model="password"
                          :error-messages="errors.password"
                          variant="outlined"
                          :type="passwordVisible ? 'text' : 'password'"
                          hide-details
                          color="primary"
                          append-icon="mdi-eye"
                          @click:append="togglePasswordVisibility"
                      />
                      <span class="text-red-500" v-if="errors.password">{{ errors.password }}</span>
                  </v-col>

                  <v-col cols="12">
                      <v-label class="font-weight-bold mb-1">Confirmar Senha</v-label>
                      <v-text-field
                          v-model="password_confirmation"
                          :error-messages="errors.password_confirmation"
                          variant="outlined"
                          :type="passwordConfirmationVisible ? 'text' : 'password'"
                          hide-details
                          color="primary"
                          append-icon="mdi-eye"
                          @click:append="togglePasswordConfirmationVisibility"
                      />
                      <span class="text-red-500" v-if="errors.password_confirmation">{{ errors.password_confirmation }}</span>
                  </v-col>

                  <v-col cols="3" class="pt-0 float-right">
                    <v-btn type="submit" color="primary" size="large" block flat>
                        <template v-if="isSubmitting">
                            <Spinner :loading="isSubmitting" />
                            <span class="ml-2">Salvando....</span>
                        </template>
                        <template v-else>Salvar</template>
                    </v-btn>
                  </v-col>
              </v-form>
          </v-card-text>
      </v-card>
  </v-container>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useField, useForm } from 'vee-validate'
import { object, string, ref as yupRef } from 'yup'
import { notify } from '@kyvg/vue3-notification'
import { useRouter } from 'vue-router'
import { useMeStore } from '@/stores/me'
import { getStatus } from '@/utils/status'
import { formatITI } from '@/utils/masks'
import Spinner from '@/ui/components/Spinner.vue'

const meStore = useMeStore()
const profile = computed(() => meStore.user)

const items = ref([
  {
    title: 'Perfil',
    disabled: false,
    to: { name: 'dashboard' },
  },
])

const router = useRouter()

const schema = object({
  password: string().required('Senha é obrigatória').min(6, 'A senha deve ter pelo menos 6 caracteres'),
  password_confirmation: string()
      .required('Confirmação de senha é obrigatória')
      .oneOf([yupRef('password'), null], 'As senhas devem corresponder'),
})

const { handleSubmit, errors, isSubmitting } = useForm({
  validationSchema: schema,
  initialValues: {
      password: '',
      password_confirmation: ''
  },
})

const submit = handleSubmit(async (values) => {
  try {
      const params = {
          password: values.password,
          password_confirmation: values.password_confirmation,
      }
      await meStore.updatePassword(params)
      notify({
          title: 'Sucesso!',
          type: 'success',
      })
      router.push({ name: 'profile' })
  } catch (e) {
      notify({
          title: ' Erro',
          text: 'Falha na requisição',
          type: 'warn',
      })
  }
})

const { value: password } = useField('password')
const { value: password_confirmation } = useField('password_confirmation')

const passwordVisible = ref(false)
const passwordConfirmationVisible = ref(false)

const togglePasswordVisibility = () => {
  passwordVisible.value = !passwordVisible.value
}

const togglePasswordConfirmationVisibility = () => {
  passwordConfirmationVisible.value = !passwordConfirmationVisible.value
}
</script>