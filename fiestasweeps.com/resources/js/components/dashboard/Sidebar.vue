<template>
  <aside class="sidebar-custom">
    <div class="sidebar-header">
      <div class="user-avatar mb-3">
        <img
          src=""
          alt="User Avatar"
          class="rounded-circle"
          style="width: 80px; height: 80px;"
        >
      </div>
      <h2>Dashboard</h2>
      <p>Welcome back, {{ user?.name }}!</p>
    </div>

    <nav class="sidebar-menu">
      <a
        v-for="item in menuItems"
        :key="item.key"
        href="#"
        class="nav-link"
        :class="{ active: activeSection === item.key }"
        @click.prevent="$emit('section-change', item.key)"
      >
        <i :class="item.icon" class="me-2"></i>
        {{ item.label }}
      </a>
    </nav>
  </aside>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'

export default {
  name: 'DashboardSidebar',
  props: {
    activeSection: {
      type: String,
      default: 'account'
    }
  },
  emits: ['section-change'],
  setup() {
    const store = useStore()
    const user = computed(() => store.getters['auth/user'])

    const menuItems = [
      { key: 'account', label: 'Account', icon: 'fas fa-user' },
      { key: 'privacy', label: 'Privacy', icon: 'fas fa-shield-alt' },
      { key: 'security', label: 'Security', icon: 'fas fa-lock' },
      { key: 'notifications', label: 'Identity', icon: 'fas fa-id-card' },
      { key: 'gameplay', label: 'Gameplay', icon: 'fas fa-gamepad' },
      { key: 'history', label: 'Game History', icon: 'fas fa-history' },
      { key: 'balance', label: 'Balance', icon: 'fas fa-wallet' },
      { key: 'support', label: 'Support', icon: 'fas fa-life-ring' }
    ]

    return {
      user,
      menuItems
    }
  }
}
</script>
