<?php

use App\Http\Controllers\Back\AdminDashboardController;
use App\Http\Controllers\Back\InvoiceController;
use App\Http\Controllers\Back\MeterReadingController;
use App\Http\Controllers\Back\RoomController;
use App\Http\Controllers\Back\TenentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'Dashboard'])->name('dashboard');
    Route::resource('/rooms', RoomController::class);
    Route::resource('/tenents', TenentController::class);

    Route::get('/meter-readings', [MeterReadingController::class, 'index'])->name('meter_readings.index');
    Route::post('/meter-readings', [MeterReadingController::class, 'store'])->name('meter_readings.store');

    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
