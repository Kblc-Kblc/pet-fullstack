<template>
  <div>
    <h2>собственные посты юзера</h2>
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
  components: {
    PostCard,
  },
  setup() {
    const myPosts = ref([])

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
      myPosts,
      handlePostDeleted,
      handlePostUpdated,
    }
  },
}
</script>

<style></style>
