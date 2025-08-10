import { createStore } from 'vuex'
import auth from './modules/auth'
import dashboard from './modules/dashboard'

export default createStore({
  modules: {
    auth,
    dashboard
  },
  strict: process.env.NODE_ENV !== 'production'
})
