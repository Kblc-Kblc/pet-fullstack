import axios from 'axios'

export default {
  auth: {
    login: (data = {}) => api().post('/auth/login', data),
    logout: (data = {}) => api().post('/auth/logout', data),
    register: (data = {}) => api().post('/auth/register', data),
  },
  blogPost: {
    createPost: (data = {}) => api().post('/auth/posts', data),
    getPost: (data = {}) => api().get('/auth/posts', data),
  },
}

function api() {
  return axios.create({
    baseURL: import.meta.env.VITE_BASE_URL + '/api/v1',
    headers: {
      Accept: 'application/json',
      Authorization: 'Bearer ' + localStorage.getItem('api_token'),
    },
  })
}
