<template>
  <div id="register" class="min-vh-100 d-flex align-items-center justify-content-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
          <div class="register-container">
            <div class="text-center mb-4">
              <img src="/assets/logo.png" alt="Fiesta Sweeps Logo" class="mb-3" style="height: 80px;">
              <h2>Create Account</h2>
              <p class="text-muted">Join Fiesta Sweeps today</p>
            </div>

            <form @submit.prevent="register">
              <div class="row g-3">
                <div class="col-md-6">
                  <label for="fname" class="form-label">First Name</label>
                  <input
                    type="text"
                    id="fname"
                    v-model="form.fname"
                    class="form-control-custom"
                    placeholder="First Name"
                    required
                  >
                </div>
                <div class="col-md-6">
                  <label for="lname" class="form-label">Last Name</label>
                  <input
                    type="text"
                    id="lname"
                    v-model="form.lname"
                    class="form-control-custom"
                    placeholder="Last Name"
                  >
                </div>
              </div>

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
                <label for="phone" class="form-label">Phone Number</label>
                <input
                  type="tel"
                  id="phone"
                  v-model="form.phone"
                  class="form-control-custom"
                  placeholder="Enter your phone number"
                >
              </div>

              <div class="row g-3">
                <div class="col-md-6">
                  <label for="password" class="form-label">Password</label>
                  <input
                    type="password"
                    id="password"
                    v-model="form.password"
                    class="form-control-custom"
                    placeholder="Create password"
                    minlength="8"
                    required
                  >
                </div>
                <div class="col-md-6">
                  <label for="password_confirmation" class="form-label">Confirm Password</label>
                  <input
                    type="password"
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    class="form-control-custom"
                    placeholder="Confirm password"
                    required
                  >
                </div>
              </div>

              <div class="mb-3 form-check">
                <input
                  type="checkbox"
                  class="form-check-input"
                  id="terms"
                  v-model="form.acceptTerms"
                  required
                >
                <label class="form-check-label text-light" for="terms">
                  I agree to the <a href="/terms" target="_blank">Terms of Service</a> and
                  <a href="/privacy-policy" target="_blank">Privacy Policy</a>
                </label>
              </div>

              <button type="submit" class="signinbutton w-100 mb-3" :disabled="loading">
                <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
                Create Account
              </button>

              <div class="text-center">
                <div class="create-account">
                  Already have an account?
                  <router-link to="/login">Sign In</router-link>
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
  name: 'Register',
  setup() {
    const store = useStore()
    const router = useRouter()
    const loading = ref(false)

    const form = reactive({
      fname: '',
      lname: '',
      email: '',
      phone: '',
      password: '',
      password_confirmation: '',
      acceptTerms: false
    })

    const register = async () => {
      if (form.password !== form.password_confirmation) {
        toast.error('Passwords do not match')
        return
      }

      if (!form.acceptTerms) {
        toast.error('Please accept the Terms of Service')
        return
      }

      loading.value = true
      try {
        await store.dispatch('auth/register', form)

        toast.success('Account created successfully! Welcome to Fiesta Sweeps!')
        router.push('/dashboard')
      } catch (error) {
        if (error.errors) {
          // Handle validation errors
          Object.values(error.errors).flat().forEach(err => {
            toast.error(err)
          })
        } else {
          toast.error(error.message || 'Failed to create account')
        }
      } finally {
        loading.value = false
      }
    }

    return {
      form,
      loading,
      register
    }
  }
}
</script>

<style scoped>
#register {
  background: linear-gradient(135deg, #f9f0e4 0%, #e8dcc0 100%);
}

.register-container {
  background-color: #13212b;
  padding: 2rem;
  border-radius: 1rem;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}
</style>
