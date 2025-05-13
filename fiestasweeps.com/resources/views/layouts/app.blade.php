<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FiestaSweeps - @yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logos/favicon.ico') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
    <!-- Add this in the head section -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="navbar-brand">
                <img src="{{ asset('images/logos/logo.png') }}" alt="FiestaSweeps Logo" class="logo">
            </a>
            <div class="nav-links">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
                <a href="{{ route('games') }}" class="nav-link">Games</a>
                <a href="{{ route('about') }}" class="nav-link">About</a>
                <a href="{{ route('contact') }}" class="nav-link">Contact</a>
            </div>
            <div class="auth-buttons">
                <a href="{{ route('login') }}" class="btn btn-outline">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a>
            </div>
            <!-- Add this after the auth-buttons div in the nav-container -->
            <button class="mobile-menu-btn">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <div class="mobile-menu">
                <div class="mobile-nav-links">
                    <a href="{{ route('home') }}" class="mobile-nav-link">Home</a>
                    <a href="{{ route('games') }}" class="mobile-nav-link">Games</a>
                    <a href="{{ route('about') }}" class="mobile-nav-link">About</a>
                    <a href="{{ route('contact') }}" class="mobile-nav-link">Contact</a>
                </div>
                <div class="mobile-auth-buttons">
                    <a href="{{ route('login') }}" class="btn btn-outline">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-logo">
                <img src="{{ asset('images/logos/logo-dark.png') }}" alt="FiestaSweeps Logo">
            </div>
            <div class="footer-links">
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('games') }}">Games</a>
                    <a href="{{ route('about') }}">About Us</a>
                    <a href="{{ route('contact') }}">Contact</a>
                </div>
                <div class="footer-section">
                    <h3>Legal</h3>
                    <a href="{{ route('terms') }}">Terms & Conditions</a>
                    <a href="{{ route('privacy') }}">Privacy Policy</a>
                    <a href="{{ route('responsible-gaming') }}">Responsible Gaming</a>
                </div>
                <div class="footer-section">
                    <h3>Support</h3>
                    <a href="{{ route('faq') }}">FAQ</a>
                    <a href="{{ route('contact') }}">Support</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} FiestaSweeps. All rights reserved.</p>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>