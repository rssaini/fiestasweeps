<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>Dashboard - Fiesta Sweeps</title>
    <link rel="stylesheet" href="/css/app.css" />
    <link rel="stylesheet" href="/css/dashboard.css" />
    <link rel="icon" type="image/png" href="{{ asset('assets/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('assets/favicon.ico') }}" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <style>
/* ===============================
   FULL PAGE LOADER STYLES
   =============================== */

.page-loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 999999;
    opacity: 1;
    visibility: visible;
    transition: all 0.3s ease;
}

.page-loader.hidden {
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
}

.loader-content {
    text-align: center;
    max-width: 300px;
}

/* Spinner Animation */
.spinner {
    width: 50px;
    height: 50px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3498db;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto;
}

.loader-text {
    margin-top: 20px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    font-size: 16px;
    color: #555;
    font-weight: 500;
}

/* Progress Bar */
.progress-container {
    margin-top: 20px;
}

.progress-bar {
    width: 200px;
    height: 4px;
    background: #e0e0e0;
    border-radius: 2px;
    overflow: hidden;
    margin: 0 auto;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #3498db, #2ecc71);
    width: 0%;
    transition: width 0.3s ease;
    border-radius: 2px;
}

.progress-percentage {
    margin-top: 10px;
    font-size: 14px;
    color: #777;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* Dark Theme */
.page-loader.dark {
    background: rgba(26, 32, 44, 0.95);
}

.page-loader.dark .spinner {
    border-color: #4a5568;
    border-top-color: #3182ce;
}

.page-loader.dark .loader-text {
    color: #e2e8f0;
}

.page-loader.dark .progress-percentage {
    color: #cbd5e0;
}

/* Animations */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Responsive */
@media (max-width: 480px) {
    .progress-bar {
        width: 150px;
    }

    .loader-text {
        font-size: 14px;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border-width: 3px;
    }
}
</style>
</head>
<body>
    <div id="pageLoader" class="page-loader hidden">
        <div class="loader-content">
            <div class="spinner"></div>
            <div class="loader-text" id="loaderText">Loading...</div>
            <div class="progress-container" id="progressContainer" style="display: none;">
                <div class="progress-bar">
                    <div class="progress-fill" id="progressFill"></div>
                </div>
                <div class="progress-percentage" id="progressPercentage">0%</div>
            </div>
        </div>
    </div>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <img src="assets/logo.png" alt="Fiesta Sweeps Logo" style="height: 80px;">
                </div>
                <h2>Dashboard</h2>
                <p>Welcome back, {{ auth()->user()->name }}!</p>
            </div>

            <nav class="sidebar-menu">
                <a href="#account" class="menu-item active" onclick="showSection('account')">Account</a>
                <a href="#privacy" class="menu-item" onclick="showSection('privacy')">Privacy</a>
                <a href="#security" class="menu-item" onclick="showSection('security')">Security</a>
                <a href="#notifications" class="menu-item" onclick="showSection('notifications')">Identity</a>
                <a href="#gameplay" class="menu-item" onclick="showSection('gameplay')">Gameplay</a>
                <a href="#history" class="menu-item" onclick="showSection('history')">Game History</a>
                <a href="#balance" class="menu-item" onclick="showSection('balance')">Balance</a>
                <a href="#support" class="menu-item" onclick="showSection('support')">Support</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Account Section -->
            <div id="account" class="content-section active">
                <div class="content-header">
                    <h1>Account Settings</h1>
                    <p>Manage your personal information and account preferences</p>
                </div>

                <div class="content-card">
                    <h2>Personal Information</h2>
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <input type="text" id="firstName" name="name" value="{{ auth()->user()->name }}">
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <input type="text" id="lastName" name="lname" value="{{auth()->user()->lname }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" readonly value="{{ auth()->user()->email }}">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" value="{{ auth()->user()->phone }}">
                        </div>
                        <div class="form-group">
                            <label for="birthdate">Date of Birth</label>
                            <input type="date" id="birthdate" name="dob" value="{{ auth()->user()->dob }}">
                        </div>
                        <button type="submit" class="cta-button">Save Changes</button>
                    </form>
                </div>
            </div>

            <!-- Privacy Section -->
            <div id="privacy" class="content-section">
                <div class="content-header">
                    <h1>Privacy Settings</h1>
                    <p>Control your privacy and data sharing preferences</p>
                </div>

                <div class="content-card">
                    <h2>Data & Privacy</h2>
                    <div class="toggle-group">
                        <div class="toggle-item">
                            <label>Share gameplay statistics</label>
                            <input onchange="updateStat('game_stats', this)" type="checkbox" class="toggle" {{ auth()->user()->game_stats == '1'  ? 'checked' : '' }}>
                        </div>
                        <div class="toggle-item">
                            <label>Allow marketing emails</label>
                            <input onchange="updateStat('marketting_stats', this)" type="checkbox" class="toggle" {{ auth()->user()->marketting_stats == '1' ? 'checked' : '' }}>
                        </div>
                        <div class="toggle-item">
                            <label>Show online status</label>
                            <input onchange="updateStat('online_stats', this)" type="checkbox" class="toggle" {{ auth()->user()->online_stats == '1' ? 'checked' : '' }}>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Section -->
            <div id="security" class="content-section">
                <div class="content-header">
                    <h1>Security</h1>
                    <p>Protect your account with security settings</p>
                </div>

                <div class="content-card">
                    <h2>Change Password</h2>
                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="currentPassword">Current Password</label>
                            <input type="password" name="pwd" id="currentPassword">
                        </div>
                        <div class="form-group">
                            <label for="newPassword">New Password</label>
                            <input type="password" name="npwd" id="newPassword">
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword">Confirm New Password</label>
                            <input type="password" name="npwd_confirmation" id="confirmPassword">
                        </div>
                        <button type="submit" class="cta-button">Update Password</button>
                    </form>
                </div>

                <div class="content-card">
                    <h2>Two-Factor Authentication</h2>
                    <p>Add an extra layer of security to your account</p>
                    <button class="register-button">Enable 2FA</button>
                </div>
            </div>

            <!-- Balance Section -->
            <div id="balance" class="content-section">
                <div class="content-header">
                    <h1>Account Balance</h1>
                    <p>View your current balance and transaction history</p>
                </div>

                <div class="stats-grid">
                    <div class="stat-card">
                        <span class="stat-number">{{ $user->current_balance }}</span>
                        <span class="stat-label">Current Balance</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-number">{{ $user->total_deposits }}</span>
                        <span class="stat-label">Total Deposited</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-number">{{ $user->total_winnings }}</span>
                        <span class="stat-label">Total Winnings</span>
                    </div>
                </div>

                <div class="content-card">
                    <h2>Add Funds</h2>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" id="amount" placeholder="Enter amount">
                        </div>
                        <div class="form-group">
                            <label for="paymentMethod">Payment Method</label>
                            <select id="paymentMethod">
                                <option>Credit Card</option>
                                <option>PayPal</option>
                                <option>Bank Transfer</option>
                            </select>
                        </div>
                    </div>
                    <button class="cta-button">Add Funds</button>
                </div>
            </div>

            <!-- Game History Section -->
            <div id="history" class="content-section">
                <div class="content-header">
                    <h1>Game History</h1>
                    <p>View your recent gaming activity and results</p>
                </div>

                <div class="content-card">
                    <h2>Recent Games</h2>
                    <div class="game-history-table">
                        <div class="table-header">
                            <span>Game</span>
                            <span>Date</span>
                            <span>Bet</span>
                            <span>Result</span>
                        </div>
                        <div class="table-row">
                            <span data-label="Game">Orion Stars</span>
                            <span data-label="Date">May 24, 2025</span>
                            <span data-label="Bet">$5.00</span>
                            <span data-label="Result" class="win">+$12.50</span>
                        </div>
                        <div class="table-row">
                            <span data-label="Game">Fire Kirin</span>
                            <span data-label="Date">May 24, 2025</span>
                            <span data-label="Bet">$3.00</span>
                            <span data-label="Result" class="loss">-$3.00</span>
                        </div>
                        <div class="table-row">
                            <span data-label="Game">Ultra Panda</span>
                            <span data-label="Date">May 23, 2025</span>
                            <span data-label="Bet">$2.50</span>
                            <span data-label="Result" class="win">+$7.25</span>
                        </div>
                    </div>
                </div>
            </div>

            <div id="gameplay" class="content-section">
                <div class="content-header">
                    <h1>Gameplay Settings</h1>
                    <p>Customize your gaming experience</p>
                </div>
                <div class="content-card">
                    <h2>Coming Soon</h2>
                    <p>Gameplay customization options will be available here.</p>
                </div>
            </div>

            <div id="support" class="content-section">
                <div class="content-header">
                    <h1>Support</h1>
                    <p>Get help and contact customer support</p>
                </div>
                <div class="content-card">
                    <h2>Contact Support</h2>
                    <p>Need help? Our support team is here to assist you.</p>
                    <a href="{{ route('contact') }}" class="cta-button">Contact Us</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateStat(stat, checkbox) {
            const isChecked = checkbox.checked ? 1 : 0;
            fetch(`/stats-update?stat_name=${stat}&value=${isChecked}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log(`${stat} updated successfully.`);
                } else {
                    console.error(`Failed to update ${stat}.`);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function showSection(sectionId) {
            if(sectionId == 'notifications'){
                window.location.href = "/dashboard/identity-verification";
                return;
            }
            // Hide all sections
            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.remove('active');
            });

            // Remove active class from all menu items
            document.querySelectorAll('.menu-item').forEach(item => {
                item.classList.remove('active');
                if($(item).attr('href') == '#' + sectionId){
                    item.classList.add('active');
                }
            });

            // Show selected section
            document.getElementById(sectionId).classList.add('active');
        }

        $(document).ready(function(){
            let parts = window.location.href.split('#');
            if(parts.length > 1){
                showSection((parts[1].split('?'))[0]);
            }
        });
    </script>

</body>
</html>
