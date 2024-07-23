<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\CurrencyController;
use App\Http\Controllers\V1\ConvertController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->middleware(['throttle:api'])->prefix('auth')->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout');
    Route::post('/refresh', 'refresh');
    Route::get('/user', 'user');
});

Route::middleware(['throttle:api', 'auth:api'])->group(function () {
    Route::resource('currencies',CurrencyController::class);
    Route::resource('convert',ConvertController::class);
});
