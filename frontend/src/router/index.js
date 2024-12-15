import { redirectIfAuthenticated, redirectIfNotAuthenticated, checkIfTokenExists } from './guards'
import ForgotPassword from '@/ui/pages/Auth/ForgotPassword'
import { createRouter, createWebHistory } from 'vue-router'
import VerifyEmail from '@/ui/pages/Auth/VerifyEmail'
import BlankLayout from '@/ui/layouts/BlankLayout'
import FullLayout from '@/ui/layouts/FullLayout'
import Register from '@/ui/pages/Auth/Register'
import Profile from '@/ui/pages/Profile/Index'
import Home from '@/ui/pages/Dashboard/Index'
import Users from '@/ui/pages/Users/Index'
import Login from '@/ui/pages/Auth/Login'
import { useMeStore } from '@/stores/me'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      component: BlankLayout,
      beforeEnter: redirectIfAuthenticated,
      children: [
        {
          path: '',
          name: 'auth.login',
          component: Login,
          meta: {
            title: 'Login',
            public: true,
          },
        },
      ],
    },
    {
      path: '/register',
      component: BlankLayout,
      beforeEnter: redirectIfAuthenticated,
      children: [
        {
          path: '',
          name: 'auth.register',
          component: Register,
          meta: {
            title: 'Registro',
            public: true,
          },
        },
      ],
    },
    {
      path: '/verificar-email',
      component: BlankLayout,
      beforeEnter: checkIfTokenExists,
      children: [
        {
          path: '',
          name: 'verifyEmail',
          component: VerifyEmail
        }
      ],
    },
    {
      path: '/esqueci-minha-senha',
      component: BlankLayout,
      beforeEnter: redirectIfAuthenticated,
      meta: {
        title: 'Esqueci minha senha',
        public: true
      },
      children: [
        {
          path: '',
          name: 'forgotPassword',
          component: ForgotPassword
        }
      ],
    },
    {
      path: '/admin',
      component: FullLayout,
      beforeEnter: redirectIfNotAuthenticated,
      children: [
        {
          path: 'dashboard',
          name: 'dashboard',
          component: Home,
          meta: {
            title: 'Dashboard',
            public: false,
          },
        },
        {
          path: 'usuarios',
          name: 'users',
          component: Users,
          meta: {
            title: 'Usuários',
            public: false,
          },
        },
        {
          path: 'meu-perfil',
          name: 'profile',
          component: Profile,
          meta: {
            title: 'Meu perfil',
            public: false,
          },
        },
      ],
    },
  ],
})

router.beforeEach(async (to, from, next) => {
  document.title = to.meta.title
  const meStore = useMeStore()

  const token = localStorage.getItem(import.meta.env.VITE_APP_TOKEN_NAME)
  if (token) {
    await meStore.getMe()
  }

  next()
})

export default router
