<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>Dashboard - Fiesta Sweeps</title>
    <link rel="stylesheet" href="/css/app.css" />
    <link rel="stylesheet" href="/css/dashboard.css" />
    <link rel="icon" type="image/png" href="{{ asset('assets/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('assets/favicon.ico') }}" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    @vite('resources/js/main.js')
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
                    <img src="/assets/logo.png" alt="Fiesta Sweeps Logo" style="height: 80px;">
                </div>
                <h2>Dashboard</h2>
                <p>Welcome back, {{ auth()->user()->name }}!</p>
            </div>

            <nav class="sidebar-menu">
                <a href="#account" class="menu-item" onclick="showSection('account')">Account</a>
                <a href="#privacy" class="menu-item" onclick="showSection('privacy')">Privacy</a>
                <a href="#security" class="menu-item" onclick="showSection('security')">Security</a>
                <a href="#notifications" class="menu-item" onclick="showSection('notifications')">Identity</a>
                <a href="#gameplay" class="menu-item" onclick="showSection('gameplay')">Gameplay</a>
                <a href="#history" class="menu-item" onclick="showSection('history')">Game History</a>
                <a href="#balance" class="menu-item active" onclick="showSection('balance')">Balance</a>
                <a href="#support" class="menu-item" onclick="showSection('support')">Support</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">


            <!-- Balance Section -->
            <div id="balance" class="content-section active">
                <div class="content-header">
                    <h1>Account Balance</h1>
                    <p>View your current balance and transaction history</p>
                    <p style="color: #da5446">Geo Location Mandatory for Game Play & entering into any contest.</p>
                </div>

                <div class="stats-grid">
                    <div class="stat-card">
                        <span class="stat-number" style="color:#46c8da">{{ $user->current_balance }}</span>
                        <span class="stat-label">Current Balance</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-number">{{ $user->total_deposits }}</span>
                        <span class="stat-label">Total Deposited</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-number" style="color: #1bc914">{{ $user->total_winnings }}</span>
                        <span class="stat-label">Total Winnings</span>
                    </div>
                </div>

                <div class="content-card">
                    <div id="vue-root"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            if(sectionId == 'notifications'){
                window.location.href = "/dashboard/identity-verification";
                return;
            }
            if(sectionId != 'balance'){
                window.location.href = "/dashboard#" + sectionId;
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
