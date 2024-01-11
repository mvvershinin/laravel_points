<?php

use App\Http\Controllers\V1\Auth\AuthController;
use App\Http\Controllers\V1\Coordinate\CoordinateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//auth
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('ability:refresh-access-token')->group(function () {
        Route::get('refresh-token', [AuthController::class, 'refreshToken']);
    });
});

//coordinates
Route::prefix('coordinates')
    ->middleware('ability:access-api')
        ->group(function () {
            Route::get('points', [CoordinateController::class, 'index']);
            Route::post('points', [CoordinateController::class, 'store']);
        });

