import api from 'src/api/index'

export const fetchUser = ({ commit }) => {
    return api.auth.me().then((response) => {
        commit('SET_USER', response.data)
    })
}
