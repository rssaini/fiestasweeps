<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Dashboard - Gaming Platform</title>
    <link rel="stylesheet" href="/css/admindashboard.css">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Team Dashboard</h1>
            <div class="team-info">
                <span>Team Alpha</span> | <span>5 Active Agents</span> | <span>Last Updated: Today, 2:30 PM</span>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="nav-tabs">
            <button class="nav-tab active" onclick="showTab('overview')">Overview</button>
            <button class="nav-tab" onclick="showTab('transactions')">Transactions</button>
            <button class="nav-tab" onclick="showTab('cashouts')">Cashouts</button>
            <button class="nav-tab" onclick="showTab('payment-methods')">Payment Methods</button>
        </div>

        <!-- Overview Tab -->
        <div id="overview" class="tab-content active">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">💰</div>
                    <div class="stat-info">
                        <h3>Total Deposits</h3>
                        <p class="stat-value">$125,430</p>
                        <span class="stat-change positive">+12.5% from last week</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">📤</div>
                    <div class="stat-info">
                        <h3>Total Cashouts</h3>
                        <p class="stat-value">$98,250</p>
                        <span class="stat-change positive">+8.3% from last week</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-info">
                        <h3>Active Players</h3>
                        <p class="stat-value">247</p>
                        <span class="stat-change negative">-2.1% from last week</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">⚡</div>
                    <div class="stat-info">
                        <h3>Pending Transactions</h3>
                        <p class="stat-value">12</p>
                        <span class="stat-change neutral">No change</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transactions Tab -->
        <div id="transactions" class="tab-content">
            <div class="section-header">
                <h2>Transactions</h2>
                <button class="btn-primary" onclick="openModal('transactionModal')">+ New Transaction</button>
            </div>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Player ID</th>
                            <th>Game</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Player Handle</th>
                            <th>Points Value</th>
                            <th>Date</th>
                            <th>Payment Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>PLY001</td>
                            <td>Texas Hold'em</td>
                            <td>$250.00</td>
                            <td>Credit Card</td>
                            <td>@pokerking92</td>
                            <td>2,500</td>
                            <td>2025-06-09 14:30</td>
                            <td><span class="status completed">Completed</span></td>
                        </tr>
                        <tr>
                            <td>PLY002</td>
                            <td>Blackjack</td>
                            <td>$100.00</td>
                            <td>PayPal</td>
                            <td>@cardshark</td>
                            <td>1,000</td>
                            <td>2025-06-09 13:15</td>
                            <td><span class="status pending">Pending</span></td>
                        </tr>
                        <tr>
                            <td>PLY003</td>
                            <td>Slots</td>
                            <td>$50.00</td>
                            <td>Crypto</td>
                            <td>@luckyslots</td>
                            <td>500</td>
                            <td>2025-06-09 12:45</td>
                            <td><span class="status completed">Completed</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Cashouts Tab -->
        <div id="cashouts" class="tab-content">
            <div class="section-header">
                <h2>Cashouts</h2>
                <button class="btn-primary" onclick="openModal('cashoutModal')">+ New Cashout</button>
            </div>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Player ID</th>
                            <th>Game</th>
                            <th>Last Deposit</th>
                            <th>Deposit Method</th>
                            <th>Payout Method</th>
                            <th>Player Payment Handle</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>PLY001</td>
                            <td>Texas Hold'em</td>
                            <td>$250.00</td>
                            <td>Credit Card</td>
                            <td>Bank Transfer</td>
                            <td>****1234</td>
                            <td>$420.00</td>
                            <td>2025-06-09 15:20</td>
                            <td><span class="status processing">Processing</span></td>
                        </tr>
                        <tr>
                            <td>PLY004</td>
                            <td>Roulette</td>
                            <td>$150.00</td>
                            <td>PayPal</td>
                            <td>PayPal</td>
                            <td>winner@email.com</td>
                            <td>$300.00</td>
                            <td>2025-06-09 14:10</td>
                            <td><span class="status completed">Completed</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Payment Methods Tab -->
        <div id="payment-methods" class="tab-content">
            <div class="section-header">
                <h2>Current Payment Method Handles</h2>
            </div>
            <div class="payment-methods-grid">
                <div class="payment-method-card">
                    <div class="payment-icon">💳</div>
                    <h3>Credit Cards</h3>
                    <div class="method-details">
                        <p><strong>Processor:</strong> Stripe</p>
                        <p><strong>Status:</strong> <span class="status-active">Active</span></p>
                        <p><strong>Daily Limit:</strong> $10,000</p>
                    </div>
                </div>
                <div class="payment-method-card">
                    <div class="payment-icon">🏦</div>
                    <h3>Bank Transfers</h3>
                    <div class="method-details">
                        <p><strong>Processor:</strong> ACH Network</p>
                        <p><strong>Status:</strong> <span class="status-active">Active</span></p>
                        <p><strong>Daily Limit:</strong> $25,000</p>
                    </div>
                </div>
                <div class="payment-method-card">
                    <div class="payment-icon">📱</div>
                    <h3>PayPal</h3>
                    <div class="method-details">
                        <p><strong>Account:</strong> team-alpha@platform.com</p>
                        <p><strong>Status:</strong> <span class="status-active">Active</span></p>
                        <p><strong>Daily Limit:</strong> $5,000</p>
                    </div>
                </div>
                <div class="payment-method-card">
                    <div class="payment-icon">₿</div>
                    <h3>Cryptocurrency</h3>
                    <div class="method-details">
                        <p><strong>Wallet:</strong> BitPay</p>
                        <p><strong>Status:</strong> <span class="status-maintenance">Maintenance</span></p>
                        <p><strong>Daily Limit:</strong> $15,000</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Modal -->
    <div id="transactionModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>New Transaction</h2>
                <span class="close" onclick="closeModal('transactionModal')">&times;</span>
            </div>
            <form class="modal-form">
                <div class="form-group">
                    <label for="playerID">Player ID</label>
                    <input type="text" id="playerID" name="playerID" required>
                </div>
                <div class="form-group">
                    <label for="game">Game</label>
                    <select id="game" name="game" required>
                        <option value="">Select Game</option>
                        <option value="texas-holdem">Texas Hold'em</option>
                        <option value="blackjack">Blackjack</option>
                        <option value="roulette">Roulette</option>
                        <option value="slots">Slots</option>
                        <option value="baccarat">Baccarat</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="number" id="amount" name="amount" step="0.01" min="0" required>
                </div>
                <div class="form-group">
                    <label for="paymentMethod">Payment Method</label>
                    <select id="paymentMethod" name="paymentMethod" required>
                        <option value="">Select Payment Method</option>
                        <option value="credit-card">Credit Card</option>
                        <option value="bank-transfer">Bank Transfer</option>
                        <option value="paypal">PayPal</option>
                        <option value="crypto">Cryptocurrency</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="playerHandle">Player's Handle</label>
                    <input type="text" id="playerHandle" name="playerHandle" required>
                </div>
                <div class="form-group">
                    <label for="pointsValue">Points Value</label>
                    <input type="number" id="pointsValue" name="pointsValue" min="0" required>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-secondary" onclick="closeModal('transactionModal')">Cancel</button>
                    <button type="submit" class="btn-primary">Create Transaction</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Cashout Modal -->
    <div id="cashoutModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>New Cashout</h2>
                <span class="close" onclick="closeModal('cashoutModal')">&times;</span>
            </div>
            <form class="modal-form">
                <div class="form-group">
                    <label for="cashoutPlayerID">Player ID</label>
                    <input type="text" id="cashoutPlayerID" name="playerID" required>
                </div>
                <div class="form-group">
                    <label for="cashoutGame">Game</label>
                    <select id="cashoutGame" name="game" required>
                        <option value="">Select Game</option>
                        <option value="texas-holdem">Texas Hold'em</option>
                        <option value="blackjack">Blackjack</option>
                        <option value="roulette">Roulette</option>
                        <option value="slots">Slots</option>
                        <option value="baccarat">Baccarat</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="lastDeposit">Last Deposit</label>
                    <input type="number" id="lastDeposit" name="lastDeposit" step="0.01" min="0" required>
                </div>
                <div class="form-group">
                    <label for="depositMethod">Deposit Method</label>
                    <select id="depositMethod" name="depositMethod" required>
                        <option value="">Select Deposit Method</option>
                        <option value="credit-card">Credit Card</option>
                        <option value="bank-transfer">Bank Transfer</option>
                        <option value="paypal">PayPal</option>
                        <option value="crypto">Cryptocurrency</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="payoutMethod">Payout Method</label>
                    <select id="payoutMethod" name="payoutMethod" required>
                        <option value="">Select Payout Method</option>
                        <option value="bank-transfer">Bank Transfer</option>
                        <option value="paypal">PayPal</option>
                        <option value="crypto">Cryptocurrency</option>
                        <option value="check">Check</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="playerPaymentHandle">Player Payment Handle</label>
                    <input type="text" id="playerPaymentHandle" name="playerPaymentHandle" required>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-secondary" onclick="closeModal('cashoutModal')">Cancel</button>
                    <button type="submit" class="btn-primary">Process Cashout</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Tab switching functionality
        function showTab(tabName) {
            // Hide all tab contents
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(tab => tab.classList.remove('active'));

            // Remove active class from all nav tabs
            const navTabs = document.querySelectorAll('.nav-tab');
            navTabs.forEach(tab => tab.classList.remove('active'));

            // Show selected tab content
            document.getElementById(tabName).classList.add('active');

            // Add active class to clicked nav tab
            event.target.classList.add('active');
        }

        // Modal functionality
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        }

        // Form submission handlers
        document.querySelector('#transactionModal form').addEventListener('submit', function(e) {
            e.preventDefault();
            // Add your form submission logic here
            alert('Transaction created successfully!');
            closeModal('transactionModal');
        });

        document.querySelector('#cashoutModal form').addEventListener('submit', function(e) {
            e.preventDefault();
            // Add your form submission logic here
            alert('Cashout processed successfully!');
            closeModal('cashoutModal');
        });
    </script>
</body>
</html>
