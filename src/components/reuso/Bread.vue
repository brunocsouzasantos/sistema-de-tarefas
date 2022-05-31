<template>
    <div class="q-pb-sm q-gutter-sm">
    <q-breadcrumbs class="text-grey" active-color="indigo-10">
      <template v-slot:separator>
        <q-icon size="1.2em" name="arrow_forward" color="indigo-10"/>
      </template>
      <q-breadcrumbs-el label="Página inicial" icon="home" />
      <q-breadcrumbs-el :label="modulo" icon="widgets" />
      <q-breadcrumbs-el :label="passo1" icon="navigation" />
      <q-breadcrumbs-el v-if="passo2" :label="passo2" icon="person" />
      <q-breadcrumbs-el v-if="passo3" :label="passo3" icon="bubble_chart" />
    </q-breadcrumbs>
  </div>
</template>

<script>
export default {
  props: ['modulo', 'passo1', 'passo2', 'passo3']
}
</script>
