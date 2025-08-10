<!-- src/components/dashboard/sections/IdentitySection.vue -->
<template>
  <div class="content-section">
    <div class="content-header">
      <h1>Identity Verification</h1>
      <p>Verify your identity to unlock full account features</p>
    </div>

    <div class="card-custom">
      <div class="card-header">
        <h2>Verification Status</h2>
      </div>
      <div class="card-body">
        <div class="row g-4">
          <div class="col-md-6" v-for="step in verificationSteps" :key="step.id">
            <div class="d-flex align-items-center p-3 border rounded">
              <div class="me-3">
                <i :class="step.icon" class="fs-4" :style="{ color: step.completed ? '#28a745' : '#6c757d' }"></i>
              </div>
              <div class="flex-grow-1">
                <h6 class="mb-1 text-light">{{ step.title }}</h6>
                <p class="mb-0 text-muted small">{{ step.description }}</p>
              </div>
              <div>
                <span class="badge" :class="step.completed ? 'bg-success' : 'bg-secondary'">
                  {{ step.completed ? 'Complete' : 'Pending' }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'

export default {
  name: 'IdentitySection',
  setup() {
    const verificationSteps = ref([
      {
        id: 1,
        title: 'Email Verification',
        description: 'Confirm your email address',
        icon: 'fas fa-envelope',
        completed: true
      },
      {
        id: 2,
        title: 'Phone Verification',
        description: 'Verify your phone number',
        icon: 'fas fa-phone',
        completed: false
      },
      {
        id: 3,
        title: 'ID Verification',
        description: 'Upload government ID',
        icon: 'fas fa-id-card',
        completed: false
      },
      {
        id: 4,
        title: 'Address Verification',
        description: 'Confirm your address',
        icon: 'fas fa-home',
        completed: false
      }
    ])

    return {
      verificationSteps
    }
  }
}
</script>
