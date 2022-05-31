import axios from 'axios'

const actions = {
  listarTarefas (context, tipoFiltroTarefas) {
    return new Promise((resolve, reject) => {
      const token = context.rootState.gerenciarUsuario.token
      axios.get(`${process.env.API}/listar_tarefas/${tipoFiltroTarefas}`, { headers: { Authorization: 'Bearer ' + token } })
        .then((response) => {
          resolve(response.data)
        })
        .catch((error) => {
          reject(error.response.data)
        })
    })
  },
  cadastrarTarefa (context, formTarefa) {
    this.$util.showLoading()
    return new Promise((resolve, reject) => {
      const token = context.rootState.gerenciarUsuario.token
      axios({
        method: 'post',
        data: formTarefa,
        url: `${process.env.API}/cadastrar_tarefa`,
        headers: { Authorization: `Bearer ${token}` }
      })
        .then((response) => {
          resolve(response.data)
        })
        .catch((error) => {
          reject(error.response.data)
        })
        .finally(() => {
          this.$util.hideLoading()
        })
    })
  },
  atualizarTarefa (context, formTarefa) {
    this.$util.showLoading()
    return new Promise((resolve, reject) => {
      const token = context.rootState.gerenciarUsuario.token
      axios({
        method: 'put',
        data: formTarefa,
        url: `${process.env.API}/atualizar_tarefa`,
        headers: { Authorization: `Bearer ${token}` }
      })
        .then((response) => {
          resolve(response.data)
        })
        .catch((error) => {
          reject(error.response.data)
        })
        .finally(() => {
          this.$util.hideLoading()
        })
    })
  },
  deletarTarefa (context, id) {
    this.$util.showLoading()
    return new Promise((resolve, reject) => {
      const token = context.rootState.gerenciarUsuario.token
      axios.delete(`${process.env.API}/deletar_tarefa/${id}`, { headers: { Authorization: 'Bearer ' + token } })
        .then((response) => {
          resolve(response.data)
        })
        .catch((error) => {
          reject(error.response.data)
        })
        .finally(() => {
          this.$util.hideLoading()
        })
    })
  },
  atualizarStatusTarefa (context, form) {
    this.$util.showLoading()
    return new Promise((resolve, reject) => {
      const token = context.rootState.gerenciarUsuario.token
      axios({
        method: 'put',
        data: form,
        url: `${process.env.API}/atualizar_status_tarefa`,
        headers: { Authorization: `Bearer ${token}` }
      })
        .then((response) => {
          resolve(response.data)
        })
        .catch((error) => {
          reject(error.response.data)
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
