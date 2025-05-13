@extends('layouts.app')

@section('title', $game->name)

@section('content')
<div class="game-container">
    <div class="game-header">
        <h1>{{ $game->name }}</h1>
        <p>{{ $game->description }}</p>
    </div>
    <div class="game-content">
        <!-- Game iframe or content will go here -->
        <div class="game-frame">
            <!-- Add your game content here -->
        </div>
    </div>
</div>
@endsection