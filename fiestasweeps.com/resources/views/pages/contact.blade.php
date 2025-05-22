@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<section id="contact">
    <h2>Contact Us</h2>
    <div class="contact-container">
        <div class="contact-section">
            <h3>Email Us</h3>
            <p>Send us an email at <a href="mailto:support@fiestasweeps.com">support@fiestasweeps.com</a></p>
        </div>

        <div class="contact-section">
            <h3>Visit Us</h3>
            <p>Fiesta Sweeps HQ<br>811 W Comal St<br>Pearsall, TX 78061</p>
        </div>

        <div class="contact-section">
            <h3>Follow Us</h3>
            <div class="social-buttons">
                <a href="#" class="social-button">
                    <img src="{{ asset('assets/facebook.png') }}" alt="Facebook" class="social-icon">
                </a>
                <a href="#" class="social-button">
                    <img src="{{ asset('assets/twitter.png') }}" alt="Twitter" class="social-icon">
                </a>
            </div>
        </div>

        <div class="contact-section">
            <h3>Chat on Telegram</h3>
            <a href="#" class="social-button">
                <img src="{{ asset('assets/telegram.png') }}" alt="Telegram" class="social-icon">
            </a>
        </div>
    </div>
</section>
@endsection