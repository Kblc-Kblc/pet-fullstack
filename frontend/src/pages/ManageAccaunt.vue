<template>
  <div class="flex flex-center q-pa-md bg-light-blue-10">
    <div class="column items-center">
      <q-input v-model="form.name" filled :dark="true" color="white" label="Имя пользователя" class="q-mb-md" />
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
import { useQuasar } from 'quasar'
import api from 'src/api/index'

export default {
  name: 'ManageAccaunt',
  setup() {
    const form = ref({
      name: '',
      password: '',
      password_confirmation: '',
    })

    const $q = useQuasar()

    const handleUpdate = () => {
      try {
        if (form.value.password !== form.value.password_confirmation) {
          throw new Error('Пароли не совпадают')
        }

        const updateData = {
          name: form.value.name,
        }

        if (form.value.password) {
          updateData.password = form.value.password
          updateData.password_confirmation = form.value.password_confirmation
        }

        api.auth
          .update(updateData)
          .then(() => {
            $q.notify({
              type: 'positive',
              message: 'Данные пользователя успешно обновлены',
            })

            form.value.name = ''
            form.value.password = ''
            form.value.password_confirmation = ''
          })
          .catch((error) => {
            // Обработка ошибок обновления
            console.error('Ошибка обновления данных пользователя:', error)
          })
      } catch (error) {
        console.error('Ошибка:', error)
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
