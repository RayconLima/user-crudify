const MainRoutes = {
    path: '/main',
    meta: {
        requiresAuth: true
    },
    redirect: '/main',
    component: () => import('@/ui/layouts/full/FullLayout.vue'),
    children: [
        {
            name: 'Dashboard',
            path: '/',
            component: () => import('@/ui/views/dashboard/index.vue')
        },
        {
            name: 'Users',
            path: '/users',
            component: () => import('@/ui/views/pages/Users/Index.vue')
        },
    ]
};

export default MainRoutes;
