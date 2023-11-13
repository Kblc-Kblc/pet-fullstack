<template>
  <div class="row card-wrapper">
    <div class="card-post">
      <div v-if="editingPostId !== post.id">
        <h3>{{ post.title }}</h3>
        <p>{{ post.body }}</p>
        <div class="row btn-controls">
          <q-btn v-if="myPostsEdit" label="Редактировать" color="secondary" @click="startEditing(post.id)" />
          <q-btn v-if="myPostsEdit" label="Удалить" color="primary" @click="deletePost(post.id)" />
        </div>
      </div>
      <div v-else>
        <q-input v-model="editingTitle" label="Заголовок" />
        <q-input v-model="editingBody" label="Содержимое" type="textarea" />
        <div class="row btn-controls">
          <q-btn label="Сохранить" @click="saveEdit(post.id)" />
          <q-btn label="Отмена" @click="cancelEdit" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import api from 'src/api/index'
import { useStore } from 'vuex'

export default {
  name: 'PostCard',
  props: {
    post: {
      type: Object,
      required: true,
    },
    myPostsEdit: {
      type: Boolean,
      default: false,
    },
  },
  setup(props, context) {
    const editingPostId = ref(null)
    const editingTitle = ref('')
    const editingBody = ref('')
    const store = useStore()

    const deletePost = (postId) => {
      api.blogPost
        .deletePost(postId)
        .then(() => {
          context.emit('post-deleted')
        })
        .catch((error) => {
          console.error('Ошибка при удалении поста:', error)
        })
    }

    const startEditing = (postId) => {
      const post = props.post
      if (post && post.id === postId) {
        editingTitle.value = post.title
        editingBody.value = post.body
        editingPostId.value = postId
      }
    }

    const saveEdit = (postId) => {
      const updatedData = {
        title: editingTitle.value,
        body: editingBody.value,
      }
      api.blogPost
        .updatePost(postId, updatedData)
        .then(() => {
          context.emit('post-updated')
          editingPostId.value = null
        })
        .catch((error) => {
          console.error('Ошибка при редактировании поста:', error)
        })
    }

    const cancelEdit = () => {
      editingPostId.value = null
      editingTitle.value = ''
      editingBody.value = ''
    }

    return {
      editingPostId,
      editingTitle,
      editingBody,
      deletePost,
      startEditing,
      saveEdit,
      cancelEdit,
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
