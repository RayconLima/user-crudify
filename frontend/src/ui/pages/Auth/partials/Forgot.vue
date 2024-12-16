<template>
  <v-card-title class="text-h5 font-weight-bold text-center">
    Esqueceu sua senha?
  </v-card-title>
  <v-card-text>
    <v-form @submit.stop.prevent="submit">
      <v-text-field
        v-model="email"
        density="compact"
        placeholder="Endereço de e-mail"
        prepend-inner-icon="mdi-email-outline"
        variant="outlined"
        :error-messages="errors.email"
      />
      <v-row>
        <v-col cols="12" sm="6">
          <v-btn
            class="mb-8"
            color="orange"
            size="large"
            variant="tonal"
            block
          >
            <router-link :to="{ name: 'auth.login' }" class="text-orange text-decoration-none">
              Voltar
            </router-link>
          </v-btn>
        </v-col>
        <v-col cols="12" sm="6">
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
              <span class="ml-2">Enviando...</span>
            </div>
            <span v-else>Enviar</span>
          </v-btn>
        </v-col>
      </v-row>
    </v-form>
  </v-card-text>
</template>
<script setup>
import { notify } from '@kyvg/vue3-notification'
import { useField, useForm } from 'vee-validate'
import { object, string } from 'yup'
import Spinner from '@/ui/components/Spinner.vue'
import { defineEmits } from 'vue'
import AuthService from '@/infra/services/auth.service'

const emit = defineEmits(['token-emitted'])

const schema = object({
  email: string().required().email().label('E-mail'),
})

const { handleSubmit, errors, isSubmitting } = useForm({
  validationSchema: schema,
  initialValues: {
    email: '',
  },
})

const submit = handleSubmit(async (values) => {
  try {
    await AuthService.forgotPassword(values.email)
      .then((resp) => {
        notify({
          title: "Deu certo!",
          type: "success",
        });

        const tokenResponse = resp.data.data.resetPasswordToken.token;
        emit('token-emitted', tokenResponse);
        token.value = tokenResponse
      })
  } catch (e) {
    notify({
      title: "Falha ao autenticar",
      text: 'Falha na requisição',
      type: "warn",
    });
  }
});

const { value: email } = useField('email')
</script>
