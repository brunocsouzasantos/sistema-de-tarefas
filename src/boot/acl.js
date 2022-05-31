import { Notify } from 'quasar'

export default ({ router, store, Vue, app }) => {
  const storeVuex = store
  const acl = {
    redireciona () {
      if (storeVuex.getters['gerenciarUsuario/usuario'].permissao === 'ADM') {
        return router.push({ name: 'gus_index' })
      }
      if (storeVuex.getters['gerenciarUsuario/usuario'].permissao === 'USR') {
        return router.push({ name: 'taf_index' })
      }
    }
  }
  router.beforeEach((to, from, next) => {
    const requiresAuth = to.matched[0].meta.requiresAuth || false
    const usuarioAuth = storeVuex.getters['gerenciarUsuario/usuario']
    const racl = to.matched[0].meta.racl || false
    if (requiresAuth && (usuarioAuth === null)) {
      return next({ path: '/login' })
    }
    if (racl && usuarioAuth.permissao !== racl) {
      Notify.create({
        message: 'Acesso não autorizado pelo frontend do sistema',
        color: 'negative',
        textColor: 'white',
        position: 'top',
        icon: 'report_problem',
        duration: '10000',
        html: true
      })
      acl.redireciona()
    }
    return next()
  })
  Vue.mixin({
    beforeCreate () {
      const options = this.$options
      if (options.acl) {
        this.$acl = options.acl
      } else if (options.parent) {
        this.$acl = options.parent.$acl
      }
    }
  })
  app.acl = acl
  store.$acl = acl
}
