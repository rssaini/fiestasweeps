@extends('layouts.app')

@section('title', 'Register')

@section('content')
<section id="register">
            <h2>Create Your Account</h2>

            <div class="register-container">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>

                @endif
                <form action="{{ route('register.post') }}" method="POST">
                    @csrf
                    <label for="first-name">First Name</label>
                    <input type="text" id="first-name" name="fname" placeholder="Enter your first name" required />

                    <label for="last-name">Last Name</label>
                    <input type="text" id="last-name" name="lname" placeholder="Enter your last name" required />

                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" autocomplete="email" required />

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Create a password" autocomplete="new-password" required />

                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="password_confirmation" placeholder="Re-enter your password" required />

                    <label for="phone">Phone Number (Optional)</label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" />

                    <button type="submit" class="registerbutton">Sign Up</button>
                </form>

                <p class="existing-account">Already have an account? <a href="{{ route('signin') }}">Sign In Here</a></p>
            </div>
        </section>
@endsection
