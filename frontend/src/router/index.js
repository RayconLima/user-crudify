import { redirectIfAuthenticated, redirectIfNotAuthenticated } from './guards';
import { createRouter, createWebHistory } from 'vue-router'
import BlankLayout from '@/ui/layouts/BlankLayout'
import FullLayout from '@/ui/layouts/FullLayout'
import Register from '@/ui/pages/Auth/Register'
import Home from '@/ui/pages/Dashboard/Index'
import Users from '@/ui/pages/Users/Index'
import Login from '@/ui/pages/Auth/Login'
import { useMeStore } from '@/stores/me';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      component: BlankLayout,
      beforeEnter: redirectIfAuthenticated,
      children: [
        {
          path: 'login',
          name: 'auth.login',
          component: Login
        },
        {
          path: 'register',
          name: 'auth.register',
          component: Register
        }
      ]
    },
    {
      path: '/admin',
      component: FullLayout,
      beforeEnter: redirectIfNotAuthenticated,
      children: [
        {
          path: 'dashboard',
          name: 'dashboard',
          component: Home
        },
        {
          path: 'usuarios',
          name: 'users',
          component: Users
        }
      ]
    },
    
  ]
})

router.beforeEach(async (to, from, next) => {
  document.title  = to.meta.title;
  const meStore   = useMeStore();

  const token = localStorage.getItem(import.meta.env.VITE_APP_TOKEN_NAME);
  if(token) {
      await meStore.getMe(); // Aguarde a conclusão da ação getMe
  }

  next();
})

export default router