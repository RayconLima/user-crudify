import { useMeStore } from '@/stores/me';

export const redirectIfNotAuthenticated = (to, from, next) => {
  const meStore = useMeStore();

  if (!meStore.isLoggedIn) {
    next({ name: 'auth.login' })
  } else {
    next();
  }
}

export const redirectIfAuthenticated = (to, from, next) => {
  const meStore = useMeStore()

  if (meStore.isLoggedIn) {
    next({ name: 'dashboard' })
  } else {
    next()
  }
}

export const checkIfTokenExists = (to, from, next) => {
  if (!to.query?.token) {
    next({name: 'auth.login'})
  } else {
    next();
  }
}