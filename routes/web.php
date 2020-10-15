<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstateController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('owners', OwnerController::class)->only(['index', 'store', 'destroy']);
    Route::get('owners/select-input', [OwnerController::class, 'selectInput'])->name('owners.select-input');

    Route::resource('estates', EstateController::class)->only(['index', 'store', 'destroy']);
});
