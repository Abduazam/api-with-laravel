<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tickets', \App\Http\Controllers\Api\V1\TicketController::class);
    Route::apiResource('users', \App\Http\Controllers\Api\V1\UserController::class);
});
