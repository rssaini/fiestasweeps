@extends('layouts.app')

@section('title', 'Deposit')

@section('content')
<section id="signin">
    <h2>Make a Deposit</h2>
    <div class="signin-container">
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('deposit.process') }}" method="POST">
            @csrf
            <label for="amount">Amount to Deposit</label>
            <input type="number" id="amount" name="amount" min="10" step="0.01" placeholder="Enter amount" required>
            
            <button type="submit" class="signinbutton">Proceed to Payment</button>
        </form>
    </div>
</section>
@endsection