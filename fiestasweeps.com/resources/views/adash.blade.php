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
            @if ($user->hasRole('Admin'))
                <div class="team-info">
                <span>Admin</span> | <span>{{ count($supervisors)}} Active Supervisors</span> | <span>{{ count($agents)}} Active Agents</span>
            </div>
            @endif

            @if ($user->hasRole('Supervisor'))
            <div class="team-info">
                <span>{{ $user->name }}</span> | <span>5 Active Agents</span>
            </div>
            @endif
            <div class="team-info">
                {{ $user->id }} | {{ $user->name }} | {{ $user->email }} | {{ $user->getRoleNames()->first() }}
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="nav-tabs">
            <button class="nav-tab active" onclick="showTab('overview')">Overview</button>
            <button class="nav-tab" onclick="showTab('transactions')">Transactions</button>
            <button class="nav-tab" onclick="showTab('cashouts')">Cashouts</button>
            <button class="nav-tab" onclick="showTab('payment-methods')">Payment Methods</button>
            @if ($user->hasRole('Admin'))
                <button class="nav-tab" onclick="showTab('games')">Games</button>
                <button class="nav-tab" onclick="showTab('supervisors')">Supervisors</button>
            @endif
            @if ($user->hasRole('Supervisor') || $user->hasRole('Admin'))
                <button class="nav-tab" onclick="showTab('agents')">Agents</button>
            @endif
            <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="nav-tab" type="submit">Logout</button>
            </form>
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
                <h2>All Payment Method Handles</h2>
                <button class="btn-primary" onclick="openModal('paymentModal')">+ New Payment Handle</button>
            </div>
            <div class="payment-methods-grid" style="display: flex; flex-direction:column; gap: 20px;">
                {{-- Loop through payment gateways --}}
                @if($gateways)
                    @foreach ($gateways as $gateway)
                    <div class="payment-method-card">
                        <div class="payment-icon">💳</div>
                        <h3>{{ $gateway->name }}</h3>
                        <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Ac Name</th>
                                    <th>Handle</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Daily Limit</th>
                                    <th>Supervisor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gateway->handles as $handle)
                                <tr>
                                    <td>{{ $handle->account_name }}</td>
                                    <td>{{ $handle->account_handle }}</td>
                                    <td>{{ $handle->description }}</td>
                                    <td><span class="status-{{ $handle->status }}">{{ ucfirst($handle->status) }}</span></td>
                                    <td>${{ number_format($handle->daily_limit, 2) }}</td>
                                    <td>
                                        @php
                                            $assigned = $handle->users->count() > 0 ? $handle->users->first()->id : null;
                                        @endphp
                                        <select onchange="asignUserToHandle({{ $handle->id }}, this.value)">
                                            <option value="">Select Supervisor</option>
                                            @foreach ($supervisors as $supervisor)
                                                <option value="{{ $supervisor->id }}" {{ $assigned === $supervisor->id ? 'selected' : '' }}>{{ $supervisor->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                    @endforeach
                @endif
                {{--
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
                --}}
            </div>
        </div>

        @if ($user->hasRole('Admin'))
        <!-- Supervisors Tab -->
        <div id="supervisors" class="tab-content">
            <div class="section-header">
                <h2>Supervisors</h2>
                <button class="btn-primary" onclick="openModal('supervisorModal')">+ New Supervisor</button>
            </div>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($supervisors as $supervisor)
                            <tr>
                                <td>{{ $supervisor->name }}</td>
                                <td>{{ $supervisor->email }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <!-- Games Tab -->
        <div id="games" class="tab-content">
            <div class="section-header">
                <h2>Games</h2>
                <button class="btn-primary" onclick="openModal('gameModal')">+ New Game</button>
            </div>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($games as $game)
                            <tr>
                                <td>{{ $game->name }}</td>
                                <td>{{ $game->description }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        @endif

        @if ($user->hasRole('Admin') || $user->hasRole('Supervisor'))
        <!-- Agents Tab -->
        <div id="agents" class="tab-content">
            <div class="section-header">
                <h2>Agents</h2>
                <button class="btn-primary" onclick="openModal('agentModal')">+ New Agent</button>
            </div>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            @if ($user->hasRole('Admin'))
                                <th>Supervisor</th>
                            @endif
                        </tr>
                    </thead>


                    <tbody>

                        @foreach ($agents as $agent)
                            <tr>
                                <td>{{ $agent->name }}</td>
                                <td>{{ $agent->email }}</td>
                                @if ($user->hasRole('Admin'))
                                <td>
                                    @if ($agent->parent)
                                        {{ $agent->parent->name }}
                                    @else
                                        No Supervisor
                                    @endif
                                </td>
                                @endif
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        @endif
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
                    <button type="button" class="btn-secondary"
                        onclick="closeModal('transactionModal')">Cancel</button>
                    <button type="submit" class="btn-primary">Create Transaction</button>
                </div>
            </form>
        </div>
    </div>

    @if ($user->hasRole('Admin'))
    <div id="supervisorModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>New Supervisor</h2>
                <span class="close" onclick="closeModal('supervisorModal')">&times;</span>
            </div>
            <form class="modal-form" method="POST" action="{{ route('admin.user.create') }}">
                @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" required>
                </div>
                <input type="hidden" name="parent_id" value="{{ $user->id }}">
                <input type="hidden" name="role" value="Supervisor">
                <div class="form-actions">
                    <button type="button" class="btn-secondary"
                        onclick="closeModal('supervisorModal')">Cancel</button>
                    <button type="submit" class="btn-primary">Create Supervisor</button>
                </div>
            </form>
        </div>
    </div>

    <div id="gameModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>New Game</h2>
                <span class="close" onclick="closeModal('gameModal')">&times;</span>
            </div>
            <form class="modal-form" method="POST" action="{{ route('game.create') }}">
                @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" name="description">
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-secondary"
                        onclick="closeModal('gameModal')">Cancel</button>
                    <button type="submit" class="btn-primary">Create Game</button>
                </div>
            </form>
        </div>
    </div>

    <div id="paymentModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>New Payment Handle</h2>
                <span class="close" onclick="closeModal('paymentModal')">&times;</span>
            </div>
            <form class="modal-form" method="POST" action="{{ route('paymentMethod.create') }}">
                @csrf
                <div class="form-group">
                    <label>Payment Method</label>
                    <select name="gateway_id" required>
                        <option value="">Select Method</option>
                        @foreach ($gateways as $gateway)
                            <option value="{{ $gateway->id }}">{{ $gateway->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Account Name</label>
                    <input type="text" name="account_name">
                </div>
                <div class="form-group">
                    <label>Account Handle</label>
                    <input type="text" name="account_handle" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" name="description">
                </div>
                <div class="form-group">
                    <label>Daily Limit</label>
                    <input type="number" name="daily_limit" step="0.01" min="0">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" required>
                        <option selected value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-secondary"
                        onclick="closeModal('paymentModal')">Cancel</button>
                    <button type="submit" class="btn-primary">Create Payment Handle</button>
                </div>
            </form>

        </div>
    </div>

    @endif

    @if ($user->hasRole('Admin') || $user->hasRole('Supervisor'))
    <div id="agentModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>New Agent</h2>
                <span class="close" onclick="closeModal('agentModal')">&times;</span>
            </div>
            <form class="modal-form" method="POST" action="{{ route('admin.user.create') }}">
                @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                @if ($user->hasRole('Admin'))
                <div class="form-group">
                    <label>Supervisor</label>
                    <select name="parent_id" required>
                        <option value="">Select Supervisor</option>
                        @foreach ($supervisors as $supervisor)
                            <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                @if ($user->hasRole('Supervisor'))
                    <input type="hidden" name="parent_id" value="{{ $user->id }}">
                @endif
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" required>
                </div>
                <input type="hidden" name="role" value="Agent">
                <div class="form-actions">
                    <button type="button" class="btn-secondary"
                        onclick="closeModal('agentModal')">Cancel</button>
                    <button type="submit" class="btn-primary">Create Agent</button>
                </div>
            </form>

        </div>
    </div>
    @endif



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
                    <input type="number" id="lastDeposit" name="lastDeposit" step="0.01" min="0"
                        required>
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

        function asignUserToHandle(handleId, userId) {
            if (userId) {
                fetch(`/update-user-handle?handle_id=${handleId}&user_id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert('Supervisor assigned successfully!');
                    } else {
                        alert('Error assigning supervisor.');
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
    </script>
</body>

</html>
