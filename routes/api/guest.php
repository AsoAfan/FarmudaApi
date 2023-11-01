<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\EmailVerificationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest:sanctum'])->group(function () {

    // Password reset
    Route::post('/forget-password', [PasswordResetController::class, 'sendLink'])->name('password.email');

//        Route::post('/forgot-password', function (Request $request) {
//            $request->validate(['email' => 'required|email']);
//
//            $status = Password::sendResetLink(
//                $request->only('email')
//            );
//
//            return $status === Password::RESET_LINK_SENT
//                ? ['success' => 'good']
//                : ['errors' => 'bad'];
//        })->middleware('guest')->name('password.email');
//
//        Route::get('/reset-password/{token}', function (string $token) {
//            return view('auth.reset-password', ['token' => $token]);
//        })->middleware('guest')->name('password.reset');

    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    // Resend otp code
    Route::post('resend', [AuthController::class, 'sendOtp']);

    // Verify email
    Route::post('verify-email/{user:otp_secret_slug}', [EmailVerificationController::class, 'checkOtp'])
        ->missing(fn() => response()->json(["errors" => "Link Expired", 'status' => 410], 404));


    Route::get('not-auth', function () {
        return response()->json(["errors" => 'You are not authorized'], 401);
    })->name('login');

});
