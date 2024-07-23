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

Route::controller(CurrencyController::class)->middleware(['throttle:api', 'auth:api'])->prefix('currencies')->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
});

Route::controller(ConvertController::class)->middleware(['throttle:api', 'auth:api'])->prefix('convert')->group(function () {
    Route::post('/', 'index');
});
