@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<section id="dashboard">
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h2>Welcome, {{ Auth::user()->name }}!</h2>
            <div class="balance-info">
                <span class="balance-label">Your Balance:</span>
                <span class="balance-amount">$0.00</span>
            </div>
        </div>

        <div class="dashboard-actions">
            <a href="#" class="action-button deposit-button">Deposit</a>
            <a href="#" class="action-button play-button">Play Now</a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="action-button logout-button">Logout</button>
            </form>
        </div>

        <div class="recent-activity">
            <h3>Recent Activity</h3>
            <div class="activity-list">
                <p>No recent activity to display.</p>
            </div>
        </div>
    </div>
</section>
@endsection