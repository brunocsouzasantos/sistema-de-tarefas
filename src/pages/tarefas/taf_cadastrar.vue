<template>
  <q-page padding>
    <Bread modulo="Tarefas" passo1="Cadastrar" />
  <q-card>
    <TafAbas tipoCadastrar=true />
    <q-separator />
    <FormTarefa :formTarefa="formTarefa">
      <template v-slot:slBtCadastrarEditar>
        <q-btn label="Cadastrar" type="submit" color="primary"/>
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
  data () {
    return {
      formTarefa: {}
    }
  }
}
</script>
