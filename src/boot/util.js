import { Notify, Loading } from 'quasar'

export default function ({ Vue, app, store, router }) {
  const util = {
    mensagemErro (msg) {
      Notify.create({
        message: msg,
        color: 'negative',
        textColor: 'white',
        position: 'top',
        icon: 'report_problem',
        timeout: 10000,
        html: true
      })
    },
    mensagemSucesso (msg) {
      Notify.create({
        message: msg,
        color: 'green-4',
        textColor: 'white',
        position: 'top',
        icon: 'cloud_done',
        timeout: 10000,
        html: true
      })
    },
    mensagemWarning (msg) {
      Notify.create({
        message: msg,
        color: 'warning',
        textColor: 'white',
        position: 'top',
        icon: 'cloud_done',
        timeout: 10000,
        html: true
      })
    },
    showLoading: function () {
      return Loading.show()
    },
    hideLoading: function () {
      return Loading.hide()
    }
  }

  Vue.mixin({
    beforeCreate () {
      const options = this.$options
      if (options.util) {
        this.$util = options.util
      } else if (options.parent) {
        this.$util = options.parent.$util
      }
    }
  })
  app.util = util
  store.$util = util
}
