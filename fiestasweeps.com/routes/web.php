<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Page Routes
Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'contactSubmit'])->name('contact.submit');
Route::get('/privacy-policy', function () {
    return view('pages.privacy');
})->name('privacy');

Route::get('/refund-policy', function () {
    return view('pages.refunds');
})->name('refunds');

Route::get('/responsible-gaming', function () {
    return view('pages.responsible-gaming');
})->name('responsible-gaming');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/signin', [AuthController::class, 'showLogin'])->name('signin');
    Route::post('/signin', [AuthController::class, 'login'])->name('signin.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Add inside auth middleware group
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/stats-update', [AuthController::class, 'statsUpdate'])->name('stats.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

