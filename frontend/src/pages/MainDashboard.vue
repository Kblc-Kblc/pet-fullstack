<template>
  <div>
    <q-form class="q-gutter-md" @submit="onSubmit" @reset="onReset">
      <q-input v-model="title" :dense="dense" />
      <div class="q-pa-md" style="max-width: 300px">
        <q-input v-model="body" filled type="textarea" />
      </div>
      <div>
        <q-btn label="Submit" type="submit" color="primary" />
        <q-btn label="Reset" type="reset" color="primary" flat class="q-ml-sm" />
      </div>
    </q-form>
    <div v-for="post in posts" :key="post.id">
      <h3>{{ post.title }}</h3>
      <p>{{ post.body }}</p>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import api from 'src/api/index'

export default {
  setup() {
    const title = ref('')
    const body = ref('')
    const dense = ref(false)

    const posts = ref([])

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

    loadPosts()

    return {
      title,
      body,
      dense,
      onSubmit,
      onReset,
      posts,
    }
  },
}
</script>

<style></style>
