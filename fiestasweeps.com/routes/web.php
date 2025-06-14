<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CashoutController;
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
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/signin', [AuthController::class, 'login'])->name('signin.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Add inside auth middleware group
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/stats-update', [AuthController::class, 'statsUpdate'])->name('stats.update');
    Route::post('/profile-update', [AuthController::class, 'profileUpdate'])->name('profile.update');
    Route::post('/password-update', [AuthController::class, 'passwordUpdate'])->name('password.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/create-admin-user', [AuthController::class, 'createAdminUser'])->name('admin.user.create');
    Route::post('/game-create', [AuthController::class, 'createGame'])->name('game.create');
    Route::post('/payment-method', [AuthController::class, 'addPaymentMethod'])->name('paymentMethod.create');
    Route::post('/createTransaction', [AuthController::class, 'createTransaction'])->name('createTransaction');
    Route::get('/update-user-handle', [AuthController::class, 'updateUserHandle'])->name('userHandle.update');



    // Transaction Routes
    Route::resource('transactions', TransactionController::class)->only([
        'index', 'create', 'store'
    ])->names([
        'index' => 'transactions.index',
        'create' => 'transactions.create',
        'store' => 'transactions.store'
    ]);

    // Cashout Routes
    Route::resource('cashouts', CashoutController::class)->only([
        'index', 'create', 'store'
    ])->names([
        'index' => 'cashouts.index',
        'create' => 'cashouts.create',
        'store' => 'cashouts.store'
    ]);
});

