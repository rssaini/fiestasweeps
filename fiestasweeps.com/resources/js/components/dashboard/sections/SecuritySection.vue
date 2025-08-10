<template>
  <div class="content-section">
    <div class="content-header">
      <h1>Security</h1>
      <p>Protect your account with security settings</p>
    </div>

    <!-- Change Password Card -->
    <div class="card-custom mb-4">
      <div class="card-header">
        <h2>Change Password</h2>
      </div>
      <div class="card-body">
        <form @submit.prevent="updatePassword">
          <div class="mb-3">
            <label for="currentPassword" class="form-label fw-bold text-uppercase text-light">
              Current Password
            </label>
            <input
              type="password"
              id="currentPassword"
              v-model="passwordForm.currentPassword"
              class="form-control-custom"
              required
            >
          </div>
          <div class="mb-3">
            <label for="newPassword" class="form-label fw-bold text-uppercase text-light">
              New Password
            </label>
            <input
              type="password"
              id="newPassword"
              v-model="passwordForm.newPassword"
              class="form-control-custom"
              minlength="8"
              required
            >
          </div>
          <div class="mb-3">
            <label for="confirmPassword" class="form-label fw-bold text-uppercase text-light">
              Confirm New Password
            </label>
            <input
              type="password"
              id="confirmPassword"
              v-model="passwordForm.confirmPassword"
              class="form-control-custom"
              required
            >
          </div>
          <button type="submit" class="btn-primary-custom" :disabled="passwordLoading">
            <span v-if="passwordLoading" class="spinner-border spinner-border-sm me-2"></span>
            Update Password
          </button>
        </form>
      </div>
    </div>

    <!-- Two-Factor Authentication Card -->
    <div class="card-custom">
      <div class="card-header">
        <h2>Two-Factor Authentication</h2>
      </div>
      <div class="card-body">
        <p class="text-light mb-3">Add an extra layer of security to your account</p>
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <h5 class="text-light mb-1">2FA Status</h5>
            <p class="text-muted mb-0">
              {{ twoFactorEnabled ? 'Enabled' : 'Disabled' }}
            </p>
          </div>
          <button
            class="btn"
            :class="twoFactorEnabled ? 'btn-outline-danger' : 'btn-primary-custom'"
            @click="toggleTwoFactor"
            :disabled="twoFactorLoading"
          >
            <span v-if="twoFactorLoading" class="spinner-border spinner-border-sm me-2"></span>
            {{ twoFactorEnabled ? 'Disable 2FA' : 'Enable 2FA' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, reactive } from 'vue'
import { useStore } from 'vuex'
import { toast } from '@/utils/toast'

export default {
  name: 'SecuritySection',
  props: {
    user: {
      type: Object,
      required: true
    }
  },
  setup() {
    const store = useStore()

    const passwordLoading = ref(false)
    const twoFactorLoading = ref(false)
    const twoFactorEnabled = ref(false)

    const passwordForm = reactive({
      currentPassword: '',
      newPassword: '',
      confirmPassword: ''
    })

    const updatePassword = async () => {
      if (passwordForm.newPassword !== passwordForm.confirmPassword) {
        toast.error('New passwords do not match')
        return
      }

      passwordLoading.value = true
      try {
        await store.dispatch('auth/updatePassword', {
          current_password: passwordForm.currentPassword,
          password: passwordForm.newPassword,
          password_confirmation: passwordForm.confirmPassword
        })

        // Reset form
        passwordForm.currentPassword = ''
        passwordForm.newPassword = ''
        passwordForm.confirmPassword = ''

        toast.success('Password updated successfully!')
      } catch (error) {
        toast.error(error.message || 'Failed to update password')
      } finally {
        passwordLoading.value = false
      }
    }

    const toggleTwoFactor = async () => {
      twoFactorLoading.value = true
      try {
        // This would integrate with your 2FA implementation
        await new Promise(resolve => setTimeout(resolve, 1000)) // Simulate API call
        twoFactorEnabled.value = !twoFactorEnabled.value
        toast.success(`Two-factor authentication ${twoFactorEnabled.value ? 'enabled' : 'disabled'}`)
      } catch (error) {
        toast.error('Failed to update two-factor authentication')
      } finally {
        twoFactorLoading.value = false
      }
    }

    return {
      passwordForm,
      passwordLoading,
      twoFactorLoading,
      twoFactorEnabled,
      updatePassword,
      toggleTwoFactor
    }
  }
}
</script>
