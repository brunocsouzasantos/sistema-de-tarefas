<template>
  <q-table title="Lista de Usuários" :loading="loadingDados" :data="usuarios" :columns="columns"
    row-key="id">
    <template v-slot:top="props">
      <div class="q-table__title">Usuários</div>
      <q-space />
      <q-btn flat round dense :icon="props.inFullscreen ? 'fullscreen_exit' : 'fullscreen'"
        @click="props.toggleFullscreen" class="q-ml-md float-right" />
    </template>
    <template v-slot:body="props">
      <q-tr :props="props">
        <q-td key="name" :props="props">{{ props.row.name }}</q-td>
        <q-td key="email" :props="props">{{ props.row.email }}</q-td>
        <q-td key="created_at" :props="props">{{ props.row.created_at | formataData }}</q-td>
        <q-td key="updated_at" :props="props">{{ props.row.updated_at | formataData}}</q-td>
        <q-td key="acoes">
          <q-btn round color="secondary" icon="edit" size="10px" class="q-mr-sm"
            @click="editarUsuario(props.row)" />
          <q-btn :disable="props.row.permissao === 'ADM'" round color="red" icon="delete" size="10px"
          @click="validaExclusao(props.row)" />
        </q-td>
      </q-tr>
    </template>
  </q-table>
</template>

<script>
import { mapActions } from 'vuex'
import moment from 'moment'
export default {
  data () {
    return {
      loadingDados: true,
      columns: [
        { name: 'name', required: true, align: 'left', label: 'Nome', field: 'name', sortable: true },
        { name: 'email', required: true, align: 'left', label: 'E-mail', field: 'email' },
        { name: 'created_at', required: true, align: 'left', label: 'Data de Criação', field: 'created_at' },
        { name: 'updated_at', required: true, align: 'left', label: 'Última alteração', field: 'updated_at' },
        { name: 'acoes', required: true, align: 'left', label: 'Ações', field: 'acoes' }
      ],
      usuarios: []
    }
  },
  props: ['rotaEditar'],
  methods: {
    ...mapActions('gerenciarUsuario', ['listarUsuarios', 'deletarUsuario']),
    populaDatatable () {
      const getUsuarios = async () => {
        try {
          const response = await this.listarUsuarios()
          this.usuarios = await response
          this.loadingDados = false
        } catch ({ response: { data } }) {
          this.$util.mensagemErro(data.message)
        }
      }
      getUsuarios()
    },
    editarUsuario (usuario) {
      this.$router.push({ name: 'gus_editar', params: { formUsuario: usuario } })
    },
    validaExclusao (row) {
      this.$q.dialog({
        title: 'Confirmação',
        message: 'Deseja deletar o registro?',
        cancel: true,
        persistent: true
      }).onOk(() => {
        const destroy = async () => {
          try {
            const { message } = await this.deletarUsuario(row.id)
            this.$util.mensagemSucesso(message)
            const linha = this.usuarios.indexOf(row)
            this.usuarios.splice(linha, 1)
          } catch ({ message }) {
            this.$util.mensagemErro(message)
          }
        }
        destroy()
      })
    }
  },
  filters: {
    formataData (data) {
      return moment(data).utc().format('DD/MM/YYYY HH:mm')
    }
  },
  mounted () {
    this.populaDatatable()
  }
}
</script>
