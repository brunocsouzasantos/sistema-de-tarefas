<template>
  <q-table title="Lista de tarefas" :loading="loadingDados" :data="tarefas"
    :columns="columns" separator="none" hide-header row-key="id">
    <template v-slot:top="props">
      <div class="q-table__title">
        <q-radio v-model="tipoFiltroTarefas" val="PE" label="Tarefas pendentes" @input="popularDatatable()"/>
        <q-radio v-model="tipoFiltroTarefas" val="CO" label="Tarefas concluídas" @input="popularDatatable()"/>
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
                  <q-item-label class="q-mt-sm" lines="1">
                    <span class="text-weight-medium">Assunto: </span>
                    <span class="text-grey-8">{{props.row.titulo}}</span>
                  </q-item-label>
                  <q-item-label caption lines="1" v-if="false">
                    <span v-html="props.row.descricao" />
                  </q-item-label>
                </q-item-section>
                <q-item-section top side>
                  <div class="text-grey-8 q-gutter-xm">
                    Data de criação: {{props.row.created_at | formatarData}} <br />
                    Última alteração: {{props.row.updated_at | formatarData}}
                  </div>
                </q-item-section>
                <q-item-section side>
                  <div class="text-grey-8 q-gutter-xs">
                    <q-btn v-if="props.row.status === 'PE'" class="gt-xs" size="12px" flat dense round icon="edit"
                      @click="editarTarefa(props.row)">
                      <q-tooltip>Editar tarefa</q-tooltip>
                    </q-btn>
                    <q-btn v-if="props.row.status === 'PE'" class="gt-xs" size="12px" flat dense round icon="done"
                      @click="validarConclusaoTarefa(props.row, 'Confirma a conclusão da tarefa?')">
                      <q-tooltip>Concluir tarefa</q-tooltip>
                    </q-btn>
                    <q-btn v-if="props.row.status === 'CO'" class="gt-xs" size="12px" flat dense round icon="remove_done" color="red"
                      @click="validarConclusaoTarefa(props.row, 'Passar tarefa novamente para pendente?')">
                      <q-tooltip>Passar tarefa para pendente</q-tooltip>
                    </q-btn>
                    <q-btn v-if="props.row.status === 'PE'" class="gt-xs" size="12px" flat dense round icon="delete"
                      @click="validarExclusao(props.row)">
                      <q-tooltip>Excluir tarefa</q-tooltip>
                    </q-btn>
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
    ...mapActions('util', ['callApi']),
    popularDatatable () {
      this.tarefas = []
      const getTarefas = async () => {
        try {
          const response = await this.callApi({ endPoint: `listar_tarefas/${this.tipoFiltroTarefas}` })
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
    validarExclusao (row) {
      this.$q.dialog({
        title: 'Confirmação',
        message: 'Deseja deletar o registro?',
        cancel: true,
        persistent: true
      }).onOk(() => {
        console.log(row)
        const destroy = async () => {
          try {
            const { message } = await this.callApi({ endPoint: `deletar_tarefa/${row.id}`, method: 'delete' })
            this.$util.mensagemSucesso(message)
            const linha = this.tarefas.indexOf(row)
            this.$delete(this.tarefas, linha)
          } catch ({ message }) {
            this.$util.mensagemErro(message)
          }
        }
        destroy()
      })
    },
    validarConclusaoTarefa (row, texto) {
      this.$q.dialog({
        title: 'Confirmação',
        message: texto,
        cancel: true,
        persistent: true
      }).onOk(() => {
        const updateStatus = async () => {
          try {
            const { message, type } = await this.callApi({ endPoint: 'atualizar_status_tarefa', method: 'put', data: row })
            this.$util.mensagemSucesso(message)
            if (type !== this.tipoFiltroTarefas) {
              const linha = this.tarefas.indexOf(row)
              this.$delete(this.tarefas, linha)
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
    formatarData (data) {
      return moment(data).utc().format('DD/MM/YYYY HH:mm')
    }
  },
  mounted () {
    this.popularDatatable()
  }
}
</script>
