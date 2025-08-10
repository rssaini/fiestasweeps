<template>
  <div class="page-loader" :class="{ 'd-none': !visible }">
    <div class="loader-content">
      <div class="spinner-custom" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <div class="loader-text">{{ loadingText }}</div>
      <div class="progress mt-3" style="height: 6px;">
        <div
          class="progress-bar bg-danger"
          :style="{ width: progress + '%' }"
          role="progressbar"
        ></div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue'

export default {
  name: 'PageLoader',
  props: {
    visible: {
      type: Boolean,
      default: true
    }
  },
  setup() {
    const progress = ref(0)
    const loadingText = ref('Loading Dashboard...')
    const interval = ref(null)

    const loadingMessages = [
      'Loading Dashboard...',
      'Fetching User Data...',
      'Preparing Interface...',
      'Almost Ready...'
    ]

    onMounted(() => {
      let messageIndex = 0
      interval.value = setInterval(() => {
        progress.value += 25
        if (messageIndex < loadingMessages.length - 1) {
          loadingText.value = loadingMessages[++messageIndex]
        }
        if (progress.value >= 100) {
          clearInterval(interval.value)
        }
      }, 250)
    })

    onUnmounted(() => {
      if (interval.value) {
        clearInterval(interval.value)
      }
    })

    return {
      progress,
      loadingText
    }
  }
}
</script>
