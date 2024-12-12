import axios from 'axios'
import { defineStore } from 'pinia';
import { TOKEN_NAME } from '@/config'
import { useMeStore } from '@/store/me';
import AuthService from '@/infra/services/auth.service'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
  }),

  actions: {
    async login(email, password) {
      return await AuthService.login({email, password}).then((response) => {
        localStorage.setItem(TOKEN_NAME, response.data.token)
        const meStore = useMeStore();
        meStore.user  = response.data.data
        this.user     = response.data.data;
      })
    },
    async register({ plan_id, name, email, password }) {
      return await AuthService.register({
        plan_id,
        name,
        email,
        password
      }).then((response) => {
        const meStore = useMeStore();
        meStore.user  = response.data.data;
        this.user     = response.data.data;
        return response;
      });
    },
    logout() {
      return AuthService.logout().then((response) => {
        localStorage.removeItem(import.meta.env.VITE_APP_TOKEN_NAME)
        this.user = null;
        return response;
      })
    },
  }
});