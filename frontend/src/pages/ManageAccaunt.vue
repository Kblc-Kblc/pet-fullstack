<template>
  <div class="flex flex-center q-pa-md bg-light-blue-10">
    <div class="column items-center">
      <q-input v-model="form.name" filled :dark="true" color="white" label="Имя пользователя" class="q-mb-md" />
      <q-input v-model="form.email" filled :dark="true" color="white" label="Электронная почта" class="q-mb-md" />
      <q-input
        v-model="form.password"
        filled
        :dark="true"
        color="white"
        label="Пароль"
        type="password"
        class="q-mb-md"
      />
      <q-input
        v-model="form.password_confirmation"
        filled
        :dark="true"
        color="white"
        label="Подстверждение пароля"
        type="password"
        class="q-mb-md"
      />
      <q-btn label="Изменить данные" color="primary" />
      <!-- @click.prevent="handleRegister" -->
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from 'src/api/index'

export default {
  name: 'ManageAccaunt',
  setup() {
    const form = ref({
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
    })

    const router = useRouter()

    return {
      form,
    }
  },
}
</script>

<style lang="scss" scoped></style>
