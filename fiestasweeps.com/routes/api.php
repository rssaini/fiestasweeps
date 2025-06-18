<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PaymentHandleController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsSupervisor;
use App\Http\Middleware\IsSupervisorOrAdmin;


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::middleware(IsAdmin::class)->group(function () {
        Route::apiResource('supervisors', SupervisorController::class);
        Route::apiResource('games', GameController::class);
        Route::apiResource('handles', PaymentHandleController::class)->except([
            'index'
        ]);
    });

    Route::middleware(IsSupervisorOrAdmin::class)->group(function () {
        Route::apiResource('agents', AgentController::class);
    });

    Route::middleware(IsSupervisor::class)->group(function () {

    });
    Route::get('handles', [PaymentHandleController::class, 'index'])->name('handles.index');
});
