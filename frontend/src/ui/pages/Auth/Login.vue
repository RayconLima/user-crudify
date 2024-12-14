<template>
  <div>
    <v-img
      class="mx-auto my-6"
      max-width="228"
      src="https://cdn.vuetifyjs.com/docs/images/logos/vuetify-logo-v3-slim-text-light.svg"
    ></v-img>

    <v-card
      class="mx-auto pa-12 pb-8"
      elevation="8"
      max-width="448"
      rounded="lg"
    >
      <div class="text-subtitle-1 text-medium-emphasis">{{ appName }}</div>

      <v-text-field
        v-model="email"
        density="compact"
        placeholder="Email address"
        prepend-inner-icon="mdi-email-outline"
        variant="outlined"
        :error-messages="errors.email"
      ></v-text-field>
      <span class="text-red-500" v-if="errors.email">{{ errors.email }}</span>

      <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
        Password
        <RouterLink
          to="/"
          class="text-caption text-decoration-none text-blue"
        >
          Forgot login password?
        </RouterLink>
      </div>

      <v-text-field
        v-model="password"
        :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
        :type="visible ? 'text' : 'password'"
        density="compact"
        placeholder="Enter your password"
        prepend-inner-icon="mdi-lock-outline"
        variant="outlined"
        @click:append-inner="visible = !visible"
        :error-messages="errors.password"
      ></v-text-field>
      <span class="text-red-500" v-if="errors.password">{{ errors.password }}</span>

      <v-btn
        class="mb-8"
        color="blue"
        size="large"
        variant="tonal"
        block
        @click="submit"
      >
        <div v-if="isSubmitting" class="flex items-center justify-center">
          <Spinner :loading="isSubmitting" />
          <span class="ml-2">Logging in...</span>
        </div>
        <span v-else>Log In</span>
      </v-btn>

      <v-card-text class="text-center">
        <RouterLink
          :to="{ name: 'auth.register' }"
          class="text-blue text-decoration-none"
        >
          Sign up now <v-icon icon="mdi-chevron-right"></v-icon>
        </RouterLink>
      </v-card-text>
    </v-card>
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
const visible = ref(false)

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
      title: 'Success!',
      type: 'success',
    })
    router.push({ name: 'dashboard' })
  } catch (e) {
    notify({
      title: 'Authentication failed',
      text: 'Request failed',
      type: 'warn',
    })
  }
})

const { value: email } = useField('email')
const { value: password } = useField('password')
</script>