<template>
  <div class="authentication">
    <v-container fluid class="pa-3">
      <v-row class="h-100vh d-flex justify-center align-center">
        <v-col cols="12" lg="4" xl="3" class="d-flex align-center">
          <v-card
            rounded="md"
            elevation="10"
            class="mx-auto mt-16"
            max-width="500"
          >
            <v-card-item class="pa-sm-8">
              <div class="text-body-1 text-muted text-center mb-3">
                {{ appName }}
              </div>
              <v-form
                @submit.stop.prevent="submit"
                class="space-y-4 md:space-y-6"
              >
                <v-col cols="12">
                  <v-label class="font-weight-bold mb-1">E-mail</v-label>
                  <v-text-field
                    v-model="email"
                    :error-messages="errors.email"
                    variant="outlined"
                    hide-details
                    color="primary"
                  ></v-text-field>
                  <span class="text-red-500" v-if="errors.email">{{
                    errors.email
                  }}</span>
                </v-col>
                <v-col cols="12">
                  <v-label class="font-weight-bold mb-1">Senha</v-label>
                  <v-text-field
                    v-model="password"
                    :error-messages="errors.password"
                    variant="outlined"
                    type="password"
                    hide-details
                    color="primary"
                  ></v-text-field>
                  <span class="text-red-500" v-if="errors.password">{{
                    errors.password
                  }}</span>
                </v-col>
                <v-col cols="12" class="pt-0">
                  <div class="d-flex flex-wrap align-center ml-n2">
                    <v-checkbox v-model="checkbox" color="primary" hide-details>
                      <template v-slot:label class="text-body-1"
                        >Lembrar-me</template
                      >
                    </v-checkbox>
                    <div class="ml-sm-auto">
                      <RouterLink
                        to="/"
                        class="text-primary text-decoration-none text-body-1 opacity-1 font-weight-medium"
                        >Esqueceu a senha?</RouterLink
                      >
                    </div>
                  </div>
                </v-col>
                <v-col cols="12" class="pt-0">
                  <v-btn type="submit" color="primary" size="large" block flat>
                    <div
                      v-if="isSubmitting"
                      class="flex items-center justify-center"
                    >
                      <Spinner :loading="isSubmitting" />
                      <span class="ml-2">Entrando....</span>
                    </div>
                    <span v-else>Entrar</span>
                  </v-btn>
                </v-col>
              </v-form>
              <h6
                class="text-h6 text-muted font-weight-medium d-flex justify-center align-center mt-3"
              >
                Novo na Modernize?
                <RouterLink
                  :to="{ name: 'auth.register' }"
                  class="text-primary text-decoration-none text-body-1 opacity-1 font-weight-medium pl-2"
                  >Criar uma conta</RouterLink
                >
              </h6>
            </v-card-item>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>
<script setup>
import { notify } from '@kyvg/vue3-notification'
import { useRouter } from 'vue-router'
import { useField, useForm } from 'vee-validate'
import { object, string } from 'yup'
import Spinner from '@/ui/components/Spinner.vue'
import { useAuthStore } from '@/stores/auth'

const appName = import.meta.env.VITE_APP_NAME

const authStore = useAuthStore()
const router = useRouter()

const schema = object({
  email: string().required().email().label('E-mail'),
  password: string().required().min(6).label('Senha'),
})

const { handleSubmit, errors, isSubmitting } = useForm({
  validationSchema: schema,
  initialValues: {
    email: '',
    password: '',
  },
})

const submit = handleSubmit(async (values) => {
  try {
    await authStore.login(values.email, values.password)
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

const { value: email } = useField('email')
const { value: password } = useField('password')
</script>
