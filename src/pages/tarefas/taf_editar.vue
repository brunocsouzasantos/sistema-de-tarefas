<template>
  <q-page padding>
    <Bread modulo="Tarefas" passo1="Editar" />
  <q-card>
    <TafAbas tipoEditar=true />
    <q-separator />
    <FormTarefa :tipoEditar="true" :formTarefa="formTarefa">
      <template v-slot:slBtCadastrarEditar>
        <q-btn label="Voltar" color="secondary" class="q-mr-sm" :to="{ name: 'taf_index'}" />
          <q-btn label="Editar" type="submit" color="primary"/>
      </template>
    </FormTarefa>
  </q-card>
  </q-page>
</template>
<script>
import FormTarefa from 'components/tarefa/FormTarefa'
import Bread from 'components/reuso/Bread'
import TafAbas from './TafAbas'
export default {
  components: {
    FormTarefa,
    Bread,
    TafAbas
  },
  props: ['formTarefa']
}
</script>
