<!-- src/components/dashboard/sections/SupportSection.vue -->
<template>
  <div class="content-section">
    <div class="content-header">
      <h1>Support</h1>
      <p>Get help with your account and gaming experience</p>
    </div>

    <div class="row g-4">
      <div class="col-md-6">
        <div class="card-custom">
          <div class="card-header">
            <h2>Contact Support</h2>
          </div>
          <div class="card-body">
            <form @submit.prevent="submitSupportTicket">
              <div class="mb-3">
                <label class="form-label fw-bold text-uppercase text-light">
                  Subject
                </label>
                <select v-model="supportForm.subject" class="form-control-custom" required>
                  <option value="">Select a topic</option>
                  <option value="account">Account Issues</option>
                  <option value="payment">Payment Problems</option>
                  <option value="technical">Technical Support</option>
                  <option value="general">General Inquiry</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label fw-bold text-uppercase text-light">
                  Message
                </label>
                <textarea
                  v-model="supportForm.message"
                  class="form-control-custom"
                  rows="5"
                  placeholder="Describe your issue..."
                  required
                ></textarea>
              </div>
              <button type="submit" class="btn-primary-custom">
                Send Message
              </button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card-custom">
          <div class="card-header">
            <h2>Quick Help</h2>
          </div>
          <div class="card-body">
            <div class="list-group list-group-flush">
              <a href="#" class="list-group-item list-group-item-action bg-transparent text-light border-secondary">
                <i class="fas fa-question-circle me-2"></i>
                Frequently Asked Questions
              </a>
              <a href="#" class="list-group-item list-group-item-action bg-transparent text-light border-secondary">
                <i class="fas fa-book me-2"></i>
                User Guide
              </a>
              <a href="#" class="list-group-item list-group-item-action bg-transparent text-light border-secondary">
                <i class="fas fa-comments me-2"></i>
                Live Chat
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { reactive } from 'vue'
import { toast } from '@/utils/toast'

export default {
  name: 'SupportSection',
  setup() {
    const supportForm = reactive({
      subject: '',
      message: ''
    })

    const submitSupportTicket = async () => {
      try {
        // Simulate API call
        await new Promise(resolve => setTimeout(resolve, 1000))
        toast.success('Support ticket submitted successfully!')
        supportForm.subject = ''
        supportForm.message = ''
      } catch (error) {
        toast.error('Failed to submit support ticket')
      }
    }

    return {
      supportForm,
      submitSupportTicket
    }
  }
}
</script>
