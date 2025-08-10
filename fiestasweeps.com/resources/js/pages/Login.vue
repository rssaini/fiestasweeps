<template>
  <div id="signin" class="min-vh-100 d-flex align-items-center justify-content-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
          <div class="signin-container">
            <div class="text-center mb-4">
              <img src="/assets/logo.png" alt="Fiesta Sweeps Logo" class="mb-3" style="height: 80px;">
              <h2>Welcome Back</h2>
              <p class="text-muted">Sign in to your account</p>
            </div>

            <form @submit.prevent="login">
              <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input
                  type="email"
                  id="email"
                  v-model="form.email"
                  class="form-control-custom"
                  placeholder="Enter your email"
                  required
                >
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                  type="password"
                  id="password"
                  v-model="form.password"
                  class="form-control-custom"
                  placeholder="Enter your password"
                  required
                >
              </div>

              <div class="mb-3 form-check">
                <input
                  type="checkbox"
                  class="form-check-input"
                  id="remember"
                  v-model="form.remember"
                >
                <label class="form-check-label text-light" for="remember">
                  Remember me
                </label>
              </div>

              <button type="submit" class="signinbutton w-100 mb-3" :disabled="loading">
                <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
                Sign In
              </button>

              <div class="text-center">
                <div class="forgot-password mb-2">
                  <a href="#" @click.prevent="forgotPassword">Forgot your password?</a>
                </div>
                <div class="create-account">
                  Don't have an account?
                  <router-link to="/register">Create Account</router-link>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { reactive, ref } from 'vue'
import { useStore } from 'vuex'
import { useRouter } from 'vue-router'
import { toast } from '@/utils/toast'

export default {
  name: 'Login',
  setup() {
    const store = useStore()
    const router = useRouter()
    const loading = ref(false)

    const form = reactive({
      email: '',
      password: '',
      remember: false
    })

    const login = async () => {
      loading.value = true
      try {
        await store.dispatch('auth/login', {
          email: form.email,
          password: form.password
        })

        toast.success('Welcome back!')
        router.push('/dashboard')
      } catch (error) {
        toast.error(error.message || 'Invalid email or password')
      } finally {
        loading.value = false
      }
    }

    const forgotPassword = () => {
      toast.info('Please contact support to reset your password')
    }

    return {
      form,
      loading,
      login,
      forgotPassword
    }
  }
}
</script>

<style scoped>
#signin {
  background: linear-gradient(135deg, #f9f0e4 0%, #e8dcc0 100%);
}

.signin-container {
  background-color: #13212b;
  padding: 2rem;
  border-radius: 1rem;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}
</style>
