<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PaymentHandleController;
use App\Http\Controllers\CashoutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GidxController;
use App\Http\Controllers\LogViewerController;
use App\Http\Controllers\QRAuthController;
use Illuminate\Support\Facades\Route;

// Page Routes
Route::get('/player', function(){
    return view('player');
});
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
Route::get('/official-rules', [PageController::class, 'officialRules'])->name('official.rules');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/signin', [AuthController::class, 'showLogin'])->name('signin');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/signin', [AuthController::class, 'login'])->name('signin.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::get('/qr-login/{token}', [QRAuthController::class, 'loginWithQR'])->name('qr.login');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/logs', [LogViewerController::class, 'index'])->name('logs.index');
    Route::get('/logs/download', [LogViewerController::class, 'download'])->name('logs.download');
    Route::delete('/logs/delete', [LogViewerController::class, 'delete'])->name('logs.delete');
    Route::delete('/logs/clear', [LogViewerController::class, 'clear'])->name('logs.clear');
});
Route::middleware('auth')->group(function () {
    Route::post('/qr-auth/generate', [QRAuthController::class, 'generateQR'])->name('qr.generate');
    Route::get('/qr-auth/status/{token}', [QRAuthController::class, 'checkQRStatus'])->name('qr.status');
});

// Add inside auth middleware group
Route::middleware('auth')->group(function () {
    Route::get('/user/profile', [AuthController::class, 'user_profile'])->name('user.profile');
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/identity-verification', [AuthController::class, 'identity_verification'])->name('dashboard.identity.verification');
    Route::get('/dashboard/customer-balance', [AuthController::class, 'customer_balance'])->name('dashboard.customer.balance');
    Route::get('/stats-update', [AuthController::class, 'statsUpdate'])->name('stats.update');
    Route::post('/profile-update', [AuthController::class, 'profileUpdate'])->name('profile.update');
    Route::post('/password-update', [AuthController::class, 'passwordUpdate'])->name('password.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    Route::post('/createTransaction', [AuthController::class, 'createTransaction'])->name('createTransaction');
    Route::post('/update-status-transaction', [TransactionController::class, 'updateStatus'])->name('updateStatusTransaction');

    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    Route::delete('/cashouts/{id}', [CashoutController::class, 'destroy'])->name('cashouts.destroy');



    // Transaction Routes
    Route::resource('transactions', TransactionController::class)->only([
        'index', 'create', 'store'
    ])->names([
        'index' => 'transactions.index',
        'create' => 'transactions.create',
        'store' => 'transactions.store',
    ]);

    // Cashout Routes
    Route::resource('cashouts', CashoutController::class)->only([
        'index', 'create', 'store'
    ])->names([
        'index' => 'cashouts.index',
        'create' => 'cashouts.create',
        'store' => 'cashouts.store'
    ]);


    Route::post('/gidx-customer-registration', [GidxController::class, 'customerRegistration'])->name('gidx.customer.registration');
});

Route::post('/gidx-notification', [GidxController::class, 'notification'])->name('gidx.notification');
Route::get('/gidx-redirect/{sessionId}', [GidxController::class, 'gidx_redirect'])->name('gidx.redirect');
Route::post('/gidx-callback/{sessionId}', [GidxController::class, 'gidx_callback'])->name('gidx.callback');

Route::post('/gidx-create-session' , [GidxController::class, 'createSession'])->name('gidx.create.session');
Route::post('/gidx-complete-session' , [GidxController::class, 'completeSession'])->name('gidx.complete.session');

