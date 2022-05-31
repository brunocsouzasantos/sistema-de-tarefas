<template>
  <q-layout view="hHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="leftDrawerOpen = !leftDrawerOpen"
        />

        <q-toolbar-title>
          Sistema de Tarefas
        </q-toolbar-title>

      </q-toolbar>
    </q-header>

    <q-drawer  v-if="usuario"
      v-model="leftDrawerOpen"
      show-if-above
      bordered
      content-class="bg-grey-1"
    >
      <q-list>
        <q-item-label
          header
          class="text-grey-8"
        >
        <div style="font-size:1.2em;">Olá {{retornaPrimeiroNome()}}, bem vindo!</div><br />
        </q-item-label>
        <q-item exact v-if="usuario && usuario.permissao === 'ADM'" clickable tag="a" :to="{ name: 'gus_index'}">
          <q-item-section avatar>
            <q-icon name="people" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Gerenciar Usuários</q-item-label>
            <q-item-label caption></q-item-label>
          </q-item-section>
        </q-item>
        <q-item  v-if="usuario" exact clickable tag="a" :to="{ name: 'taf_index'}">
          <q-item-section avatar>
            <q-icon name="task" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Gerenciar Lista de Tarefas</q-item-label>
            <q-item-label caption></q-item-label>
          </q-item-section>
        </q-item>

        <q-item v-if="usuario" clickable @click="logout">
          <q-item-section avatar>
            <q-icon name="logout" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Logout</q-item-label>
            <q-item-label caption>Sair do sistema</q-item-label>
          </q-item-section>
        </q-item>

      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import { mapState, mapActions } from 'vuex'
export default {
  name: 'MainLayout',
  data () {
    return {
      leftDrawerOpen: false
    }
  },
  computed: {
    ...mapState('gerenciarUsuario', ['usuario'])
  },
  methods: {
    ...mapActions('gerenciarUsuario', ['logout']),
    retornaPrimeiroNome () {
      const nomeCompleto = this.usuario.nome
      return nomeCompleto.split(' ')[0]
    }
  }
}
</script>
