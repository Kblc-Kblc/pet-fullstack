const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', component: () => import('pages/IndexPage.vue') },
      {
        path: '/login',
        component: () => import('src/components/MainLogin.vue'),
      },
      {
        path: '/register',
        component: () => import('src/components/MainRegister.vue'),
      },
      {
        path: '/dashboard',
        component: () => import('src/pages/MainDashboard.vue'),
        meta: { requiresAuth: true },
      },
    ],
  },
  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue'),
  },
]

export default routes
