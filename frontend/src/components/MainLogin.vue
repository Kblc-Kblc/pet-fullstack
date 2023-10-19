<template>
  <div class="flex flex-center q-pa-md bg-light-blue-10">
    <div class="column items-center">
      <q-input v-model="form.email" filled :dark="true" color="white" label="Имя пользователя" class="q-mb-md" />
      <q-input
        v-model="form.password"
        filled
        :dark="true"
        color="white"
        label="Пароль"
        type="password"
        class="q-mb-md"
      />
      <q-btn label="Войти" color="primary" @click.prevent="handleLogin" />
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import api from 'src/api/index'
import { useStore } from 'vuex'
import { useRouter } from 'vue-router'

export default {
  setup() {
    const form = ref({
      email: '',
      password: '',
    })

    const $store = useStore()
    const router = useRouter()

    const handleLogin = async () => {
      try {
        const response = await api.auth.login(form.value)
        localStorage.setItem('api_token', response.data.token)
        $store.commit('auth/SET_TOKEN', response.data.token)
        router.push('/dashboard')
      } catch (error) {
        console.error(error)
      }
    }
    return {
      form,
      handleLogin,
    }
  },
}
</script>
