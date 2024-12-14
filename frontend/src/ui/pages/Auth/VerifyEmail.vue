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
            <v-card-title> Verificar email </v-card-title>
            <v-card-text>
                <h3 v-if="isLoading"
                    class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Verificando....
                </h3>

                <div v-else-if="!isReady" class="dark:text-red-500 text-center">
                    Ops! Parece que esse token está inválido!
                </div>

                <h3 v-else class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Email Verificado! <br />
                    Obrigado, {{ state.data.name }} por verificar seu email!
                </h3>
            </v-card-text>
        </v-card>
    </div>
</template>
<script setup>
import { useRoute } from 'vue-router';
import AuthService from '@/infra/services/auth.service';
import { useAsyncState } from '@vueuse/core';
const route = useRoute()
const token = route.query.token

const { state, isReady, isLoading } = useAsyncState(
    AuthService.verifyEmailfromToken(token)
)
</script>