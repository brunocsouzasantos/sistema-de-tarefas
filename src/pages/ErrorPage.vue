<template>
  <div class="fullscreen bg-blue-4 text-white text-center q-pa-md flex flex-center">
    <div>
      <div style="font-size: 20vh">
        Ops!
      </div>

      <div class="text-h4" style="opacity:.4">
        Vocês está tentando acessar uma página protediga ou o endereço não existe!
      </div>

      <q-btn
        class="q-mt-xl"
        color="white"
        text-color="blue"
        unelevated
        to="/"
        label="Ir para a página inicial do sistema"
        no-caps
      />
    </div>
  </div>
</template>

<script>
export default {
  name: 'ErrorPage'
}
</script>
