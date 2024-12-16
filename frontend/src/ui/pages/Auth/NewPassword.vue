<template>
    <div>
      <v-img
        class="mx-auto my-6"
        max-width="228"
        src="https://cdn.vuetifyjs.com/docs/images/logos/vuetify-logo-v3-slim-text-light.svg"
      />
      <v-card
        class="mx-auto pa-12 pb-8"
        elevation="8"
        max-width="448"
        rounded="lg"
      >
        <v-form @submit.prevent="submit">
          <v-text-field
            v-model="password"
            :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
            :type="visible ? 'text' : 'password'"
            density="compact"
            placeholder="Entre com sua senha"
            prepend-inner-icon="mdi-lock-outline"
            variant="outlined"
            @click:append-inner="visible = !visible"
            :error-messages="errors.password"
            aria-label="Senha"
            aria-describedby="password-error"
          />
          <span id="password-error" class="error-message" v-if="errors.password">{{ errors.password }}</span>
  
          <v-text-field
            v-model="confirmPassword"
            :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
            :type="visible ? 'text' : 'password'"
            density="compact"
            placeholder="Confirmar Senha"
            prepend-inner-icon="mdi-lock-outline"
            variant="outlined"
            @click:append-inner="visible = !visible"
            :error-messages="errors.confirmPassword"
            aria-label="Confirmar Senha"
            aria-describedby="confirm-password-error"
          />
          <span id="confirm-password-error" class="error-message" v-if="errors.confirmPassword">{{ errors.confirmPassword }}</span>
  
          <v-btn
            class="mb-8"
            color="blue"
            size="large"
            variant="tonal"
            block
            type="submit"
          >
            <div v-if="isSubmitting" class="flex items-center justify-center">
              <Spinner :loading="isSubmitting" />
              <span class="ml-2">Salvando...</span>
            </div>
            <span v-else>Salvar</span>
          </v-btn>
        </v-form>
        <v-card-text class="text-center">
          <RouterLink
            :to="{ name: 'auth.login' }"
            class="text-blue text-decoration-none"
          >
            Voltar ao login <v-icon icon="mdi-chevron-right"></v-icon>
          </RouterLink>
        </v-card-text>
      </v-card>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import { object, string, ref as yupRef } from 'yup'
  import { useRouter } from 'vue-router'
  import Spinner from '@/ui/components/Spinner.vue'
  import { notify } from '@kyvg/vue3-notification'
  import { useField, useForm } from 'vee-validate'
  import { useAuthStore } from '@/stores/auth'
  
  const authStore = useAuthStore()
  const router = useRouter()
  const visible = ref(false)
  
  const schema = object({
    password: string().required('Senha é obrigatória').min(6, 'A senha deve ter pelo menos 6 caracteres').label('Senha'),
    confirmPassword: string()
      .required('Confirmação de senha é obrigatória')
      .oneOf([yupRef('password')], 'As senhas devem corresponder')
      .label('Confirmar Senha'),
  })
  
  const { handleSubmit, errors, isSubmitting } = useForm({
    validationSchema: schema,
    initialValues: {
      password: '',
      confirmPassword: '',
    },
  })
  
  const submit = handleSubmit(async (values) => {
    try {
      const params = {
        token: router.currentRoute.value.query.token,
        password: values.password,
        password_confirmation: values.confirmPassword
      }
  
      await authStore.updatePasswordByInvitation(params)
      notify({
        title: 'Senha atualizada com sucesso!',
        type: 'success',
      })
      router.push({ name: 'auth.login' })
    } catch (e) {
      notify({
        title: 'Falha ao atualizar a senha',
        text: e.response?.data?.message || 'Erro na requisição',
        type: 'warn',
      })
    }
  })
  
  const { value: password } = useField('password')
  const { value: confirmPassword } = useField('confirmPassword')
  </script>