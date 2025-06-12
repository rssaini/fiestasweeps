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
                            <th>Created By</th>
                            <th>Updated By</th>
                            <th>Date</th>
                            <th>Payment Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->player_id }}</td>
                            <td>{{ $transaction->game->name }}</td>
                            <td>${{ number_format($transaction->amount, 2) }}</td>
                            <td>{{ $transaction->handle->gateway->name }} ({{ $transaction->handle->account_handle }})</td>
                            <td>{{ $transaction->player_handle }}</td>
                            <td>{{ $transaction->points }}</td>
                            <td>{{ $transaction->createdBy ? $transaction->createdBy->name . ' ('. $transaction->createdBy->getRoleNames()->first() .')' : 'N/A' }}</td>
                            <td>{{ $transaction->updatedBy ? $transaction->updatedBy->name . ' ('. $transaction->updatedBy->getRoleNames()->first() .')' : 'N/A' }}</td>
                            <td>{{ $transaction->created_at }}</td>
                            <td><span class="status {{ $transaction->status }}">{{ ucfirst($transaction->status) }}</span></td>
                        </tr>
                        @endforeach
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
                            <th>Created By</th>
                            <th>Updated By</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cashouts as $cashout)
                        <tr>
                            <td>{{ $cashout->player_id }}</td>
                            <td>{{ $cashout->game->name }}</td>
                            <td>${{ number_format($cashout->last_deposit, 2) }}</td>
                            <td>{{ $cashout->depositHandle->gateway->name }} ({{ $cashout->depositHandle->account_handle }})</td>
                            <td>{{ $cashout->handle->gateway->name }} ({{ $cashout->handle->account_handle }})</td>
                            <td>{{ $cashout->player_handle }}</td>
                            <td>${{ number_format($cashout->amount, 2) }}</td>
                            <td>{{ $cashout->createdBy ? $cashout->createdBy->name . ' ('. $cashout->createdBy->getRoleNames()->first() .')' : 'N/A' }}</td>
                            <td>{{ $cashout->updatedBy ? $cashout->updatedBy->name . ' ('. $cashout->updatedBy->getRoleNames()->first() .')' : 'N/A' }}</td>
                            <td>{{ $cashout->created_at }}</td>
                            <td><span class="status {{ $cashout->status }}">{{ ucfirst($cashout->status) }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Payment Methods Tab -->
        <div id="payment-methods" class="tab-content">
            <div class="section-header">
                <h2>All Payment Method Handles</h2>
                @if($user->hasRole('Admin'))
                    <button class="btn-primary" onclick="openModal('paymentModal')">+ New Payment Handle</button>
                @endif
            </div>
            <div class="payment-methods-grid" style="display: flex; flex-direction:column; gap: 20px;">
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Gateway</th>
                                <th>Ac Name</th>
                                <th>Handle</th>
                                <th>Description</th>
                                <th>Status</th>
                                @if($user->hasRole('Admin'))
                                    <th>Supervisor</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paymentHandles as $handle)
                            <tr>
                                <td>{{ $handle->gateway->name }}</td>
                                <td>{{ $handle->account_name }}</td>
                                <td>{{ $handle->account_handle }}</td>
                                <td>{{ $handle->description }}</td>
                                <td><span class="status-{{ $handle->status }}">{{ ucfirst($handle->status) }}</span></td>
                                @if($user->hasRole('Admin'))
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
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
            <form class="modal-form" method="POST" action="{{ route('createTransaction') }}">
                @csrf
                <div class="form-group">
                    <label for="playerID">Player ID</label>
                    <input type="text" id="playerID" name="player_id" required>
                </div>
                <div class="form-group">
                    <label>Game</label>
                    <select name="game_id" required>
                        <option value="">Select Game</option>
                        @foreach ($games as $game)
                            <option value="{{ $game->id }}">{{ $game->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="number" id="amount" name="amount" step="0.01" min="0" required>
                </div>
                <div class="form-group">
                    <label>Payment Handle</label>
                    <select name="payment_handle" required>
                        <option value="">Select Payment Handle</option>
                        @foreach ($paymentHandles as $handle)
                            <option value="{{ $handle->id }}">{{ $handle->gateway->name }} ({{ $handle->account_handle }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="playerHandle">Player's Handle</label>
                    <input type="text" id="playerHandle" name="player_handle" required>
                </div>
                <div class="form-group">
                    <label for="pointsValue">Points Value</label>
                    <input type="number" id="pointsValue" name="points" min="0" required>
                </div>
                <input type="hidden" name="transaction_type" value="deposit">
                <div class="form-actions">
                    <button type="button" class="btn-secondary"
                        onclick="closeModal('transactionModal')">Cancel</button>
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
            <form class="modal-form" method="POST" action="{{ route('createTransaction') }}">
                @csrf
                <div class="form-group">
                    <label>Player ID</label>
                    <input type="text" name="player_id" required>
                </div>
                <div class="form-group">
                    <label>Game</label>
                    <select name="game_id" required>
                        <option value="">Select Game</option>
                        @foreach ($games as $game)
                            <option value="{{ $game->id }}">{{ $game->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Last Deposit</label>
                    <input type="number" name="last_deposit" step="0.01" min="0"
                        required>
                </div>
                <div class="form-group">
                    <label>Deposit Method</label>
                    <select name="deposit_handle_id" required>
                        <option value="">Select Deposit Method</option>
                        @foreach ($paymentHandles as $handle)
                            <option value="{{ $handle->id }}">{{ $handle->account_name }} ({{ $handle->account_handle }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Payout Method</label>
                    <select name="payment_handle" required>
                        <option value="">Select Payout Method</option>
                        @foreach ($paymentHandles as $handle)
                            <option value="{{ $handle->id }}">{{ $handle->gateway->name }} ({{ $handle->account_handle }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Player Payment Handle</label>
                    <input type="text" name="player_handle" required>
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="number" id="amount" name="amount" step="0.01" min="0" required>
                </div>
                <input type="hidden" name="transaction_type" value="cashout">
                <input type="hidden" name="points" value="100">
                <div class="form-actions">
                    <button type="button" class="btn-secondary" onclick="closeModal('cashoutModal')">Cancel</button>
                    <button type="submit" class="btn-primary">Process Cashout</button>
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
                    <input type="hidden" name="daily_limit" value="1000">
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

        @if($user->hasRole('Admin'))
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
        @endif
    </script>
</body>

</html>
