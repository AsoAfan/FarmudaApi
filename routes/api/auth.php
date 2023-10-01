<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\HadisController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\QuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {

    // Auth
    Route::post('auth/logout', [AuthController::class, 'logout']);


    // User
    Route::get('/user', [\App\Http\Controllers\UserController::class, 'current']);

    // Notifications
    Route::get('/user/notifications', [NotificationController::class, 'index']);
    Route::get('/user/unread-notifications', [NotificationController::class, 'unreadAll']);
    Route::get('/user/read-notifications', [NotificationController::class, 'readAll']);
    Route::get('/user/notifications/read', [NotificationController::class, 'getReadNotifications']);
    Route::get('/user/notifications/unread', [NotificationController::class, 'getUnreadNotifications']);

    // Question
    Route::post('question/store', [QuestionController::class, 'store']); // TODO: Auth
    Route::put('question/update/{question}', [QuestionController::class, 'update'])
        ->missing(fn() => response()->json(["errors" => "Question not found"], 404)); // TODO: Auth

    Route::delete('question/destroy/{question}', [QuestionController::class, 'destroy'])
        ->missing(fn() => response()->json(["errors" => "Question not found"], 404)); // TODO: Auth




// Hadis


    Route::get('/favourite', [FavouriteController::class, 'index']);

    Route::get('/favourite/{hadis}', [FavouriteController::class, 'store'])
    ->missing(fn() => response()->json(["errors" => "Page not found", "status" => 404], 404));




});
