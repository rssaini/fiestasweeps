<template>
  <div class="dashboard-container">
    <PageLoader v-if="loading" />
    <Sidebar
      :active-section="activeSection"
      @section-change="handleSectionChange"
    />
    <main class="main-content">
      <component
        :is="currentSectionComponent"
        :user="user"
        @update-user="handleUserUpdate"
      />
    </main>
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue'
import { useStore } from 'vuex'
import Sidebar from '@/components/dashboard/Sidebar.vue'
import PageLoader from '@/components/PageLoader.vue'

// Section Components
import AccountSection from '@/components/dashboard/sections/AccountSection.vue'
import PrivacySection from '@/components/dashboard/sections/PrivacySection.vue'
import SecuritySection from '@/components/dashboard/sections/SecuritySection.vue'
import IdentitySection from '@/components/dashboard/sections/IdentitySection.vue'
import HistorySection from '@/components/dashboard/sections/HistorySection.vue'
import BalanceSection from '@/components/dashboard/sections/BalanceSection.vue'
import SupportSection from '@/components/dashboard/sections/SupportSection.vue'

export default {
  name: 'Dashboard',
  components: {
    Sidebar,
    PageLoader,
    AccountSection,
    PrivacySection,
    SecuritySection,
    IdentitySection,
    HistorySection,
    BalanceSection,
    SupportSection
  },
  setup() {
    const store = useStore()
    const loading = ref(true)
    const activeSection = ref('account')

    const user = computed(() => store.getters['auth/user'])

    const sectionComponents = {
      account: 'AccountSection',
      privacy: 'PrivacySection',
      security: 'SecuritySection',
      notifications: 'IdentitySection', // Identity section
      history: 'HistorySection',
      balance: 'BalanceSection',
      support: 'SupportSection'
    }

    const currentSectionComponent = computed(() => {
      return sectionComponents[activeSection.value] || 'AccountSection'
    })

    const handleSectionChange = (section) => {
      activeSection.value = section
    }

    const handleUserUpdate = (updatedUser) => {
      store.dispatch('auth/updateUser', updatedUser)
    }

    onMounted(async () => {
      try {
        await store.dispatch('auth/fetchUser')
        setTimeout(() => {
          loading.value = false
        }, 1000) // Simulate loading time
      } catch (error) {
        console.error('Failed to load user data:', error)
        loading.value = false
      }
    })

    return {
      loading,
      activeSection,
      currentSectionComponent,
      user,
      handleSectionChange,
      handleUserUpdate
    }
  }
}
</script>
