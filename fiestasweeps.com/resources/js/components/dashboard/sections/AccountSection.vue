<template>
  <div class="content-section">
    <div class="content-header">
      <h1>Account Settings</h1>
      <p>Manage your personal information and account preferences</p>
    </div>

    <div class="card-custom mb-4">
      <div class="card-header">
        <h2>Personal Information</h2>
      </div>
      <div class="card-body">
        <form @submit.prevent="updateProfile">
          <div class="row g-3">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="firstName" class="form-label fw-bold text-uppercase">
                  First Name
                </label>
                <input
                  type="text"
                  id="firstName"
                  v-model="profileForm.name"
                  class="form-control-custom"
                  required
                >
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="lastName" class="form-label fw-bold text-uppercase">
                  Last Name
                </label>
                <input
                  type="text"
                  id="lastName"
                  v-model="profileForm.lname"
                  class="form-control-custom"
                >
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="email" class="form-label fw-bold text-uppercase">
                  Email
                </label>
                <input
                  type="email"
                  id="email"
                  v-model="profileForm.email"
                  class="form-control-custom"
                  required
                >
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="phone" class="form-label fw-bold text-uppercase">
                  Phone
                </label>
                <input
                  type="tel"
                  id="phone"
                  v-model="profileForm.phone"
                  class="form-control-custom"
                >
              </div>
            </div>
          </div>

          <div class="d-flex gap-3 mt-4">
            <button type="submit" class="btn-primary-custom">
              Save Changes
            </button>
            <button type="button" class="btn-secondary-custom">
              Cancel
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
      <div class="col-md-3" v-for="stat in stats" :key="stat.label">
        <div class="stat-card-custom">
          <div class="stat-number">{{ stat.value }}</div>
          <div class="stat-label">{{ stat.label }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, reactive, computed, onMounted } from 'vue'
import { useStore } from 'vuex'
import { toast } from '@/utils/toast'

export default {
  name: 'AccountSection',
  props: {
    user: {
      type: Object,
      required: true
    }
  },
  emits: ['update-user'],
  setup(props, { emit }) {
    const store = useStore()

    const profileForm = reactive({
      name: '',
      lname: '',
      email: '',
      phone: ''
    })

    const stats = ref([
      { label: 'Games Played', value: '0' },
      { label: 'Total Points', value: '0' },
      { label: 'Wins', value: '0' },
      { label: 'Account Level', value: '1' }
    ])

    const updateProfile = async () => {
      try {
        const response = await store.dispatch('auth/updateProfile', profileForm)
        emit('update-user', response.data.user)
        toast.success('Profile updated successfully!')
      } catch (error) {
        toast.error('Failed to update profile')
        console.error('Profile update error:', error)
      }
    }

    onMounted(() => {
      // Initialize form with user data
      if (props.user) {
        profileForm.name = props.user.name || ''
        profileForm.lname = props.user.lname || ''
        profileForm.email = props.user.email || ''
        profileForm.phone = props.user.phone || ''
      }
    })

    return {
      profileForm,
      stats,
      updateProfile
    }
  }
}
</script>
