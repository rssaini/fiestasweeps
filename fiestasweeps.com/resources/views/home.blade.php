@extends('layouts.app')

@section('title', 'Home')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
<div class="home-container">
    <div class="hero-section">
        <div class="hero-content">
            <h1>Welcome to FiestaSweeps</h1>
            <p>Play Your Favorite Games & Win Real Money!</p>
            <div class="hero-buttons">
                <a href="{{ route('register') }}" class="btn btn-primary">Sign Up Now</a>
                <a href="{{ route('games') }}" class="btn btn-secondary">Browse Games</a>
            </div>
        </div>
    </div>

    <div class="featured-games">
        <h2>Popular Games</h2>
        <div class="games-grid">
            @foreach($featuredGames as $game)
            <div class="game-card">
                <div class="game-image">
                    <img src="{{ asset('images/games/' . $game->image) }}" alt="{{ $game->name }}">
                </div>
                <div class="game-info">
                    <h3>{{ $game->name }}</h3>
                    <p>{{ $game->description }}</p>
                    <a href="{{ route('games.play', $game->slug) }}" class="play-btn">Play Now</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="features-section">
        <div class="feature">
            <i class="fas fa-shield-alt"></i>
            <h3>Secure Gaming</h3>
            <p>Safe and protected gaming environment</p>
        </div>
        <div class="feature">
            <i class="fas fa-dollar-sign"></i>
            <h3>Real Rewards</h3>
            <p>Win real money prizes</p>
        </div>
        <div class="feature">
            <i class="fas fa-headset"></i>
            <h3>24/7 Support</h3>
            <p>Always here to help you</p>
        </div>
    </div>
</div>
@endsection