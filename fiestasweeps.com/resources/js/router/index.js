import { createRouter, createWebHistory } from 'vue-router'
import { authService } from '@/services/auth'
import store from '@/store'

const routes = [
  {
    path: '/',
    redirect: '/player'
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('@/pages/Login.vue'),
    meta: {
      requiresGuest: true,
      title: 'Login - Fiesta Sweeps'
    }
  },
  {
    path: '/register',
    name: 'Register',
    component: () => import('@/pages/Register.vue'),
    meta: {
      requiresGuest: true,
      title: 'Register - Fiesta Sweeps'
    }
  },
  {
    path: '/player',
    name: 'Dashboard',
    component: () => import('@/pages/Dashboard.vue'),
    meta: {
      //requiresAuth: true,
      requiresGuest: true,
      title: 'Dashboard - Fiesta Sweeps'
    }
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: () => import('@/pages/NotFound.vue'),
    meta: {
      title: 'Page Not Found - Fiesta Sweeps'
    }
  }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.VITE_APP_BASE_URL),
  routes
})

// Navigation guards
router.beforeEach(async (to, from, next) => {
  // Set page title
  document.title = to.meta.title || 'Fiesta Sweeps'

  const isAuthenticated = authService.isAuthenticated()

  // Check if route requires authentication
  if (to.meta.requiresAuth && !isAuthenticated) {
    next('/login')
    return
  }

  // Check if route requires guest (not authenticated)
  if (to.meta.requiresGuest && isAuthenticated) {
    next('/dashboard')
    return
  }

  // If authenticated, verify token is still valid
  if (isAuthenticated && to.meta.requiresAuth) {
    try {
      if (!store.getters['auth/user']) {
        await store.dispatch('auth/fetchUser')
      }
    } catch (error) {
      // Token invalid, redirect to login
      next('/login')
      return
    }
  }

  next()
})

export default router
