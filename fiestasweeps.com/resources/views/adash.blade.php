<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Dashboard - Gaming Platform - Fiesta Sweeps</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('assets/favicon.ico') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/apple-touch-icon.png') }}" />
    <meta name="apple-mobile-web-app-title" content="Fiesta Sweeps" />
    <link rel="manifest" href="{{ asset('assets/site.webmanifest') }}" />
    <link rel="stylesheet" href="/css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pagination.js.org/dist/2.6.0/pagination.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <style>
        .paginationjs.paginationjs-theme-blue .paginationjs-pages li {
            border-color: #764ba2
        }

        .paginationjs.paginationjs-theme-blue .paginationjs-pages li>a {
            color: #764ba2
        }

        .paginationjs.paginationjs-theme-blue .paginationjs-pages li>a:hover {
            background: #e9f4fc
        }

        .paginationjs.paginationjs-theme-blue .paginationjs-pages li.active>a {
            background: #764ba2;
            color: #fff
        }

        .paginationjs.paginationjs-theme-blue .paginationjs-pages li.disabled>a:hover {
            background: 0 0
        }

        .paginationjs.paginationjs-theme-blue .paginationjs-go-input>input[type=text],.paginationjs.paginationjs-theme-blue .paginationjs-size-changer>select {
            border-color: #764ba2
        }

        .paginationjs.paginationjs-theme-blue .paginationjs-go-button>input[type=button] {
            background: #764ba2;
            border-color: #764ba2;
            color: #fff
        }

        .paginationjs.paginationjs-theme-blue .paginationjs-go-button>input[type=button]:hover {
            background-color: #764ba2
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Team Dashboard</h1>
            <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="float: right;">
                @csrf
                <button class="nav-tab" style="background: #ca4c4c;" type="submit">Logout</button>
            </form>
            <div class="team-info">
                <span class="user_"></span><span class="totalSupervisors"></span><span class="totalAgents"></span>
            </div>
        </div>

        <div class="alert">
            @if (session('status'))
                <div class="alert-message">
                    {{ session('status') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert-message error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Navigation Tabs -->
        <div class="nav-tabs">
            <button class="nav-tab active" onclick="showTab('overview')">Overview</button>
            <button class="nav-tab" onclick="showTab('transactions'); loadTransactions();">Transactions</button>
            <button class="nav-tab" onclick="showTab('cashouts'); loadCashouts();">Cashouts</button>
            <button class="nav-tab" onclick="showTab('payment-methods'); loadHandles();">Payment Methods</button>
            @if ($user->hasRole('Admin'))
                <button class="nav-tab" onclick="showTab('games'); loadGames();">Games</button>
                <button class="nav-tab" onclick="showTab('supervisors'); loadSupervisors();">Supervisors</button>
            @endif
            @if ($user->hasRole('Supervisor') || $user->hasRole('Admin'))
                <button class="nav-tab" onclick="showTab('agents'); loadAgents();">Agents</button>
            @endif
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
                            <th>Payment Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                <div style="display: flex; align-items: center;">
                    <div class="form-group" style="width: 300px;margin:0;margin-right: 10px;">
                        <input type="text" id="daterange_transaction" />
                    </div>
                    <button onclick="exportTransactions()" class="btn-primary">🡅 Export</button>
                </div>
                <div class="pagination-container"></div>
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
                            <th>Status</th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                <div style="display: flex; align-items: center;">
                    <div class="form-group" style="width: 300px;margin:0;margin-right: 10px;">
                        <input type="text" id="daterange_cashout" />
                    </div>
                    <button onclick="exportCashouts()" class="btn-primary">🡅 Export</button>
                </div>
                <div class="pagination-container"></div>
            </div>
        </div>

        <!-- Payment Methods Tab -->
        <div id="payment-methods" class="tab-content">
            <div class="section-header">
                <h2>All Payment Handles</h2>
                @if($user->hasRole('Admin'))
                    <button class="btn-primary" onclick="openModal('paymentModal')">+ New Payment Handle</button>
                @endif
            </div>
            <div class="payment-methods-grid" style="display: flex; flex-direction:column; gap: 20px;">
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Gateway</th>
                                <th>Ac Name</th>
                                <th>Handle</th>
                                <th>Description</th>
                                <th>Status</th>
                                @if($user->hasRole('Admin'))
                                <th>Supervisor</th>
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody></tbody>
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
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
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
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
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
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            @if($user->hasRole('Admin'))
                                <th>Supervisor</th>
                            @endif
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
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
            <form class="modal-form transactionCreateForm" method="POST" action="{{ route('createTransaction') }}">
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
                    <label>Amount</label>
                    <input type="number" name="amount" step="0.01" min="0" required>
                </div>
                <div class="form-group">
                    <label>Payment Handle</label>
                    <select class="selectPaymentHandles" name="payment_handle" required></select>
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
            <form class="modal-form cashoutCreateForm" method="POST" action="{{ route('createTransaction') }}">
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
                    <select class="selectPaymentHandles" name="deposit_handle_id" required></select>
                </div>
                <div class="form-group">
                    <label>Payout Method</label>
                    <select class="selectPaymentHandles" name="payment_handle" required></select>
                </div>
                <div class="form-group">
                    <label>Player Payment Handle</label>
                    <input type="text" name="player_handle" required>
                </div>
                <div class="form-group">
                    <label>Amount</label>
                    <input type="number" name="amount" step="0.01" min="0" required>
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
                <form class="modal-form supervisorform" method="POST" action="{{ route('supervisors.store') }}">
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
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="1">Active</option>
                            <option value="0">InActive</option>
                        </select>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn-secondary"
                            onclick="closeModal('supervisorModal')">Cancel</button>
                        <button type="submit" class="btn-primary">Create Supervisor</button>
                    </div>
                </form>
            </div>
        </div>
        <div id="supervisorEditModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Edit Supervisor</h2>
                    <span class="close" onclick="closeModal('supervisorEditModal')">&times;</span>
                </div>
                <form class="modal-form supervisorform" method="PUT" action="{{ route('supervisors.update', '5') }}">
                    @csrf
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" readonly name="email">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password">
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" required>
                            <option value="1">Active</option>
                            <option value="0">InActive</option>
                        </select>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn-secondary"
                            onclick="closeModal('supervisorEditModal')">Cancel</button>
                        <button type="submit" class="btn-primary">Update Supervisor</button>
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
                <form class="modal-form gameForm" method="POST" action="{{ route('games.store') }}">
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
        <div id="gameEditModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Edit Game</h2>
                    <span class="close" onclick="closeModal('gameEditModal')">&times;</span>
                </div>
                <form class="modal-form gameForm" method="PUT" action="{{ route('games.update', '1') }}">
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
                            onclick="closeModal('gameEditModal')">Cancel</button>
                        <button type="submit" class="btn-primary">Update Game</button>
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
                <form class="modal-form paymentHandleForm" method="POST" action="{{ route('handles.store') }}">
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
        <div id="paymentEditModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Edit Payment Handle</h2>
                    <span class="close" onclick="closeModal('paymentEditModal')">&times;</span>
                </div>
                <form class="modal-form paymentHandleForm" method="PUT" action="{{ route('handles.update', '1') }}">
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
                        <label>Supervisor</label>
                        <select class="activeSupervisorSelect" name="supervisor" required></select>
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
                            onclick="closeModal('paymentEditModal')">Cancel</button>
                        <button type="submit" class="btn-primary">Update Payment Handle</button>
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
                <form class="modal-form agentForm" method="POST" action="{{ route('agents.store') }}">
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
                        <select class="activeSupervisorSelect" name="parent_id" required></select>
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
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" required>
                            <option value="1">Active</option>
                            <option value="0">InActive</option>
                        </select>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn-secondary"
                            onclick="closeModal('agentModal')">Cancel</button>
                        <button type="submit" class="btn-primary">Create Agent</button>
                    </div>
                </form>

            </div>
        </div>
        <div id="agentEditModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Edit Agent</h2>
                    <span class="close" onclick="closeModal('agentEditModal')">&times;</span>
                </div>
                <form class="modal-form agentForm" method="PUT" action="{{ route('agents.update', '1') }}">
                    @csrf
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" readonly name="email" required>
                    </div>
                    @if ($user->hasRole('Admin'))
                    <div class="form-group">
                        <label>Supervisor</label>
                        <select class="activeSupervisorSelect" name="parent_id" required></select>
                    </div>
                    @endif
                    @if ($user->hasRole('Supervisor'))
                        <input type="hidden" name="parent_id" value="{{ $user->id }}">
                    @endif
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password">
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" required>
                            <option value="1">Active</option>
                            <option value="0">InActive</option>
                        </select>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn-secondary"
                            onclick="closeModal('agentEditModal')">Cancel</button>
                        <button type="submit" class="btn-primary">Update Agent</button>
                    </div>
                </form>

            </div>
        </div>


        <!-- Status Change Modal -->
        <div id="statusChangeModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Update Status</h2>
                    <span class="close" onclick="closeModal('statusChangeModal')">&times;</span>
                </div>
                <form class="modal-form statusUpdateForm" method="POST" action="{{ route('updateStatusTransaction') }}">
                    @csrf
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" required>
                            <option value="">Select Status</option>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                            <option value="failed">Failed</option>
                            <option value="review">Review</option>
                        </select>
                    </div>
                    <input type="hidden" name="id">
                    <div class="form-actions">
                        <button type="button" class="btn-secondary" onclick="closeModal('statusChangeModal')">Cancel</button>
                        <button type="submit" class="btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <script src="/js/script.js"></script>
    @if($user->hasRole('Admin'))
        <script src="/js/admin.js"></script>
    @endif
    @if($user->hasRole('Admin') || $user->hasRole('Supervisor'))
        <script src="/js/admin_supervisor.js"></script>
    @endif
    @if($user->hasRole('Supervisor'))
        <script src="/js/supervisor.js"></script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.all.min.js"></script>
    <script src="https://pagination.js.org/dist/2.6.0/pagination.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment-timezone@0.5.40/builds/moment-timezone-with-data.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        var user = null;
    </script>
</body>

</html>
