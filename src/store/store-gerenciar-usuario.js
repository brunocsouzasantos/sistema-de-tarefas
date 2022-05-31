import axios from 'axios'

const state = {
  usuario: null,
  token: null
}

const mutations = {
  SET_USUARIO (state, usuario) {
    state.usuario = usuario
  },
  SET_TOKEN (state, token) {
    state.token = token
  }
}

const actions = {
  login (context, form) {
    const acl = this.$acl
    return new Promise((resolve, reject) => {
      axios({
        method: 'post',
        data: form,
        url: `${process.env.API}/login`
      })
        .then((response) => {
          resolve(response.data)
          context.commit('SET_USUARIO', response.data)
          context.commit('SET_TOKEN', response.data.token)
          acl.redireciona()
        })
        .catch((error) => {
          reject(error.response.data)
        })
    })
  },
  listarUsuarios (context) {
    return new Promise((resolve, reject) => {
      const token = context.rootState.gerenciarUsuario.token
      axios.get(`${process.env.API}/listar_usuarios`, { headers: { Authorization: 'Bearer ' + token } })
        .then((response) => {
          resolve(response.data)
        })
        .catch((error) => {
          reject(error.response.data)
        })
    })
  },
  cadastrarUsuario (context, formUsuario) {
    this.$util.showLoading()
    return new Promise((resolve, reject) => {
      const token = context.rootState.gerenciarUsuario.token
      axios({
        method: 'post',
        data: formUsuario,
        url: `${process.env.API}/cadastrar_usuario`,
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
  atualizarUsuario (context, formUsuario) {
    this.$util.showLoading()
    return new Promise((resolve, reject) => {
      const token = context.rootState.gerenciarUsuario.token
      axios({
        method: 'put',
        data: formUsuario,
        url: `${process.env.API}/atualizar_usuario`,
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
  deletarUsuario (context, id) {
    this.$util.showLoading()
    return new Promise((resolve, reject) => {
      const token = context.rootState.gerenciarUsuario.token
      axios.delete(`${process.env.API}/deletar_usuario/${id}`, { headers: { Authorization: 'Bearer ' + token } })
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
  logout (context) {
    context.commit('SET_TOKEN', null)
    context.commit('SET_USUARIO', null)
    this.$router.push({ name: 'login' })
  }
}

const getters = {
  usuario: state => {
    return state.usuario
  }
}
export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
