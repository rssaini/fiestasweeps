<template>
  <div class="content-section">
    <div class="content-header">
      <h1>Game History</h1>
      <p>View your recent gaming activity and results</p>
    </div>

    <div class="card-custom">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h2>Recent Games</h2>
        <button class="btn btn-sm btn-outline-light" @click="refreshHistory">
          <i class="fas fa-refresh me-1"></i>
          Refresh
        </button>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-dark table-striped">
            <thead>
              <tr>
                <th>Game</th>
                <th>Date</th>
                <th>Bet Amount</th>
                <th>Result</th>
                <th>Winnings</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="game in gameHistory" :key="game.id">
                <td>
                  <div class="d-flex align-items-center">
                    <img :src="game.icon" :alt="game.name" class="me-2" style="width: 24px; height: 24px;">
                    {{ game.name }}
                  </div>
                </td>
                <td>{{ formatDate(game.date) }}</td>
                <td>${{ game.betAmount }}</td>
                <td>
                  <span class="badge" :class="getResultBadgeClass(game.result)">
                    {{ game.result }}
                  </span>
                </td>
                <td class="fw-bold" :class="game.winnings > 0 ? 'text-success' : 'text-muted'">
                  ${{ game.winnings }}
                </td>
                <td>
                  <span class="badge" :class="getStatusBadgeClass(game.status)">
                    {{ game.status }}
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <nav aria-label="Game history pagination" class="mt-3">
          <ul class="pagination pagination-sm justify-content-center">
            <li class="page-item" :class="{ disabled: currentPage === 1 }">
              <a class="page-link" href="#" @click.prevent="changePage(currentPage - 1)">Previous</a>
            </li>
            <li
              v-for="page in totalPages"
              :key="page"
              class="page-item"
              :class="{ active: page === currentPage }"
            >
              <a class="page-link" href="#" @click.prevent="changePage(page)">{{ page }}</a>
            </li>
            <li class="page-item" :class="{ disabled: currentPage === totalPages }">
              <a class="page-link" href="#" @click.prevent="changePage(currentPage + 1)">Next</a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { toast } from '@/utils/toast'

export default {
  name: 'HistorySection',
  setup() {
    const gameHistory = ref([
      {
        id: 1,
        name: 'Slot Machine',
        icon: '/assets/slot-icon.png',
        date: new Date('2024-01-15'),
        betAmount: '10.00',
        result: 'Win',
        winnings: '25.00',
        status: 'Completed'
      },
      {
        id: 2,
        name: 'Blackjack',
        icon: '/assets/blackjack-icon.png',
        date: new Date('2024-01-14'),
        betAmount: '20.00',
        result: 'Loss',
        winnings: '0.00',
        status: 'Completed'
      },
      {
        id: 3,
        name: 'Roulette',
        icon: '/assets/roulette-icon.png',
        date: new Date('2024-01-14'),
        betAmount: '15.00',
        result: 'Win',
        winnings: '45.00',
        status: 'Completed'
      }
    ])

    const currentPage = ref(1)
    const totalPages = ref(1)

    const formatDate = (date) => {
      return new Intl.DateTimeFormat('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      }).format(date)
    }

    const getResultBadgeClass = (result) => {
      return result === 'Win' ? 'bg-success' : 'bg-danger'
    }

    const getStatusBadgeClass = (status) => {
      switch (status) {
        case 'Completed': return 'bg-success'
        case 'Pending': return 'bg-warning'
        case 'Failed': return 'bg-danger'
        default: return 'bg-secondary'
      }
    }

    const refreshHistory = async () => {
      try {
        // Simulate API call
        await new Promise(resolve => setTimeout(resolve, 1000))
        toast.success('Game history refreshed')
      } catch (error) {
        toast.error('Failed to refresh game history')
      }
    }

    const changePage = (page) => {
      if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page
        // Load data for new page
      }
    }

    return {
      gameHistory,
      currentPage,
      totalPages,
      formatDate,
      getResultBadgeClass,
      getStatusBadgeClass,
      refreshHistory,
      changePage
    }
  }
}
</script>
