import { authService } from '@/services/auth'

const state = {
  user: null,
  token: null,
  isAuthenticated: false,
  loading: false
}

const getters = {
  user: (state) => state.user,
  token: (state) => state.token,
  isAuthenticated: (state) => state.isAuthenticated,
  loading: (state) => state.loading
}

const mutations = {
  SET_USER(state, user) {
    state.user = user
  },
  SET_TOKEN(state, token) {
    state.token = token
  },
  SET_AUTHENTICATED(state, status) {
    state.isAuthenticated = status
  },
  SET_LOADING(state, status) {
    state.loading = status
  },
  CLEAR_AUTH(state) {
    state.user = null
    state.token = null
    state.isAuthenticated = false
  },
  UPDATE_USER_SETTING(state, { setting, value }) {
    if (state.user) {
      state.user[setting] = value
    }
  }
}

const actions = {
  async login({ commit }, credentials) {
    commit('SET_LOADING', true)
    try {
      const { token, user } = await authService.login(credentials)
      commit('SET_TOKEN', token)
      commit('SET_USER', user)
      commit('SET_AUTHENTICATED', true)
      return { token, user }
    } finally {
      commit('SET_LOADING', false)
    }
  },

  async register({ commit }, userData) {
    commit('SET_LOADING', true)
    try {
      const { token, user } = await authService.register(userData)
      commit('SET_TOKEN', token)
      commit('SET_USER', user)
      commit('SET_AUTHENTICATED', true)
      return { token, user }
    } finally {
      commit('SET_LOADING', false)
    }
  },

  async logout({ commit }) {
    commit('SET_LOADING', true)
    try {
      await authService.logout()
    } finally {
      commit('CLEAR_AUTH')
      commit('SET_LOADING', false)
    }
  },

  async fetchUser({ commit }) {
    try {
      const user = await authService.fetchUser()
      commit('SET_USER', user)
      commit('SET_AUTHENTICATED', true)
      return user
    } catch (error) {
      commit('CLEAR_AUTH')
      throw error
    }
  },

  async updateProfile({ commit }, profileData) {
    const response = await authService.updateProfile(profileData)
    commit('SET_USER', response.data.user)
    return response
  },

  async updatePassword({ commit }, passwordData) {
    return await authService.updatePassword(passwordData)
  },

  async updateUserSetting({ commit }, { setting, value }) {
    try {
      const response = await authService.updateUserSetting(setting, value)
      commit('UPDATE_USER_SETTING', { setting, value })
      return response
    } catch (error) {
      throw error
    }
  },

  updateUser({ commit }, user) {
    commit('SET_USER', user)
  },

  initializeAuth({ commit }) {
    const token = authService.getToken()
    const user = authService.getUser()

    if (token && user) {
      commit('SET_TOKEN', token)
      commit('SET_USER', user)
      commit('SET_AUTHENTICATED', true)
    }
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
