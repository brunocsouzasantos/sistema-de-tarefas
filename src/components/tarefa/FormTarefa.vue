<template>
  <q-form @submit="onSubmit">
    <div class="q-pa-md">
      <div class="row">
        <div class="col-12 col-md-6 q-mt-md q-px-xs">
          <q-input class="q-px-xs" outlined v-model="form.nome" label="Nome da tarefa"
          lazy-rules :rules="[val => val && val.length > 0 || 'Informação obrigatória']"/>
        </div>
        <div class="col-12 col-md-6 q-mt-md q-px-xs">
          <q-input class="q-px-xs" outlined v-model="form.titulo" label="Título"
          lazy-rules :rules="[val => val && val.length > 0 || 'Informação obrigatória']"/>
        </div>
        <div class="col-12 col-md-12 q-mt-md q-px-xs">
          <q-editor v-model="descricao" min-height="5rem" />
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
      form: this.formTarefa,
      descricao: ''
    }
  },
  props: ['formTarefa', 'tipoEditar'],
  methods: {
    ...mapActions('gerenciarTarefa', ['cadastrarTarefa', 'atualizarTarefa']),
    onSubmit () {
      this.form.descricao = this.descricao
      if (this.form.id !== null && this.form.id !== undefined) {
        const update = async () => {
          try {
            const { message } = await this.atualizarTarefa(this.form)
            this.$util.mensagemSucesso(message)
            this.$router.push({ name: 'taf_index' })
          } catch ({ message }) {
            this.$util.mensagemErro(message)
          }
        }
        update()
        return
      }
      const store = async () => {
        try {
          const { message } = await this.cadastrarTarefa(this.form)
          this.$util.mensagemSucesso(message)
          this.$router.push({ name: 'taf_index' })
        } catch ({ message }) {
          this.$util.mensagemErro(message)
        }
      }
      store()
    }
  },
  created () {
    if (this.formTarefa.id) {
      this.descricao = this.formTarefa.descricao
    }
  }
}
</script>
