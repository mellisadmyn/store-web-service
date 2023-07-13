<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProductController;

// Public Routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/send-reset-password-email', [PasswordResetController::class, 'send_reset_password_email']);
Route::post('/reset-password/{token}', [PasswordResetController::class, 'reset']);

// Protected Routes
Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('/logout', [UserController::class, 'logout']);

    Route::get('/products', [ProductController::class, "index"]);
    Route::post('/products', [ProductController::class, "store"]);
    Route::get('/products/{id}', [ProductController::class, "show"]);
    Route::post('/products/{id}', [ProductController::class, "update"]);
    Route::delete("products/{id}", [ProductController::class, "destroy"]);
});