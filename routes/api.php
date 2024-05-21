<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout'])->name('logout');

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('me');
});

Route::get('/test', function (Request $request) {
    return $request->user();
});

