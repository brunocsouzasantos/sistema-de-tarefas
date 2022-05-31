<template>
  <q-tabs dense class="text-grey" active-color="primary" indicator-color="primary" align="justify">
    <q-route-tab label="Lista de Tarefas" :to="{ name: 'taf_index' }" />
    <q-route-tab v-if="tipoCadastrar" label="Cadastrar Tarefa" :to="{ name: 'taf_cadastrar' }" />
    <q-route-tab v-if="tipoEditar" label="Editar Tarefa" :to="{ name: 'taf_editar' }" />
  </q-tabs>
</template>

<script>
export default {
  props: ['tipoEditar', 'tipoCadastrar']
}
</script>
