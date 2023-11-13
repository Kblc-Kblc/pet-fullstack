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
      <q-btn label="Изменить данные" color="primary" @click.prevent="handleUpdate" />
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
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

    const handleUpdate = async () => {
      try {
        if (form.value.password !== form.value.password_confirmation) {
          throw new Error('Пароли не совпадают')
        }

        const updateData = {
          name: form.value.name,
          email: form.value.email,
        }

        if (form.value.password) {
          updateData.password = form.value.password
          updateData.password_confirmation = form.value.password_confirmation
        }

        await api.auth.update(updateData)
      } catch (error) {
        console.error('Ошибка обновления данных пользователя:', error)
      }
    }

    return {
      form,
      handleUpdate,
    }
  },
}
</script>

<style lang="scss" scoped></style>
