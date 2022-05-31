<template>
 <div class="q-pa-md q-gutter-sm">
  <Bread modulo="Acesso" passo1="Login"/>
  <q-page padding>
    <q-tab-panel name="login" class="shadow-2 rounded-borders" style="width: 22em; height: 250px; margin: auto">
          <q-form @submit="onSubmit" class="q-gutter-md">
            <q-input outlined v-model="form.email"
              label="E-mail"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Insira e-mail válido']"
            >
              <template v-slot:prepend>
                <q-icon name="mail" />
              </template>
            </q-input>
            <q-input
              v-model="form.password"
              outlined :type="isPwd ? 'password' : 'text'"
              label="Digite sua senha"
              lazy-rules
              :rules="[ val => val && val.length >= 6 || 'Insira uma senha de no mínimo 6 dígitos']">
            <template v-slot:prepend>
              <q-icon
                :name="isPwd ? 'visibility_off' : 'visibility'"
                class="cursor-pointer"
                @click="isPwd = !isPwd"
              />
              </template>
            </q-input>
            <div class="float-right">
              <q-btn label="Entrar" type="submit" color="primary" :loading="loadingSubmitting">
                <template v-slot:loading>
                  <q-spinner-facebook />
                </template>
              </q-btn>
            </div>
          </q-form>
    </q-tab-panel>
  </q-page>
</div>
</template>

<script>
import Bread from 'components/reuso/Bread'
import { mapActions } from 'vuex'
export default {
  components: {
    Bread
  },
  data () {
    return {
      form: {},
      isPwd: true,
      loadingSubmitting: false
    }
  },
  methods: {
    ...mapActions('gerenciarUsuario', ['login']),
    onSubmit () {
      this.loadingSubmitting = true
      const auth = async () => {
        try {
          const { message } = await this.login(this.form)
          this.$util.mensagemSucesso(message)
        } catch ({ message }) {
          this.loadingSubmitting = false
          this.$util.mensagemErro(message)
        }
      }
      auth()
    }
  }
}
</script>
