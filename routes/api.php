<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginRegisterLogoutController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SuccessfulEmailController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public auth routes of auth
Route::controller(LoginRegisterLogoutController::class)->group(function() {
    Route::post('/login', 'login');
});

// Protected app routes
Route::middleware(['auth:sanctum', 'ability:app'])->group( function () {
    Route::post('/logout', [LoginRegisterLogoutController::class, 'logout']);
    Route::get('/getUserInfo', [UserController::class, 'getUserInfo']);

    // Successful Emails routes
    Route::get('/successful-emails', [SuccessfulEmailController::class, 'index']);
    Route::get('/successful-emails/{id}', [SuccessfulEmailController::class, 'show']);
    Route::put('/successful-emails/{id}', [SuccessfulEmailController::class, 'update']);
    Route::delete('/successful-emails/{id}', [SuccessfulEmailController::class, 'destroy']);
});
