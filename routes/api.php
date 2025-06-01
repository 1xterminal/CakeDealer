<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Public endpoints
Route::post('register', [RegisteredUserController::class, 'store']);
Route::post('login',    [AuthenticatedSessionController::class, 'store']);

// Protected JWT endpoints
Route::middleware('auth:api')->group(function () {
    Route::get('user',   [AuthenticatedSessionController::class, 'user']);
    Route::post('logout',[AuthenticatedSessionController::class, 'destroy']);
});
