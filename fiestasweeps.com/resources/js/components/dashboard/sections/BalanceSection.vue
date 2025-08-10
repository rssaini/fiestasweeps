<template>
  <div class="content-section">
    <div class="content-header">
      <h1>Account Balance</h1>
      <p>View your current balance and transaction history</p>
    </div>

    <!-- Balance Stats -->
    <div class="stats-grid mb-4">
      <div class="col-md-4" v-for="stat in balanceStats" :key="stat.label">
        <div class="stat-card-custom">
          <div class="stat-number">${{ stat.value }}</div>
          <div class="stat-label">{{ stat.label }}</div>
        </div>
      </div>
    </div>

    <!-- Add Funds Card -->
    <div class="card-custom">
      <div class="card-header">
        <h2>Add Funds</h2>
      </div>
      <div class="card-body">
        <form @submit.prevent="addFunds">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="amount" class="form-label fw-bold text-uppercase text-light">
                Amount
              </label>
              <div class="input-group">
                <span class="input-group-text">$</span>
                <input
                  type="number"
                  id="amount"
                  v-model="fundForm.amount"
                  class="form-control-custom"
                  placeholder="Enter amount"
                  min="10"
                  step="0.01"
                  required
                >
              </div>
            </div>
            <div class="col-md-6">
              <label for="paymentMethod" class="form-label fw-bold text-uppercase text-light">
                Payment Method
              </label>
              <select
                id="paymentMethod"
                v-model="fundForm.paymentMethod"
                class="form-control-custom"
                required
              >
                <option value="">Select Payment Method</option>
                <option value="credit_card">Credit Card</option>
                <option value="paypal">PayPal</option>
                <option value="bank_transfer">Bank Transfer</option>
              </select>
            </div>
          </div>

          <div class="mt-4">
            <button type="submit" class="btn-primary-custom" :disabled="fundLoading">
              <span v-if="fundLoading" class="spinner-border spinner-border-sm me-2"></span>
              Add Funds
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, reactive } from 'vue'
import { useStore } from 'vuex'
import { toast } from '@/utils/toast'

export default {
  name: 'BalanceSection',
  props: {
    user: {
      type: Object,
      required: true
    }
  },
  setup() {
    const store = useStore()

    const fundLoading = ref(false)

    const balanceStats = ref([
      { label: 'Current Balance', value: '47.50' },
      { label: 'Total Deposited', value: '250.00' },
      { label: 'Total Winnings', value: '125.75' }
    ])

    const fundForm = reactive({
      amount: '',
      paymentMethod: ''
    })

    const addFunds = async () => {
      fundLoading.value = true
      try {
        // This would integrate with your payment processing
        await new Promise(resolve => setTimeout(resolve, 2000)) // Simulate API call

        toast.success(`Successfully added ${fundForm.amount} to your account`)

        // Reset form
        fundForm.amount = ''
        fundForm.paymentMethod = ''

        // Update balance stats (this would come from API response)
        const currentBalance = parseFloat(balanceStats.value[0].value)
        const addedAmount = parseFloat(fundForm.amount)
        balanceStats.value[0].value = (currentBalance + addedAmount).toFixed(2)

      } catch (error) {
        toast.error('Failed to add funds. Please try again.')
      } finally {
        fundLoading.value = false
      }
    }

    return {
      balanceStats,
      fundForm,
      fundLoading,
      addFunds
    }
  }
}
</script>
