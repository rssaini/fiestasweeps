<header>
    <div class="logo">
        <a href="{{ route('home') }}"><img src="{{ asset('assets/logo.png') }}" alt="Fiesta Sweeps Logo"></a>
    </div>

    <nav class="menu-buttons">
        <a href="{{ route('home') }}#steps" class="menu-button">How It Works</a>
        <a href="{{ route('home') }}#games" class="menu-button">Our Games</a>
        <a href="{{ route('about') }}" class="menu-button">About Us</a>
        <a href="{{ route('contact') }}" class="menu-button">Contact</a>
    </nav>

    <div class="auth-buttons">
        <a href="{{ route('signin') }}" class="sign-in-button">Sign In</a>
        <a href="{{ route('register') }}" class="register-button">Register</a>
    </div>
</header>

