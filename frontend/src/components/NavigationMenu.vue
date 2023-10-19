<template>
  <q-toolbar>
    <!-- потом пофиксить чтобы дравер открывался\закрывался по нажатию -->
    <q-btn dense flat round icon="menu" @click="drawerLeft = !drawerLeft" />

    <q-toolbar-title> Title </q-toolbar-title>

    <div class="q-pa-md q-gutter-sm">
      <!-- Показывать эти кнопки, если пользователь НЕ вошел в систему -->
      <router-link v-if="!isLoggedIn" to="/login">
        <q-btn color="white" size="sm" text-color="black" label="Войти" />
      </router-link>

      <router-link v-if="!isLoggedIn" to="/register">
        <q-btn color="white" size="sm" text-color="black" label="Зарегестрироваться" />
      </router-link>

      <!-- Показывать эту кнопку, если пользователь вошел в систему -->
      <span v-if="isLoggedIn">
        <q-btn color="white" size="sm" text-color="black" label="Выйти" @click="handleLogout" />
      </span>
    </div>
  </q-toolbar>
</template>

<script>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useStore } from 'vuex'

import api from 'src/api/index'

export default {
  setup() {
    const drawerLeft = ref(false)
    const router = useRouter()
    const error = ref(null)
    const $store = useStore()
    const isLoggedIn = computed(() => !!$store.state.auth.token)

    const handleLogout = () => {
      api.auth
        .logout()
        .then(() => {
          localStorage.removeItem('api_token')
          $store.commit('auth/SET_TOKEN', null)

          router.push('/login')
        })
        .catch((err) => {
          error.value = 'Error logging out: ' + err.message
          console.error('Error logging out: ', err)
        })
    }
    return {
      handleLogout,
      error,
      isLoggedIn,
      drawerLeft,
    }
  },
}
</script>

<style></style>
