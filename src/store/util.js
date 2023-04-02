import axios from 'axios'
const apiUrl = process.env.API
const actions = {
  callApi ({ rootState }, { endPoint, method = 'get', data = null }) {
    this.$util.showLoading()
    return new Promise((resolve, reject) => {
      const token = rootState.gerenciarUsuario.token
      const url = `${apiUrl}/${endPoint}`
      axios({ method, url, data, headers: { Authorization: 'Bearer ' + token } })
        .then(({ data }) => {
          resolve(data)
        })
        .catch(({ response: { data } }) => {
          reject(data)
        })
        .finally(() => {
          this.$util.hideLoading()
        })
    })
  }
}
export default {
  namespaced: true,
  actions
}
