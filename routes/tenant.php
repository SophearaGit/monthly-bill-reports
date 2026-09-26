<?php

use App\Http\Controllers\Tenant\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Tenant\PortalController;
use Illuminate\Support\Facades\Route;

// Tenant portal: no self-registration or self-service password reset.
// An admin creates the tenant record and sets their password from the
// admin panel; the tenant simply signs in here to view their own data.
Route::prefix('tenant')->name('tenant.')->group(function () {
    Route::middleware('guest:tenant')->group(function () {
        Route::get('login', [AuthenticatedSessionController::class, 'create'])
            ->name('login');

        Route::post('login', [AuthenticatedSessionController::class, 'store']);
    });

    Route::middleware('auth:tenant')->group(function () {
        Route::get('home', [PortalController::class, 'index'])->name('home');

        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');
    });
});
