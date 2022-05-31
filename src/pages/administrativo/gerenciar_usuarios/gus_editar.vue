<template>
  <q-page padding>
    <Bread modulo="Administrativo" passo1="Gerenciar Usuários" passo2="Editar" />
  <q-card>
    <GusAbas tipoEditar=true />
    <q-separator />
    <FormUsuario :tipoEditar="true" :formUsuario="formUsuario">
      <template v-slot:slBtCadastrarEditar>
        <q-btn label="Voltar" color="secondary" class="q-mr-sm" :to="{ name: 'gus_index'}" />
          <q-btn label="Editar" type="submit" color="primary"/>
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
  props: ['formUsuario']
}
</script>
