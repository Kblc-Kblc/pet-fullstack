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
    <div class="row card-wrapper">
      <div v-for="post in posts" :key="post.id" class="card-post">
        <div v-if="editingPostId !== post.id">
          <h3>{{ post.title }}</h3>
          <p>{{ post.body }}</p>
          <div class="row btn-controls">
            <q-btn
              v-if="post.user_id === store.getters['user/user'].data.id"
              label="Редактировать"
              color="secondary"
              @click="startEditing(post.id)"
            />
            <q-btn
              v-if="post.user_id === store.getters['user/user'].data.id"
              label="Удалить"
              color="primary"
              @click="deletePost(post.id)"
            />
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
  </div>
</template>

<script>
import { ref } from 'vue'
import api from 'src/api/index'
import { useStore } from 'vuex'

export default {
  setup() {
    const title = ref('')
    const body = ref('')
    const dense = ref(false)
    const posts = ref([])
    const editingPostId = ref(null)
    const editingTitle = ref('')
    const editingBody = ref('')
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
        .getPost()
        .then((response) => {
          posts.value = response.data
        })
        .catch((error) => {
          console.error(error)
        })
    }

    const deletePost = (postId) => {
      api.blogPost
        .deletePost(postId)
        .then(() => {
          loadPosts()
        })
        .catch((error) => {
          console.error('Ошибка при удалении поста:', error)
        })
    }

    const startEditing = (postId) => {
      const post = posts.value.find((p) => p.id === postId)
      if (post) {
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
          loadPosts()
          cancelEdit()
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
      deletePost,
      editingPostId,
      editingTitle,
      editingBody,
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
  .card-post {
    text-align: center;
    max-width: 300px;
    width: 100%;
    background-color: $grey-5;
    padding: 0px 0px 20px 0px;
  }
}

.btn-controls {
  justify-content: space-between;
  padding: 0px 16px;
}
</style>
