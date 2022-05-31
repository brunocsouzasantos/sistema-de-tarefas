<template>
  <q-table title="Lista de tarefas" :loading="loadingDados" :data="tarefas"
    :columns="columns" separator="none" hide-header row-key="id">
    <template v-slot:top="props">
      <div class="q-table__title">
        <q-radio v-model="tipoFiltroTarefas" val="PE" label="Tarefas pendentes" @input="populaDatatable()"/>
        <q-radio v-model="tipoFiltroTarefas" val="CO" label="Tarefas concluídas" @input="populaDatatable()"/>
      </div>
      <q-space />
      <q-btn flat round dense :icon="props.inFullscreen ? 'fullscreen_exit' : 'fullscreen'"
        @click="props.toggleFullscreen" class="q-ml-md float-right" />
    </template>
    <template v-slot:body="props">
      <q-tr :props="props">
        <q-td key="tarefa" :props="props">
            <q-card>
              <q-item>
                <q-item-section avatar top>
                  <q-icon name="task" :color="props.row.status === 'PE' ? 'orange' : 'green'" size="34px" />
                </q-item-section>
                <q-item-section top class="col-2 gt-sm">
                  <q-item-label class="q-mt-sm">{{props.row.nome}}</q-item-label>
                </q-item-section>
                <q-item-section top>
                  <q-item-label lines="1">
                    <span class="text-weight-medium">Assunto: </span>
                    <span class="text-grey-8">{{props.row.titulo}}</span>
                  </q-item-label>
                  <q-item-label caption lines="1" v-html="props.row.descricao" />
                </q-item-section>
                <q-item-section top side>
                  <div class="text-grey-8 q-gutter-xm">
                    Data de criação: {{props.row.created_at | formataData}} <br />
                    Última alteração: {{props.row.updated_at | formataData}}
                  </div>
                </q-item-section>
                <q-item-section top side>
                  <div class="text-grey-8 q-gutter-xs">
                    <q-btn v-if="props.row.status === 'PE'" class="gt-xs" size="12px" flat dense round icon="edit"
                      @click="editarTarefa(props.row)" />
                    <q-btn v-if="props.row.status === 'PE'" class="gt-xs" size="12px" flat dense round icon="done" color="orange"
                      @click="validaConclusaoTarefa(props.row, 'Confirma a conclusão da tarefa?')" />
                    <q-btn v-if="props.row.status === 'CO'" class="gt-xs" size="12px" flat dense round icon="remove_done" color="red"
                      @click="validaConclusaoTarefa(props.row, 'Passar tarefa novamente para pendente?')" />
                    <q-btn v-if="props.row.status === 'PE'" class="gt-xs" size="12px" flat dense round icon="delete"
                      @click="validaExclusao(props.row)" />
                  </div>
                </q-item-section>
              </q-item>
            </q-card>
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
      tipoFiltroTarefas: 'PE',
      tarefas: [],
      columns: [{ name: 'tarefa', align: 'left', field: 'tarefa' }]
    }
  },
  props: ['rotaEditar'],
  methods: {
    ...mapActions('gerenciarTarefa', ['listarTarefas', 'deletarTarefa', 'atualizarStatusTarefa']),
    populaDatatable () {
      this.tarefas = []
      const getTarefas = async () => {
        try {
          const response = await this.listarTarefas(this.tipoFiltroTarefas)
          this.tarefas = await response
          this.loadingDados = false
        } catch ({ message }) {
          this.$util.mensagemErro(message)
        }
      }
      getTarefas()
    },
    editarTarefa (Tarefa) {
      this.$router.push({ name: 'taf_editar', params: { formTarefa: Tarefa } })
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
            const { message } = await this.deletarTarefa(row.id)
            this.$util.mensagemSucesso(message)
            const linha = this.tarefas.indexOf(row)
            this.tarefas.splice(linha, 1)
          } catch ({ message }) {
            this.$util.mensagemErro(message)
          }
        }
        destroy()
      })
    },
    validaConclusaoTarefa (row, texto) {
      this.$q.dialog({
        title: 'Confirmação',
        message: texto,
        cancel: true,
        persistent: true
      }).onOk(() => {
        const updateStatus = async () => {
          try {
            const { message, type } = await this.atualizarStatusTarefa(row)
            this.$util.mensagemSucesso(message)
            if (type !== this.tipoFiltroTarefas) {
              const linha = this.tarefas.indexOf(row)
              this.tarefas.splice(linha, 1)
            }
          } catch ({ message }) {
            this.$util.mensagemErro(message)
          }
        }
        updateStatus()
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
