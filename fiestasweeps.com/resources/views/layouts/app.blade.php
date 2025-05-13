<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FiestaSweeps - Online Sweepstakes Games</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logos/favicon.ico') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @stack('styles')
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="navbar-brand">
                <img src="{{ asset('images/logos/logo.png') }}" alt="FiestaSweeps" class="logo">
            </a>
            <div class="nav-links">
                <a href="{{ route('home') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">Home</a>
                <a href="{{ route('games') }}" class="nav-link {{ Request::is('games*') ? 'active' : '' }}">Games</a>
                <a href="{{ route('about') }}" class="nav-link {{ Request::is('about') ? 'active' : '' }}">About</a>
                <a href="{{ route('contact') }}" class="nav-link {{ Request::is('contact') ? 'active' : '' }}">Contact</a>
            </div>
            <div class="auth-buttons">
                <a href="{{ route('login') }}" class="btn btn-outline">Sign In</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Join Now</a>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-logo">
                <img src="{{ asset('images/logos/logo-dark.png') }}" alt="FiestaSweeps">
                <p class="footer-desc">Experience the thrill of online sweepstakes gaming with FiestaSweeps. Play your favorite games and win exciting rewards!</p>
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
                    <div class="social-links">
                        <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} FiestaSweeps. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>