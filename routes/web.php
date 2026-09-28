<?php

use App\Http\Controllers\Back\AdminDashboardController;
use App\Http\Controllers\Back\FloorController;
use App\Http\Controllers\Back\InvoiceController;
use App\Http\Controllers\Back\MeterReadingController;
use App\Http\Controllers\Back\RoomController;
use App\Http\Controllers\Back\TenentController;
use App\Http\Controllers\Back\TenentDetailController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth:admin', 'verified']], function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'Dashboard'])->name('dashboard');
    Route::resource('/rooms', RoomController::class);
    Route::post('/floors', [FloorController::class, 'store'])->name('floors.store');
    Route::delete('/floors/{floor}', [FloorController::class, 'destroy'])->name('floors.destroy');
    Route::resource('/tenents', TenentController::class);

    Route::get('/tenents/{tenent}/details', [TenentDetailController::class, 'show'])->name('tenents.details');
    Route::post('/tenents/{tenent}/social-links', [TenentDetailController::class, 'storeSocialLink'])->name('tenents.social-links.store');
    Route::delete('/tenents/{tenent}/social-links/{socialLink}', [TenentDetailController::class, 'destroySocialLink'])->name('tenents.social-links.destroy');
    Route::post('/tenents/{tenent}/transportations', [TenentDetailController::class, 'storeTransportation'])->name('tenents.transportations.store');
    Route::delete('/tenents/{tenent}/transportations/{transportation}', [TenentDetailController::class, 'destroyTransportation'])->name('tenents.transportations.destroy');
    Route::post('/tenents/{tenent}/documents', [TenentDetailController::class, 'storeDocument'])->name('tenents.documents.store');
    Route::delete('/tenents/{tenent}/documents/{document}', [TenentDetailController::class, 'destroyDocument'])->name('tenents.documents.destroy');

    Route::get('/meter-readings', [MeterReadingController::class, 'index'])->name('meter_readings.index');
    Route::post('/meter-readings', [MeterReadingController::class, 'store'])->name('meter_readings.store');

    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::patch('/invoices/{invoice}/status', [InvoiceController::class, 'updateStatus'])->name('invoices.updateStatus');
    Route::patch('/invoices/bulk-status', [InvoiceController::class, 'bulkUpdateStatus'])->name('invoices.bulkUpdateStatus');
    Route::get('/invoices/{invoice}/pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.pdf');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/admin.php';
require __DIR__ . '/tenant.php';

