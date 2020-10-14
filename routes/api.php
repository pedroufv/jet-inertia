<?php

use App\Http\Controllers\API\EstateController;
use App\Http\Controllers\API\OwnerController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->name('api.')->group(function () {
    Route::apiResource('owners', OwnerController::class);
    Route::apiResource('estates', EstateController::class);
});

