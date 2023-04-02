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
  login ({ commit }, form) {
    const acl = this.$acl
    return new Promise((resolve, reject) => {
      axios({
        method: 'post',
        data: form,
        url: `${process.env.API}/login`
      })
        .then(({ data }) => {
          resolve(data)
          commit('SET_USUARIO', data)
          commit('SET_TOKEN', data.token)
          acl.redireciona()
        })
        .catch(({ response: { data } }) => {
          reject(data)
        })
    })
  },
  logout ({ commit }) {
    commit('SET_TOKEN', null)
    commit('SET_USUARIO', null)
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
