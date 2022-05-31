<template>
  <q-tabs dense class="text-grey" active-color="primary" indicator-color="primary" align="justify">
    <q-route-tab label="Lista de Usuários" :to="{ name: 'gus_index' }" />
    <q-route-tab v-if="tipoCadastrar" label="Cadastrar Usuário" :to="{ name: 'gus_cadastrar' }" />
    <q-route-tab v-if="tipoEditar" label="Editar Usuário" :to="{ name: 'gus_editar' }" />
  </q-tabs>
</template>

<script>
export default {
  props: ['tipoEditar', 'tipoCadastrar']
}
</script>
