<?php

use App\Http\Controllers\Auth\{
    AuthController,
    ResetPasswordController
};

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/create', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/password/forgot', [AuthController::class, 'sendResetLinkEmail'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'reset']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
