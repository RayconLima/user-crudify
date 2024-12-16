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
      <v-form>
        <v-col cols="6">
          <v-avatar @click="triggerFileInput" class="bg-white" style="cursor: pointer;width:200px;height:200px;">
            <v-img
              :aspect-ratio="1"
              :src="profileImage"
              width="300"
              cover
            />
            <input
              type="file"
              ref="fileInput"
              @change="onFileChange"
              accept="image/*"
              style="display: none;"
            />
          </v-avatar>
        </v-col>

        <v-text-field
          v-model="name"
          density="compact"
          placeholder="Nome Completo"
          prepend-inner-icon="mdi-account-outline"
          variant="outlined"
          :error-messages="errors.name"
        />

        <v-text-field
          v-model="iti"
          v-maska="'###.###.###-##'"
          density="compact"
          placeholder="CPF"
          prepend-inner-icon="mdi-card-account-details-outline"
          variant="outlined"
          :error-messages="errors.iti"
        />

        <v-text-field
          v-model="email"
          density="compact"
          placeholder="Endereço de e-mail"
          prepend-inner-icon="mdi-email-outline"
          variant="outlined"
          :error-messages="errors.email"
        />

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
        />

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
        />

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
            <span class="ml-2">Cadastrando...</span>
          </div>
          <span v-else>Cadastrar-se</span>
        </v-btn>
      </v-form>
      <v-card-text class="text-center">
        <RouterLink
          :to="{ name: 'auth.login' }"
          class="text-blue text-decoration-none"
        >
          Já tem uma conta? Entre <v-icon icon="mdi-chevron-right"></v-icon>
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

const appName = import.meta.env.VITE_APP_NAME
const authStore = useAuthStore()
const router = useRouter()
const visible = ref(false)
const profileImage = ref(null)
const selectedFile = ref(null)

const schema = object({
  name: string().required().label('Nome Completo'),
  iti: string().required().label('CPF'),
  email: string().required().email().label('E-mail'),
  password: string().required().min(6).label('Senha'),
  confirmPassword: string()
    .required()
    .oneOf([yupRef('password')], 'As senhas devem corresponder')
    .label('Confirmar Senha'),
})

const { handleSubmit, errors, isSubmitting } = useForm({
  validationSchema: schema,
  initialValues: {
    name: '',
    iti: '',
    email: '',
    password: '',
    confirmPassword: '',
  },
})

const triggerFileInput = () => {
  const fileInput = document.querySelector('input[type="file"]')
  fileInput.click()
}

const onFileChange = (event) => {
  const file = event.target.files[0]
  if (file) {
    profileImage.value = URL.createObjectURL(file)
    selectedFile.value = file
  }
}

const submit = handleSubmit(async (values) => {
  const params = new FormData()
  if (selectedFile.value) {
    params.append('profile_photo_path', selectedFile.value)
  }

  try {
    const itiParseNumber = parseInt(values.iti.replace(/\D/g, ''), 10);
    params.append('name', values.name)
    params.append('iti', itiParseNumber)
    params.append('email', values.email)
    params.append('password', values.password)
    params.append('password_confirmation', values.confirmPassword)

    await authStore.register(params)
    notify({
      title: 'Cadastro realizado com sucesso!',
      type: 'success',
    })
    router.push({ name: 'auth.login' })
  } catch (e) {
    notify({
      title: 'Falha ao cadastrar',
      text: 'Erro na requisição',
      type: 'warn',
    })
  }
})

const { value: name } = useField('name')
const { value: iti } = useField('iti')
const { value: email } = useField('email')
const { value: password } = useField('password')
const { value: confirmPassword } = useField('confirmPassword')
</script>