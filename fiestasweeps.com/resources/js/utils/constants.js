export const API_ENDPOINTS = {
  AUTH: {
    LOGIN: '/auth/login',
    REGISTER: '/auth/register',
    LOGOUT: '/auth/logout',
    USER: '/auth/user',
    REFRESH: '/auth/refresh',
    UPDATE_PROFILE: '/auth/profile',
    UPDATE_PASSWORD: '/auth/password'
  },
  DASHBOARD: {
    STATS: '/dashboard/stats',
    GAME_HISTORY: '/dashboard/game-history',
    TRANSACTIONS: '/dashboard/transactions',
    ADD_FUNDS: '/dashboard/add-funds'
  }
}

export const USER_ROLES = {
  PLAYER: 'Player',
  ADMIN: 'Admin',
  SUPERVISOR: 'Supervisor',
  AGENT: 'Agent'
}

export const GAME_STATUSES = {
  COMPLETED: 'completed',
  PENDING: 'pending',
  FAILED: 'failed'
}

export const TRANSACTION_TYPES = {
  DEPOSIT: 'deposit',
  WITHDRAWAL: 'withdrawal',
  WIN: 'win',
  BET: 'bet'
}

export const PRIVACY_SETTINGS = {
  GAME_STATS: 'game_stats',
  MARKETING_STATS: 'marketting_stats',
  ONLINE_STATS: 'online_stats'
}
