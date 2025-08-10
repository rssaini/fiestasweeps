<template>
  <div class="content-section">
    <div class="content-header">
      <h1>Privacy Settings</h1>
      <p>Control your privacy and data sharing preferences</p>
    </div>

    <div class="card-custom">
      <div class="card-header">
        <h2>Data & Privacy</h2>
      </div>
      <div class="card-body">
        <div class="d-flex flex-column gap-4">
          <div
            v-for="setting in privacySettings"
            :key="setting.key"
            class="d-flex justify-content-between align-items-center p-3 border-bottom"
          >
            <div>
              <label class="form-label text-light fw-bold mb-1">
                {{ setting.label }}
              </label>
              <div class="text-muted small">{{ setting.description }}</div>
            </div>
            <div class="form-check form-switch">
              <input
                class="form-check-input"
                type="checkbox"
                :id="setting.key"
                v-model="setting.value"
                @change="updatePrivacySetting(setting.key, setting.value)"
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, reactive, onMounted } from 'vue'
import { useStore } from 'vuex'
import { toast } from '@/utils/toast'

export default {
  name: 'PrivacySection',
  props: {
    user: {
      type: Object,
      required: true
    }
  },
  setup(props) {
    const store = useStore()

    const privacySettings = reactive([
      {
        key: 'game_stats',
        label: 'Share gameplay statistics',
        description: 'Allow your gaming statistics to be visible to other players',
        value: false
      },
      {
        key: 'marketting_stats',
        label: 'Allow marketing emails',
        description: 'Receive promotional emails and special offers',
        value: false
      },
      {
        key: 'online_stats',
        label: 'Show online status',
        description: 'Display when you are online to other players',
        value: false
      }
    ])

    const updatePrivacySetting = async (key, value) => {
      try {
        await store.dispatch('auth/updateUserSetting', {
          setting: key,
          value: value ? 1 : 0
        })
        toast.success('Privacy setting updated successfully!')
      } catch (error) {
        toast.error('Failed to update privacy setting')
        // Revert the change
        const setting = privacySettings.find(s => s.key === key)
        if (setting) {
          setting.value = !value
        }
      }
    }

    onMounted(() => {
      // Initialize settings from user data
      privacySettings.forEach(setting => {
        if (props.user && props.user[setting.key] !== undefined) {
          setting.value = props.user[setting.key] === 1 || props.user[setting.key] === '1'
        }
      })
    })

    return {
      privacySettings,
      updatePrivacySetting
    }
  }
}
</script>
