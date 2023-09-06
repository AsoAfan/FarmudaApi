<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['guest:sanctum'])->group(function () {


    Route::post('register', [\App\Http\Controllers\Auth\AuthController::class, 'register']);
    Route::post('login', [\App\Http\Controllers\Auth\AuthController::class, 'login']);

    // Resend otp code
    Route::get('resend', [\App\Http\Controllers\Auth\AuthController::class, 'sendOtp']);

    // Verify email
    Route::post('verify-email/{user:otp_secret_slug}', [\App\Http\Controllers\EmailVerificationController::class, 'checkOtp'])
        ->missing(fn() => response()->json(["errors" => "URL not found", 'status' => 404], 404));


    Route::get('not-auth', function () {
        return response()->json(["errors" => 'You are not authorized'], 401);
    })->name('login');

});
