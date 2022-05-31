<template>
  <q-page padding>
    <Bread modulo="Administrativo" passo1="Gerenciar Usuários" passo2="Cadastrar" />
  <q-card>
    <GusAbas tipoCadastrar=true />
    <q-separator />
    <FormUsuario :formUsuario="formUsuario">
      <template v-slot:slBtCadastrarEditar>
        <q-btn label="Cadastrar" type="submit" color="primary"/>
      </template>
    </FormUsuario>
  </q-card>
  </q-page>
</template>
<script>
import FormUsuario from 'components/administrativo/usuario/FormUsuario'
import Bread from 'components/reuso/Bread'
import GusAbas from './GusAbas'
export default {
  components: {
    FormUsuario,
    Bread,
    GusAbas
  },
  data () {
    return {
      formUsuario: {}
    }
  }
}
</script>
