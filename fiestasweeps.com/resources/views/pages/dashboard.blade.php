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
                        <span class="stat-number">$47.50</span>
                        <span class="stat-label">Current Balance</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-number">$250.00</span>
                        <span class="stat-label">Total Deposited</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-number">$125.75</span>
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

            <!-- Other sections would follow similar pattern -->
            <div id="notifications" class="content-section">
                <div class="content-header">
                    <h1>Identity</h1>
                    <p>We require identity verification for deposits, withdrawals, and general gameplay.</p>
                </div>
                <div class="content-card">
                    @if(auth()->user()->verified === 1)
                        <h2>Your profile is Verified.</h2>
                    @endif
                    @if(auth()->user()->verified === null)
                        <div>
                            <h2>Begin Verification</h2>
                            <p>Your identity is currently <strong>not</strong> verified.</p>
                            <p>Please <button class="cta-button" type="button" onclick="beginVerification(this)">click here</button> to begin the identity verification process.</p>
                        </div>
                        <div id="personal_details" style="display:none;">
                            <h2>Please review your personal details before identity verification.</h2>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" readonly value="{{ auth()->user()->email }}">
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" name="name" value="{{ auth()->user()->name }}">
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="lname" value="{{auth()->user()->lname }}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="tel" name="phone" value="{{ auth()->user()->phone }}">
                                </div>
                                <div class="form-group">
                                    <label>Date of Birth</label>
                                    <input type="date" name="dob" value="{{ auth()->user()->dob }}">
                                </div>
                            </div>
                            <button type="button" onclick="startVerification()" class="cta-button">Update & Next</button>
                            <p>We require your GPS location for identity verification process. Please allow location service for this.</p>
                        </div>
                    @endif
                    @if(auth()->user()->verified === 0)
                        <h2>Sorry, We were unable to Verify Identity based on provided information.</h2>
                        <p>Please provide following details also for further verification process.</p>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" readonly value="{{ auth()->user()->email }}">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="name" value="{{ auth()->user()->name }}">
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="lname" value="{{auth()->user()->lname }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="tel" name="phone" value="{{ auth()->user()->phone }}">
                            </div>
                            <div class="form-group">
                                <label>Date of Birth</label>
                                <input type="date" name="dob" value="{{ auth()->user()->dob }}">
                            </div>
                        </div>
                        <!--
                        <div class="form-row">
                            <div class="form-group">
                                <label>Identification Type</label>
                                <select name="IdentificationTypeCode">
                                    <option value="1">Social Security Number</option>
                                    <option value="2">Drivers License Number</option>
                                    <option value="3">Global Passport Document</option>
                                    <option value="4-US">National Identity Card</option>
                                    <option value="999">Custom Document</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Identification Number</label>
                                <input type="text" name="IdentificationNumber">
                            </div>
                        </div>
                        -->
                        <div class="form-row">
                            <div class="form-group">
                                <label>Address Line 1</label>
                                <input type="text" name="AddressLine1">
                            </div>
                            <div class="form-group">
                                <label>Address Line 2</label>
                                <input type="text" name="AddressLine2">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" name="City">
                            </div>
                            <div class="form-group">
                                <label>State</label>
                                <select name="StateCode">
                                    <option value="">Select State</option>
                                    <option value="AL">Alabama</option>
                                    <option value="AK">Alaska</option>
                                    <option value="AZ">Arizona</option>
                                    <option value="AR">Arkansas</option>
                                    <option value="CA">California</option>
                                    <option value="CO">Colorado</option>
                                    <option value="CT">Connecticut</option>
                                    <option value="DE">Delaware</option>
                                    <option value="DC">District of Columbia</option>
                                    <option value="FL">Florida</option>
                                    <option value="GA">Georgia</option>
                                    <option value="HI">Hawaii</option>
                                    <option value="ID">Idaho</option>
                                    <option value="IL">Illinois</option>
                                    <option value="IN">Indiana</option>
                                    <option value="IA">Iowa</option>
                                    <option value="KS">Kansas</option>
                                    <option value="KY">Kentucky</option>
                                    <option value="LA">Louisiana</option>
                                    <option value="ME">Maine</option>
                                    <option value="MD">Maryland</option>
                                    <option value="MA">Massachusetts</option>
                                    <option value="MI">Michigan</option>
                                    <option value="MN">Minnesota</option>
                                    <option value="MS">Mississippi</option>
                                    <option value="MO">Missouri</option>
                                    <option value="MT">Montana</option>
                                    <option value="NE">Nebraska</option>
                                    <option value="NV">Nevada</option>
                                    <option value="NH">New Hampshire</option>
                                    <option value="NJ">New Jersey</option>
                                    <option value="NM">New Mexico</option>
                                    <option value="NY">New York</option>
                                    <option value="NC">North Carolina</option>
                                    <option value="ND">North Dakota</option>
                                    <option value="OH">Ohio</option>
                                    <option value="OK">Oklahoma</option>
                                    <option value="OR">Oregon</option>
                                    <option value="PA">Pennsylvania</option>
                                    <option value="RI">Rhode Island</option>
                                    <option value="SC">South Carolina</option>
                                    <option value="SD">South Dakota</option>
                                    <option value="TN">Tennessee</option>
                                    <option value="TX">Texas</option>
                                    <option value="UT">Utah</option>
                                    <option value="VT">Vermont</option>
                                    <option value="VA">Virginia</option>
                                    <option value="WA">Washington</option>
                                    <option value="WV">West Virginia</option>
                                    <option value="WI">Wisconsin</option>
                                    <option value="WY">Wyoming</option>
                                    </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Postal Code</label>
                                <input type="text" name="PostalCode">
                            </div>
                            <div class="form-group">
                                <label>Country</label>
                                <input type="text" name="CountryCode" value="US" readonly>
                                <!--<select name="CountryCode">
                                    <option value="AF">Afghanistan</option>
                                    <option value="AX">Åland Islands</option>
                                    <option value="AL">Albania</option>
                                    <option value="DZ">Algeria</option>
                                    <option value="AS">American Samoa</option>
                                    <option value="AD">Andorra</option>
                                    <option value="AO">Angola</option>
                                    <option value="AI">Anguilla</option>
                                    <option value="AQ">Antarctica</option>
                                    <option value="AG">Antigua and Barbuda</option>
                                    <option value="AR">Argentina</option>
                                    <option value="AM">Armenia</option>
                                    <option value="AW">Aruba</option>
                                    <option value="AU">Australia</option>
                                    <option value="AT">Austria</option>
                                    <option value="AZ">Azerbaijan</option>
                                    <option value="BS">Bahamas</option>
                                    <option value="BH">Bahrain</option>
                                    <option value="BD">Bangladesh</option>
                                    <option value="BB">Barbados</option>
                                    <option value="BY">Belarus</option>
                                    <option value="BE">Belgium</option>
                                    <option value="BZ">Belize</option>
                                    <option value="BJ">Benin</option>
                                    <option value="BM">Bermuda</option>
                                    <option value="BT">Bhutan</option>
                                    <option value="BO">Bolivia, Plurinational State of</option>
                                    <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                    <option value="BA">Bosnia and Herzegovina</option>
                                    <option value="BW">Botswana</option>
                                    <option value="BV">Bouvet Island</option>
                                    <option value="BR">Brazil</option>
                                    <option value="IO">British Indian Ocean Territory</option>
                                    <option value="BN">Brunei Darussalam</option>
                                    <option value="BG">Bulgaria</option>
                                    <option value="BF">Burkina Faso</option>
                                    <option value="BI">Burundi</option>
                                    <option value="KH">Cambodia</option>
                                    <option value="CM">Cameroon</option>
                                    <option value="CA">Canada</option>
                                    <option value="CV">Cape Verde</option>
                                    <option value="KY">Cayman Islands</option>
                                    <option value="CF">Central African Republic</option>
                                    <option value="TD">Chad</option>
                                    <option value="CL">Chile</option>
                                    <option value="CN">China</option>
                                    <option value="CX">Christmas Island</option>
                                    <option value="CC">Cocos (Keeling) Islands</option>
                                    <option value="CO">Colombia</option>
                                    <option value="KM">Comoros</option>
                                    <option value="CG">Congo</option>
                                    <option value="CD">Congo, the Democratic Republic of the</option>
                                    <option value="CK">Cook Islands</option>
                                    <option value="CR">Costa Rica</option>
                                    <option value="CI">Côte d'Ivoire</option>
                                    <option value="HR">Croatia</option>
                                    <option value="CU">Cuba</option>
                                    <option value="CW">Curaçao</option>
                                    <option value="CY">Cyprus</option>
                                    <option value="CZ">Czech Republic</option>
                                    <option value="DK">Denmark</option>
                                    <option value="DJ">Djibouti</option>
                                    <option value="DM">Dominica</option>
                                    <option value="DO">Dominican Republic</option>
                                    <option value="EC">Ecuador</option>
                                    <option value="EG">Egypt</option>
                                    <option value="SV">El Salvador</option>
                                    <option value="GQ">Equatorial Guinea</option>
                                    <option value="ER">Eritrea</option>
                                    <option value="EE">Estonia</option>
                                    <option value="ET">Ethiopia</option>
                                    <option value="FK">Falkland Islands (Malvinas)</option>
                                    <option value="FO">Faroe Islands</option>
                                    <option value="FJ">Fiji</option>
                                    <option value="FI">Finland</option>
                                    <option value="FR">France</option>
                                    <option value="GF">French Guiana</option>
                                    <option value="PF">French Polynesia</option>
                                    <option value="TF">French Southern Territories</option>
                                    <option value="GA">Gabon</option>
                                    <option value="GM">Gambia</option>
                                    <option value="GE">Georgia</option>
                                    <option value="DE">Germany</option>
                                    <option value="GH">Ghana</option>
                                    <option value="GI">Gibraltar</option>
                                    <option value="GR">Greece</option>
                                    <option value="GL">Greenland</option>
                                    <option value="GD">Grenada</option>
                                    <option value="GP">Guadeloupe</option>
                                    <option value="GU">Guam</option>
                                    <option value="GT">Guatemala</option>
                                    <option value="GG">Guernsey</option>
                                    <option value="GN">Guinea</option>
                                    <option value="GW">Guinea-Bissau</option>
                                    <option value="GY">Guyana</option>
                                    <option value="HT">Haiti</option>
                                    <option value="HM">Heard Island and McDonald Islands</option>
                                    <option value="VA">Holy See (Vatican City State)</option>
                                    <option value="HN">Honduras</option>
                                    <option value="HK">Hong Kong</option>
                                    <option value="HU">Hungary</option>
                                    <option value="IS">Iceland</option>
                                    <option value="IN">India</option>
                                    <option value="ID">Indonesia</option>
                                    <option value="IR">Iran, Islamic Republic of</option>
                                    <option value="IQ">Iraq</option>
                                    <option value="IE">Ireland</option>
                                    <option value="IM">Isle of Man</option>
                                    <option value="IL">Israel</option>
                                    <option value="IT">Italy</option>
                                    <option value="JM">Jamaica</option>
                                    <option value="JP">Japan</option>
                                    <option value="JE">Jersey</option>
                                    <option value="JO">Jordan</option>
                                    <option value="KZ">Kazakhstan</option>
                                    <option value="KE">Kenya</option>
                                    <option value="KI">Kiribati</option>
                                    <option value="KP">Korea, Democratic People's Republic of</option>
                                    <option value="KR">Korea, Republic of</option>
                                    <option value="KW">Kuwait</option>
                                    <option value="KG">Kyrgyzstan</option>
                                    <option value="LA">Lao People's Democratic Republic</option>
                                    <option value="LV">Latvia</option>
                                    <option value="LB">Lebanon</option>
                                    <option value="LS">Lesotho</option>
                                    <option value="LR">Liberia</option>
                                    <option value="LY">Libya</option>
                                    <option value="LI">Liechtenstein</option>
                                    <option value="LT">Lithuania</option>
                                    <option value="LU">Luxembourg</option>
                                    <option value="MO">Macao</option>
                                    <option value="MK">Macedonia, the former Yugoslav Republic of</option>
                                    <option value="MG">Madagascar</option>
                                    <option value="MW">Malawi</option>
                                    <option value="MY">Malaysia</option>
                                    <option value="MV">Maldives</option>
                                    <option value="ML">Mali</option>
                                    <option value="MT">Malta</option>
                                    <option value="MH">Marshall Islands</option>
                                    <option value="MQ">Martinique</option>
                                    <option value="MR">Mauritania</option>
                                    <option value="MU">Mauritius</option>
                                    <option value="YT">Mayotte</option>
                                    <option value="MX">Mexico</option>
                                    <option value="FM">Micronesia, Federated States of</option>
                                    <option value="MD">Moldova, Republic of</option>
                                    <option value="MC">Monaco</option>
                                    <option value="MN">Mongolia</option>
                                    <option value="ME">Montenegro</option>
                                    <option value="MS">Montserrat</option>
                                    <option value="MA">Morocco</option>
                                    <option value="MZ">Mozambique</option>
                                    <option value="MM">Myanmar</option>
                                    <option value="NA">Namibia</option>
                                    <option value="NR">Nauru</option>
                                    <option value="NP">Nepal</option>
                                    <option value="NL">Netherlands</option>
                                    <option value="NC">New Caledonia</option>
                                    <option value="NZ">New Zealand</option>
                                    <option value="NI">Nicaragua</option>
                                    <option value="NE">Niger</option>
                                    <option value="NG">Nigeria</option>
                                    <option value="NU">Niue</option>
                                    <option value="NF">Norfolk Island</option>
                                    <option value="MP">Northern Mariana Islands</option>
                                    <option value="NO">Norway</option>
                                    <option value="OM">Oman</option>
                                    <option value="PK">Pakistan</option>
                                    <option value="PW">Palau</option>
                                    <option value="PS">Palestinian Territory, Occupied</option>
                                    <option value="PA">Panama</option>
                                    <option value="PG">Papua New Guinea</option>
                                    <option value="PY">Paraguay</option>
                                    <option value="PE">Peru</option>
                                    <option value="PH">Philippines</option>
                                    <option value="PN">Pitcairn</option>
                                    <option value="PL">Poland</option>
                                    <option value="PT">Portugal</option>
                                    <option value="PR">Puerto Rico</option>
                                    <option value="QA">Qatar</option>
                                    <option value="RE">R�union</option>
                                    <option value="RO">Romania</option>
                                    <option value="RU">Russian Federation</option>
                                    <option value="RW">Rwanda</option>
                                    <option value="BL">Saint Barth�lemy</option>
                                    <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                                    <option value="KN">Saint Kitts and Nevis</option>
                                    <option value="LC">Saint Lucia</option>
                                    <option value="MF">Saint Martin (French part)</option>
                                    <option value="PM">Saint Pierre and Miquelon</option>
                                    <option value="VC">Saint Vincent and the Grenadines</option>
                                    <option value="WS">Samoa</option>
                                    <option value="SM">San Marino</option>
                                    <option value="ST">Sao Tome and Principe</option>
                                    <option value="SA">Saudi Arabia</option>
                                    <option value="SN">Senegal</option>
                                    <option value="RS">Serbia</option>
                                    <option value="SC">Seychelles</option>
                                    <option value="SL">Sierra Leone</option>
                                    <option value="SG">Singapore</option>
                                    <option value="SX">Sint Maarten (Dutch part)</option>
                                    <option value="SK">Slovakia</option>
                                    <option value="SI">Slovenia</option>
                                    <option value="SB">Solomon Islands</option>
                                    <option value="SO">Somalia</option>
                                    <option value="ZA">South Africa</option>
                                    <option value="GS">South Georgia and the South Sandwich Islands</option>
                                    <option value="SS">South Sudan</option>
                                    <option value="ES">Spain</option>
                                    <option value="LK">Sri Lanka</option>
                                    <option value="SD">Sudan</option>
                                    <option value="SR">Suriname</option>
                                    <option value="SJ">Svalbard and Jan Mayen</option>
                                    <option value="SZ">Swaziland</option>
                                    <option value="SE">Sweden</option>
                                    <option value="CH">Switzerland</option>
                                    <option value="SY">Syrian Arab Republic</option>
                                    <option value="TW">Taiwan, Province of China</option>
                                    <option value="TJ">Tajikistan</option>
                                    <option value="TZ">Tanzania, United Republic of</option>
                                    <option value="TH">Thailand</option>
                                    <option value="TL">Timor-Leste</option>
                                    <option value="TG">Togo</option>
                                    <option value="TK">Tokelau</option>
                                    <option value="TO">Tonga</option>
                                    <option value="TT">Trinidad and Tobago</option>
                                    <option value="TN">Tunisia</option>
                                    <option value="TR">Turkey</option>
                                    <option value="TM">Turkmenistan</option>
                                    <option value="TC">Turks and Caicos Islands</option>
                                    <option value="TV">Tuvalu</option>
                                    <option value="UG">Uganda</option>
                                    <option value="UA">Ukraine</option>
                                    <option value="AE">United Arab Emirates</option>
                                    <option value="GB">United Kingdom</option>
                                    <option value="US">United States</option>
                                    <option value="UM">United States Minor Outlying Islands</option>
                                    <option value="UY">Uruguay</option>
                                    <option value="UZ">Uzbekistan</option>
                                    <option value="VU">Vanuatu</option>
                                    <option value="VE">Venezuela, Bolivarian Republic of</option>
                                    <option value="VN">Viet Nam</option>
                                    <option value="VG">Virgin Islands, British</option>
                                    <option value="VI">Virgin Islands, U.S.</option>
                                    <option value="WF">Wallis and Futuna</option>
                                    <option value="EH">Western Sahara</option>
                                    <option value="YE">Yemen</option>
                                    <option value="ZM">Zambia</option>
                                    <option value="ZW">Zimbabwe</option>
                                </select>-->
                            </div>
                        </div>
                        <button type="button" onclick="startVerification()" class="cta-button">Verify Identity</button>
                    @endif

                </div>
                <div id="DepositAmountDisplay"></div>

                <div id="GIDX_ServiceContainer"></div>

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
        function validateFields(){
            $('#notifications').find('input,select').each(function(index, item){
                if($(item).val() == ''){
                    alert("All fields are required");
                    $(item).focus();
                    return false;
                }
            });
        }
        function postCustomer(position = null){
            @if(auth()->user()->verified === 0)
            validateFields();
            @endif
            const firstName = $('#personal_details input[name="name"]').val();
            const lastName = $('#personal_details input[name="lname"]').val();
            const phone = $('#personal_details input[name="phone"]').val();
            const dob = $('#personal_details input[name="dob"]').val();
            if(firstName == ''){
                alert('First Name is required.');
                $('#personal_details input[name="name"]').focus();
                return false;
            }
            if(lastName == ''){
                alert('Last Name is required.');
                $('#personal_details input[name="lname"]').focus();
                return false;
            }
            if(phone == ''){
                alert('Mobile phone number is required.');
                $('#personal_details input[name="phone"]').focus();
                return false;
            }
            if(dob == ''){
                alert('Date of Birth is required.');
                $('#personal_details input[name="dob"]').focus();
                return false;
            }
            pageLoader.show('Verifying Identity...', { dark: true});
            $.ajax({
                url: "{{ route('gidx.customer.registration')}}",
                method: "post",
                data: {
                    location: position ? JSON.stringify(position) : '',
                    _token: "{{ csrf_token() }}",
                    firstName: firstName,
                    lastName: lastName,
                    phone: phone,
                    dob: dob
                }
            }).done(function(data){
                window.location.reload();
                pageLoader.hide();
                console.log(data);
            }).fail(function(err){
                pageLoader.hide();
                alert('Something is wrong at our end. Please try again later.');
                console.log(err);
            });
        }
        function beginVerification(button){
            $('#personal_details').css('display', 'block');
            $(button).parent().parent().css('display', 'none');
            if (!('geolocation' in navigator)) {
                $('#personal_details > p:last-child').css('display', 'none');
            }
        }
        function startVerification(){
            if ('geolocation' in navigator) {
                try {
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            postCustomer(position);
                        },
                        function(error) {
                            // Handle different error types
                            let errorMessage;
                            let cardClass = 'status-card error';

                            switch(error.code) {
                                case error.PERMISSION_DENIED:
                                    alert("GeoLocation Permission denied. Unable to verify Identity");
                                    break;
                                case error.POSITION_UNAVAILABLE:
                                    alert("GeoLocation Unavialable. Unable to verify Identity");
                                    break;
                                case error.TIMEOUT:
                                    alert("GeoLocation Service Timeout. Unable to verify Identity");
                                    break;
                                default:
                                    alert("Error occured when trying to fetch geolocation service. Unable to verify Identity");
                                    break;
                            }
                        },
                        {
                            enableHighAccuracy: false,
                            timeout: 10000,
                            maximumAge: 60000
                        }
                    );

                } catch (error) {
                    alert("GeoLocation Permission denied. Unable to verify Identity");
                }
            } else {
                postCustomer();
            }
        }

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
        window.gidxServiceSettings = function() {
        window.gidxBuildSteps = false;
            //this is the dom object (div) where the cashier/registration service should be embedded on the page.
            window.gidxContainer = "#GIDX_ServiceContainer";
      };
      window.gidxErrorReport = function(error, errorMsg){
        //Error messages will be sent here by the GIDX Client Side Service
      };
      window.gidxNextStep = function(){
        //Once the customer has completed this Session the GIDX Client Side Service will call this function.
        //You should now make an "aJax" call or do a "document.location='a page on your server'" and call
        //the the appropriate API Method.
      };
      window.gidxServiceStatus = function (service, action, json) {
        //during each "step" within a Web Session process this function is called by the GIDX Client Side Service
        //providing you the service action that was just performed, the start & stop time, and a JSON key/value
        //that you can parse/loop to get more data control of the process.
        //Here's an example of getting the deposit value selected and displaying it within an element on the page.
           for (var i = 0; i < json.length; i++) {
                for (var key in json[i]) {
                if (json[i].hasOwnProperty(key)) {
                //Here you can look at the key and value to make decisions on what you would
                //like to do with the client side interface.
                var sItem = key;
                var sValue = json[i][key];
              console.log(sItem +": ", sValue);
                //Example
                if(sItem == "TransactionAmount"){
                    document.getElementById("DepositAmountDisplay").innerText(sValue);
                }
            }
          }
        }
      };

    class FullPageLoader {
        constructor() {
            this.loader = document.getElementById('pageLoader');
            this.loaderText = document.getElementById('loaderText');
            this.progressContainer = document.getElementById('progressContainer');
            this.progressFill = document.getElementById('progressFill');
            this.progressPercentage = document.getElementById('progressPercentage');
            this.isVisible = false;
            this.progressInterval = null;
        }

        /**
        * Show the full page loader
        * @param {string} text - Loading message
        * @param {Object} options - Configuration options
        */
        show(text = 'Loading...', options = {}) {
            if (!this.loader) return this;

            // Set loading text
            if (this.loaderText) {
                this.loaderText.textContent = text;
            }

            // Apply dark theme if specified
            if (options.dark) {
                this.loader.classList.add('dark');
            } else {
                this.loader.classList.remove('dark');
            }

            // Show progress bar if specified
            if (options.showProgress && this.progressContainer) {
                this.progressContainer.style.display = 'block';
                this.setProgress(0);
            } else if (this.progressContainer) {
                this.progressContainer.style.display = 'none';
            }

            // Show the loader
            this.loader.classList.remove('hidden');
            this.isVisible = true;

            // Auto-hide after specified duration
            if (options.duration) {
                setTimeout(() => this.hide(), options.duration);
            }

            return this;
        }

        /**
        * Hide the full page loader
        */
        hide() {
            if (!this.loader) return this;

            this.loader.classList.add('hidden');
            this.isVisible = false;
            this.clearProgress();

            return this;
        }

        /**
        * Set progress percentage
        * @param {number} percentage - Progress value (0-100)
        */
        setProgress(percentage) {
            if (!this.progressFill || !this.progressPercentage) return this;

            const progress = Math.max(0, Math.min(100, percentage));
            this.progressFill.style.width = `${progress}%`;
            this.progressPercentage.textContent = `${Math.round(progress)}%`;

            return this;
        }

        /**
        * Show loader with animated progress
        * @param {string} text - Loading message
        * @param {number} duration - Duration in milliseconds
        */
        showWithProgress(text = 'Loading...', duration = 3000) {
            this.show(text, { showProgress: true });

            let progress = 0;
            const increment = 100 / (duration / 50); // Update every 50ms

            this.progressInterval = setInterval(() => {
                progress += increment;
                this.setProgress(progress);

                if (progress >= 100) {
                    this.clearProgress();
                    setTimeout(() => this.hide(), 500);
                }
            }, 50);

            return this;
        }

        /**
        * Clear progress interval
        */
        clearProgress() {
            if (this.progressInterval) {
                clearInterval(this.progressInterval);
                this.progressInterval = null;
            }
            return this;
        }

        /**
        * Check if loader is currently visible
        */
        isLoading() {
            return this.isVisible;
        }
    }
    const pageLoader = new FullPageLoader();
    $(document).ready(function(){
        pageLoader.hide();
        let parts = window.location.href.split('#');
        if(parts.length > 1){
            showSection((parts[1].split('?'))[0]);
        }
    });
</script>
</body>
</html>
