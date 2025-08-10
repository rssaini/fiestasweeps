import api from './api'
import { storage } from './storage'

export const authService = {
  async login(credentials) {
    try {
      const response = await api.post('/auth/login', credentials)
      const { access_token, user } = response.data

      storage.setToken(access_token)
      storage.setUser(user)

      return { token: access_token, user }
    } catch (error) {
      throw error.response?.data || error.message
    }
  },

  async register(userData) {
    try {
      const response = await api.post('/auth/register', userData)
      const { access_token, user } = response.data

      storage.setToken(access_token)
      storage.setUser(user)

      return { token: access_token, user }
    } catch (error) {
      throw error.response?.data || error.message
    }
  },

  async logout() {
    try {
      await api.post('/auth/logout')
    } catch (error) {
      console.error('Logout error:', error)
    } finally {
      storage.removeToken()
      storage.removeUser()
    }
  },

  async fetchUser() {
    try {
      const response = await api.get('/auth/user')
      const user = response.data
      storage.setUser(user)
      return user
    } catch (error) {
      storage.removeToken()
      storage.removeUser()
      throw error
    }
  },

  async updateProfile(profileData) {
    const response = await api.put('/auth/profile', profileData)
    const user = response.data.user
    storage.setUser(user)
    return response
  },

  async updatePassword(passwordData) {
    return await api.put('/auth/password', passwordData)
  },

  async updateUserSetting(setting, value) {
    const response = await api.post('/auth/settings', { [setting]: value })
    const user = storage.getUser()
    if (user) {
      user[setting] = value
      storage.setUser(user)
    }
    return response
  },

  async refreshToken() {
    try {
      const response = await api.post('/auth/refresh')
      const { access_token } = response.data
      storage.setToken(access_token)
      return access_token
    } catch (error) {
      this.logout()
      throw error
    }
  },

  isAuthenticated() {
    return !!storage.getToken()
  },

  getUser() {
    return storage.getUser()
  },

  getToken() {
    return storage.getToken()
  }
}
