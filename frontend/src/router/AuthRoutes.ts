const AuthRoutes = {
    path: '/auth',
    component: () => import('@/ui/layouts/blank/BlankLayout.vue'),
    meta: {
        requiresAuth: false
    },
    children: [
        {
            name: 'Login',
            path: '/login',
            component: () => import('@/ui/views/auth/Login.vue')
        },
        {
            name: 'Register',
            path: '/register',
            component: () => import('@/ui/views/auth/Register.vue')
        },
    ]
};

export default AuthRoutes;
