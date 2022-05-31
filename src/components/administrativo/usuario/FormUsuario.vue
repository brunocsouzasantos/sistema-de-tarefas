<template>
  <q-form @submit="onSubmit">
    <div class="q-pa-md">
      <div class="row">
        <div class="col-12 col-md-6 q-mt-md q-px-xs">
          <q-input class="q-px-xs" outlined v-model="form.name" label="Nome"
          lazy-rules :rules="[val => val && val.length > 0 || 'Informação obrigatória']"/>
        </div>
        <div class="col-12 col-md-6 q-mt-md q-px-xs">
          <q-input type="email" class="q-px-xs" outlined v-model="form.email" label="E-mail"
           lazy-rules :rules="[val => val && val.length > 0 || 'Informação obrigatória']"/>
        </div>
        <div class="col-12 col-md-6 q-mt-md q-px-xs" v-if="!tipoEditar">
          <q-input v-model="form.password" outlined :type="isPwd ? 'password' : 'text'"
            label="Informe sua senha" lazy-rules :rules="[validaCaracteristicasSenha]">
            <template v-slot:prepend>
              <q-icon :name="isPwd ? 'visibility_off' : 'visibility'" class="cursor-pointer" @click="isPwd = !isPwd" />
            </template>
          </q-input>
        </div>
        <div class="col-12 col-md-6 q-mt-md q-px-xs" v-if="!tipoEditar">
          <q-input v-model="form.password_confirm" outlined :type="isPwd2 ? 'password' : 'text'"
            label="Confirme a senha" lazy-rules :rules="[val => val && val.length > 0 || 'Informação obrigatória']">
            <template v-slot:prepend>
              <q-icon :name="isPwd2 ? 'visibility_off' : 'visibility'" class="cursor-pointer"
                @click="isPwd2 = !isPwd2" />
            </template>
          </q-input>
        </div>
        <div class="col-12 col-md-12 q-mt-md q-px-xs">
          <div class="float-right">
            <slot name="slBtCadastrarEditar" />
          </div>
        </div>
      </div>
    </div>
  </q-form>
</template>

<script>
import { mapActions } from 'vuex'
export default {
  data () {
    return {
      isPwd: true,
      isPwd2: true,
      form: this.formUsuario
    }
  },
  props: ['formUsuario', 'tipoEditar'],
  methods: {
    ...mapActions('gerenciarUsuario', ['cadastrarUsuario', 'atualizarUsuario']),
    onSubmit () {
      if (this.form.id !== null && this.form.id !== undefined) {
        const update = async () => {
          try {
            const { message } = await this.atualizarUsuario(this.form)
            this.$util.mensagemSucesso(message)
            this.$router.push({ name: 'gus_index' })
          } catch ({ message }) {
            this.$util.mensagemErro(message)
          }
        }
        update()
        return
      }
      if (this.validaSenhaIguais()) {
        this.$util.mensagemWarning('As senhas precisam ser iguais')
        return
      }
      const store = async () => {
        try {
          const { message } = await this.cadastrarUsuario(this.form)
          this.$util.mensagemSucesso(message)
          this.$router.push({ name: 'gus_index' })
        } catch ({ message }) {
          this.$util.mensagemErro(message)
        }
      }
      store()
    },
    validaCaracteristicasSenha (senha) {
      if (senha === null) {
        return 'Informe uma senha'
      }
      if (senha.length < 8) {
        return 'Sua senha deve possuir no mínimo 8 caracteres'
      }
      if (senha.search(/[a-z]/i) < 0) {
        return 'Sua senha deve possuir no mínimo uma letra'
      }
      if (senha.search(/[0-9]/) < 0) {
        return 'Sua senha deve possuir no mínimo um número'
      }
    },
    validaSenhaIguais () {
      if (this.form.password !== this.form.password_confirm) {
        return true
      }
    }
  }
}
</script>
