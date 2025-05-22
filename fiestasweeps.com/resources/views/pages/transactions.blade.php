@extends('layouts.app')

@section('title', 'Transaction History')

@section('content')
<section id="dashboard">
    <div class="dashboard-container">
        <h2>Transaction History</h2>
        
        <div class="transactions-list">
            @forelse($transactions as $transaction)
                <div class="transaction-item">
                    <div class="transaction-info">
                        <span class="transaction-type">{{ ucfirst($transaction->type) }}</span>
                        <span class="transaction-amount">${{ number_format($transaction->amount, 2) }}</span>
                        <span class="transaction-status">{{ ucfirst($transaction->status) }}</span>
                        <span class="transaction-date">{{ $transaction->created_at->format('M d, Y H:i') }}</span>
                    </div>
                </div>
            @empty
                <p>No transactions found.</p>
            @endforelse
        </div>

        {{ $transactions->links() }}
    </div>
</section>
@endsection