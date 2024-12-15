<template>
  <v-card-title class="text-h5 font-weight-bold text-center">
    Esqueceu sua senha?
  </v-card-title>
  <v-card-text>
    <v-form @submit.stop.prevent="submit">
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
        type="submit"
      >
        <div v-if="isSubmitting" class="flex items-center justify-center">
          <Spinner :loading="isSubmitting" />
          <span class="ml-2">Enviando...</span>
        </div>
        <span v-else>Enviar</span>
      </v-btn>
    </v-form>
  </v-card-text>
</template>

<script setup>
import { ref } from 'vue'
import { notify } from '@kyvg/vue3-notification'
import { useField, useForm } from 'vee-validate'
import { object, string, ref as yupRef } from 'yup'
import Spinner from '@/ui/components/Spinner.vue'
import { defineEmits, defineProps } from 'vue'
import AuthService from '@/infra/services/auth.service'
import { useRouter } from 'vue-router'

const visible = ref(false)
const emit = defineEmits(['token-emitted'])
const router = useRouter()

const props = defineProps({
  token: {
    type: String,
    default: ''
  }
})

const schema = object({
  password: string().required().min(6).label('Senha'),
  confirmPassword: string()
    .required()
    .oneOf([yupRef('password')], 'As senhas devem corresponder')
    .label('Confirmar Senha'),
})

const { handleSubmit, errors, isSubmitting } = useForm({
  validationSchema: schema,
  initialValues: {
    token: props.token || '',
    password: '',
    confirmPassword: '',
  },
})

const { value: password } = useField('password')
const { value: confirmPassword } = useField('confirmPassword')

const submit = handleSubmit(async (values) => {
  isSubmitting.value = true;
  try {
    const params = {
      token: values.token,
      password: values.password,
      password_confirmation: values.confirmPassword
    }
    
    const resp = await AuthService.resetPassword(params);
    console.log("Resposta da API:", resp);
    notify({
      title: "Deu certo!",
      type: "success",
    });

    const tokenResponse = resp.data.data.resetPasswordToken.token;
    emit('token-emitted', tokenResponse);
    
  
    console.log("Redirecionando para a tela de login");
    router.push({ name: "auth.login" });
  } catch (e) {
    notify({
      title: "Falha ao autenticar",
      text: 'Falha na requisição',
      type: "warn",
    });
  } finally {
    isSubmitting.value = false;
  }
});
</script>