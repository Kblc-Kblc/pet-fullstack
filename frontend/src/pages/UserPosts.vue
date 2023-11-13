<template>
  <div class="q-pa-md">
    <h2>Создание-просмотр своих постов</h2>

    <!-- Форма для создания поста -->
    <q-form class="q-gutter-md" style="max-width: 300px" @submit="onSubmit" @reset="onReset">
      <div>
        <q-input filled v-model="title" label="Введите заголовок" />
      </div>
      <div>
        <q-input v-model="body" filled type="textarea" label="Введите текст поста" />
      </div>
      <div>
        <q-btn label="Submit" type="submit" color="primary" />
        <q-btn label="Reset" type="reset" color="primary" flat class="q-ml-sm" />
      </div>
    </q-form>

    <!-- Список постов пользователя -->
    <div v-for="post in myPosts" :key="post.id">
      <post-card
        :post="post"
        :my-posts-edit="true"
        @post-deleted="handlePostDeleted"
        @post-updated="handlePostUpdated"
      />
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import api from 'src/api/index'
import PostCard from '@/components/PostCard.vue'

export default {
  name: 'UserPosts',
  components: {
    PostCard,
  },
  setup() {
    const title = ref('')
    const body = ref('')
    const myPosts = ref([])

    // Функции для работы с формой
    const onSubmit = () => {
      const postData = {
        title: title.value,
        body: body.value,
      }

      api.blogPost
        .createPost(postData)
        .then((response) => {
          console.log(response.data)
          onReset()
          loadMyPosts() // обновить список постов после добавления
        })
        .catch((error) => {
          console.error(error)
        })
    }

    const onReset = () => {
      title.value = ''
      body.value = ''
    }

    // Функции для работы с постами
    const loadMyPosts = () => {
      api.blogPost
        .getUserPosts()
        .then((response) => {
          myPosts.value = response.data
        })
        .catch((error) => {
          console.error(error)
        })
    }

    const handlePostDeleted = () => {
      loadMyPosts()
    }

    const handlePostUpdated = () => {
      loadMyPosts()
    }

    loadMyPosts()

    return {
      title,
      body,
      myPosts,
      onSubmit,
      onReset,
      handlePostDeleted,
      handlePostUpdated,
    }
  },
}
</script>

<style scoped>
/* Стили, связанные с формой и постами */
</style>
