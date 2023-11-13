<template>
  <div>
    <div v-for="post in posts" :key="post.id">
      <post-card :post="post" />
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import { useStore } from 'vuex'
import api from 'src/api/index'
import PostCard from '@/components/PostCard.vue'

export default {
  name: 'MainDashboard',
  components: {
    PostCard,
  },
  setup() {
    const posts = ref([])
    const store = useStore()

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
      posts,
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
