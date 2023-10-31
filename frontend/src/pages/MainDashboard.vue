<template>
  <div>
    <q-form class="q-gutter-md" style="max-width: 300px" @submit="onSubmit" @reset="onReset">
      <div class="q-pa-md">
        <p>Введите заголовок</p>
        <q-input v-model="title" :dense="dense" />
      </div>
      <div class="q-pa-md">
        <p>Введите текст поста</p>
        <q-input v-model="body" filled type="textarea" />
      </div>
      <div style="margin-left: 32px">
        <q-btn label="Submit" type="submit" color="primary" />
        <q-btn label="Reset" type="reset" color="primary" flat class="q-ml-sm" />
      </div>
    </q-form>
    <div v-for="post in posts" :key="post.id">
      <post-card :post="post" />
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import api from 'src/api/index'
import { useStore } from 'vuex'
import PostCard from '@/components/PostCard.vue'

export default {
  components: {
    PostCard,
  },
  setup() {
    const title = ref('')
    const body = ref('')
    const dense = ref(false)
    const posts = ref([])
    const store = useStore()

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
          loadPosts()
        })
        .catch((error) => {
          console.error(error)
        })
    }

    const onReset = () => {
      title.value = ''
      body.value = ''
    }

    const loadPosts = () => {
      api.blogPost
        .getAllPosts()
        .then((response) => {
          posts.value = response.data
        })
        .catch((error) => {
          console.error(error)
        })
    }

    const loadUser = () => {
      store.dispatch('user/fetchUser').catch((error) => {
        console.error('Ошибка при получении пользователя:', error)
      })
    }

    loadUser()
    loadPosts()

    return {
      title,
      body,
      dense,
      onSubmit,
      onReset,
      posts,
      store,
    }
  },
}
</script>

<style scoped lang="scss">
.card-wrapper {
  gap: 30px;
  margin-top: 20px;
  justify-content: center;
  align-items: center;
}

.card-post {
  text-align: center;
  max-width: 300px;
  width: 100%;
  background-color: $grey-5;
  padding: 0px 0px 20px 0px;
}

.btn-controls {
  justify-content: space-between;
  padding: 0px 16px;
}
</style>
