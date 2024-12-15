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
        <Forgot ref="forgot" v-if="state == 'forgotPassword'" @token-emitted="setToken" />
        <Reset v-else-if="state == 'resetPassword'" :token="token" />
      </v-card>
    </div>
</template>
<script setup>
import { ref, defineProps } from 'vue';
import Forgot from './partials/Forgot.vue'
import Reset from './partials/Reset.vue'

const state = ref('forgotPassword');
const token = ref('');

const props = defineProps({
  state: {
    type: String,
    default: 'forgotPassword'
  }
})

const setToken = (newToken) => {
    token.value = newToken;
    state.value = 'resetPassword';
}
</script>


<!-- <template>
    <div class="flex flex-col items-center pb-6 px-6 sm:p-8">
      <a href="#" class="flex m-2 justify-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
        <img class="w-8 h-8 mr-2" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg" alt="logo">
        Flowbite
      </a>
  
      <component
        v-if="isForgotPassword"
        :is="forgotPasswordComponent"
        @token-emitted="setToken"
      />
      <component
        v-else-if="isResetPassword"
        :is="resetPasswordComponent"
        :token="token"
      />
  
      <p class="text-sm font-light text-gray-500 dark:text-gray-400">
        Tem conta?
        <router-link class="font-medium text-primary-600 hover:underline dark:text-primary-500" :to="{ name: 'login' }">
          Voltar para o Login
        </router-link>
      </p>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import Forgot from './partials/Forgot.vue';
  import Reset from './partials/Reset.vue';
  
  const state = ref('forgotPassword');
  const token = ref('');
  
  const isForgotPassword = computed(() => state.value === 'forgotPassword');
  const isResetPassword = computed(() => state.value === 'resetPassword');
  
  const forgotPasswordComponent = Forgot;
  const resetPasswordComponent = Reset;
  
  const setToken = (newToken) => {
    token.value = newToken;
    state.value = 'resetPassword';
  };
</script> -->