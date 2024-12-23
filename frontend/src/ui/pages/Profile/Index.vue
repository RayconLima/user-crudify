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
          <v-row>
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
            <v-col cols="6" class="d-flex flex-column justify-center">
              <p style="font-size:24px;" class="mb-2"><strong>Nome:</strong> {{ profile?.name }}</p>
              <p style="font-size:24px;" class="mb-2"><strong>Email:</strong> {{ profile?.email }}</p>
              <p style="font-size:24px;" class="mb-2"><strong>CPF:</strong> {{ formatITI(profile?.iti) }}</p>
              <p style="font-size:24px;" class="mb-2"><strong>Status:</strong> {{ getStatus(profile?.status) }}</p>
            </v-col>
          </v-row>
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
                @click:append-inner="togglePasswordVisibility"
                :append-inner-icon="passwordVisible ? 'mdi-eye-off' : 'mdi-eye'"
                variant="outlined"
                :type="passwordVisible ? 'text' : 'password'"
                hide-details
                color="primary"
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
                :append-inner-icon="passwordConfirmationVisible ? 'mdi-eye-off' : 'mdi-eye'"
                @click:append-inner="togglePasswordConfirmationVisibility"
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
  import { useNotification } from "@kyvg/vue3-notification";
  import { ref, computed } from 'vue'
  import { useField, useForm } from 'vee-validate'
  import { object, string, ref as yupRef } from 'yup'
  import { useRouter } from 'vue-router'
  import { useMeStore } from '@/stores/me'
  import { getStatus } from '@/utils/status'
  import { formatITI } from '@/utils/masks'
  import Spinner from '@/ui/components/Spinner.vue'
  
  const meStore = useMeStore()
  const notification = useNotification()
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
          .then(() => {
              notification.notify({
                  title: 'Sucesso!',
                  type: 'success',
              })
              router.push({ name: 'profile' })
          })
          .catch((error) => {
              notification.notify({
                  title: ' Erro',
                  text: 'Falha na requisição',
                  type: 'warn',
              })
          })
    } catch (e) {
        notification.notify({
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
  
  const profileImage = ref(profile.value.profile_photo_path)
  
  const triggerFileInput = () => {
    const fileInput = document.querySelector('input[type="file"]')
    fileInput.click()
  }
  
  const onFileChange = async (event) => {
    const file = event.target.files[0]
    if (file) {
      const params = new FormData()
      params.append('profile_photo_path', file)
  
      // Aqui você pode adicionar a lógica para fazer o upload da imagem para o servidor
      try {
        await meStore.updateProfilePhoto(params)
        const reader = new FileReader()
        reader.onload = (e) => {
          profileImage.value = e.target.result
        }
        reader.readAsDataURL(file)
      } catch (error) {
        notification.notify({
          title: 'Erro',
          text: 'Falha ao atualizar a foto de perfil',
          type: 'warn',
        })
      }
    }
  }
  </script>