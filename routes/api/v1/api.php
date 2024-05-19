<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->name('api.')->group(function () {
    Route::apiResource('tickets', \App\Http\Controllers\Api\V1\Tickets\TicketController::class);
    Route::apiResource('users', \App\Http\Controllers\Api\V1\Users\UserController::class);
    Route::apiResource('users.tickets', \App\Http\Controllers\Api\V1\Users\UserTicketsController::class);
});
