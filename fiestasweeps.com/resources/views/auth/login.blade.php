@extends('layouts.app')

@section('title', 'Login')

@push('styles')
<link href="{{ asset('css/auth.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h1>Login</h1>
        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-check">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember me</label>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
            <div class="auth-links">
                <a href="{{ route('password.request') }}">Forgot Password?</a>
                <a href="{{ route('register') }}">Create Account</a>
            </div>
        </form>
    </div>
</div>
@endsection