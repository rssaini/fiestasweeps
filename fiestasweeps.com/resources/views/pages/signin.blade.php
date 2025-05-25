@extends('layouts.app')

@section('title', 'Sign In')

@section('content')
<section id="signin">
            <h2>Sign In</h2>

            <div class="signin-container">
                <form action="{{ route('signin.post') }}" method="POST">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" autocomplete="username" inputmode="email" spellcheck="false" onfocus="this.removeAttribute('autocomplete');" required />

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" autocomplete="current-password" required />

                    <button type="submit" class="signinbutton">Sign In</button>
                </form>

                <p class="forgot-password"><a href="#">Forgot Password?</a></p>

                <p class="create-account">Don't have an account? <a href="{{ route('register') }}">Sign Up Here</a></p>
            </div>
        </section>

@endsection
