<template>
  <q-page padding>
    <Bread modulo="Administrativo" passo1="Gerenciar Usuários" passo2="Lista de Usuarios" />
  <q-card>
    <GusAbas tipoCadastrar=true />
  <q-separator />
  <DatatableUsuarios />
  <div class="q-pa-md q-gutter-sm float-right">
    <q-btn type="submit" color="primary" label="Cadastrar" :to="{ name: 'gus_cadastrar'}" />
  </div>
  </q-card>
  </q-page>
</template>
<script>
import DatatableUsuarios from 'components/administrativo/usuario/DatatableUsuarios'
import Bread from 'components/reuso/Bread'
import GusAbas from './GusAbas'
export default {
  components: {
    DatatableUsuarios,
    Bread,
    GusAbas
  }
}
</script>
