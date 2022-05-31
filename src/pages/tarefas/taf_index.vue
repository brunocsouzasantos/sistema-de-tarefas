<template>
  <q-page padding>
    <Bread modulo="Tarefas" passo1="Lista de Tarefas" />
  <q-card>
    <TafAbas tipoCadastrar=true />
  <q-separator />
  <DatatableTarefas />
  <div class="q-pa-md q-gutter-sm float-right">
    <q-btn type="submit" color="primary" label="Cadastrar" :to="{ name: 'taf_cadastrar'}" />
  </div>
  </q-card>
  </q-page>
</template>
<script>
import DatatableTarefas from 'components/tarefa/DatatableTarefas'
import Bread from 'components/reuso/Bread'
import TafAbas from './TafAbas'
export default {
  components: {
    DatatableTarefas,
    Bread,
    TafAbas
  }
}
</script>
