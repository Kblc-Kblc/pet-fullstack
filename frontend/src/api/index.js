import axios from 'axios'

export default {
    auth: {
        login: (data = {}) => api().post('/auth/login', data),
        logout: (data = {}) => api().post('/auth/logout', data),
        register: (data = {}) => api().post('/auth/register', data),
        me: () => api().get('/auth/me'),
    },
    blogPost: {
        createPost: (data = {}) => api().post('/auth/posts', data),
        getPost: (data = {}) => api().get('/auth/posts', data),
        deletePost: (postId) => api().delete(`/auth/posts/${postId}`),
        updatePost: (postId, data) => api().put(`/auth/posts/${postId}`, data),
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
