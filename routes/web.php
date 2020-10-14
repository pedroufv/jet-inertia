<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstateController;
use App\Http\Controllers\OwnerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('owners', OwnerController::class)->only(['index', 'store', 'destroy']);

    Route::get('/estates', [EstateController::class, 'index'])->name('estates.index');
});
