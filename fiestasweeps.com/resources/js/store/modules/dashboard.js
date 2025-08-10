import api from '@/services/api'

const state = {
  stats: {
    currentBalance: 0,
    totalDeposited: 0,
    totalWinnings: 0,
    gamesPlayed: 0,
    accountLevel: 1
  },
  gameHistory: [],
  transactions: [],
  loading: false
}

const getters = {
  stats: (state) => state.stats,
  gameHistory: (state) => state.gameHistory,
  transactions: (state) => state.transactions,
  loading: (state) => state.loading
}

const mutations = {
  SET_STATS(state, stats) {
    state.stats = { ...state.stats, ...stats }
  },
  SET_GAME_HISTORY(state, history) {
    state.gameHistory = history
  },
  SET_TRANSACTIONS(state, transactions) {
    state.transactions = transactions
  },
  SET_LOADING(state, loading) {
    state.loading = loading
  }
}

const actions = {
  async fetchStats({ commit }) {
    try {
      const response = await api.get('/dashboard/stats')
      commit('SET_STATS', response.data)
      return response.data
    } catch (error) {
      throw error
    }
  },

  async fetchGameHistory({ commit }, params = {}) {
    try {
      const response = await api.get('/dashboard/game-history', { params })
      commit('SET_GAME_HISTORY', response.data.data)
      return response.data
    } catch (error) {
      throw error
    }
  },

  async fetchTransactions({ commit }, params = {}) {
    try {
      const response = await api.get('/dashboard/transactions', { params })
      commit('SET_TRANSACTIONS', response.data.data)
      return response.data
    } catch (error) {
      throw error
    }
  },

  async addFunds({ dispatch }, fundData) {
    try {
      const response = await api.post('/dashboard/add-funds', fundData)
      await dispatch('fetchStats') // Refresh stats after adding funds
      return response.data
    } catch (error) {
      throw error
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
