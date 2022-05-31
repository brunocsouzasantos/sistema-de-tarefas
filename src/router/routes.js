
const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      // { path: '', component: () => import('pages/Index.vue'), name: 'index' },
      { path: '', component: () => import('pages/Login.vue'), name: 'login' }
    ]
  },
  {
    path: '/administrativo',
    meta: { requiresAuth: true, racl: 'ADM' },
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: 'gerenciar_usuarios/index', component: () => import('pages/administrativo/gerenciar_usuarios/gus_index.vue'), name: 'gus_index' },
      { path: 'gerenciar_usuarios/cadastrar', component: () => import('pages/administrativo/gerenciar_usuarios/gus_cadastrar.vue'), name: 'gus_cadastrar' },
      { path: 'gerenciar_usuarios/editar', component: () => import('pages/administrativo/gerenciar_usuarios/gus_editar.vue'), name: 'gus_editar', props: (route) => ({ formUsuario: null, ...route.params }) }
    ]
  },
  {
    path: '/tarefa',
    meta: { requiresAuth: true },
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: 'tarefas/index', component: () => import('pages/tarefas/taf_index.vue'), name: 'taf_index' },
      { path: 'tarefas/cadastrar', component: () => import('pages/tarefas/taf_cadastrar.vue'), name: 'taf_cadastrar' },
      { path: 'tarefas/editar', component: () => import('pages/tarefas/taf_editar.vue'), name: 'taf_editar', props: (route) => ({ formTarefa: null, ...route.params }) }
    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '*',
    component: () => import('pages/ErrorPage.vue')
  }
]

export default routes
