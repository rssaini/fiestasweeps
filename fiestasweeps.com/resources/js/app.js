import { createApp } from 'vue'
import App from './App.vue'
import { launch } from 'devtools-detector';
import router from './router'
import store from './store'

// Bootstrap
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap'

import '@fortawesome/fontawesome-free/css/all.css'

// Custom Styles
//import '@/../css/app.scss'
//import '@/../css/dashboard.scss'

const app = createApp(App)

app.config.errorHandler = (err, vm, info) => {
  console.error('Global error:', err, info)
}

// Initialize auth state
store.dispatch('auth/initializeAuth')

app.use(store)
app.use(router)
app.mount('#root')
//launch();

