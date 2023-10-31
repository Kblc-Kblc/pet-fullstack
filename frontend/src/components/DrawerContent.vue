<template>
  <div class="q-mt-md q-ml-md">
    <div>
      <router-link :to="{ name: 'dashboard' }">
        <a>Все посты</a>
      </router-link>
    </div>

    <div>
      <router-link :to="{ name: 'user-posts' }">
        <a>мои посты</a>
      </router-link>
    </div>
  </div>
</template>

<script>
export default {}
</script>

<style></style>
