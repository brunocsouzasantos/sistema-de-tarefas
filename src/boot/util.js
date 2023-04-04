import { Notify, Loading } from 'quasar'

export default function ({ Vue, app, store, router }) {
  const util = {
    mensagemErro (msg) {
      if (Array.isArray(msg)) {
        msg = msg.join('\n')
      }
      Notify.create({
        message: msg.replace(/\n/g, '<br>'),
        multiLine: true,
        color: 'negative',
        textColor: 'white',
        position: 'top',
        icon: 'report_problem',
        timeout: 10000,
        html: true
      })
    },
    mensagemSucesso (msg) {
      if (Array.isArray(msg)) {
        msg = msg.join('\n')
      }
      Notify.create({
        message: msg.replace(/\n/g, '<br>'),
        color: 'green-4',
        textColor: 'white',
        position: 'top',
        icon: 'cloud_done',
        timeout: 10000,
        html: true
      })
    },
    mensagemWarning (msg) {
      if (Array.isArray(msg)) {
        msg = msg.join('\n')
      }
      Notify.create({
        message: msg.replace(/\n/g, '<br>'),
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
