<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum'])->group(function () {

    // Auth
    Route::post('auth/logout', [AuthController::class, 'logout']);


    // User
    Route::get('/user', [UserController::class, 'current']);
    Route::post('/user/image/{user}', [UserController::class, 'update']);

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


// hadith


    Route::get('/favourite', [FavouriteController::class, 'index']);

    Route::get('/favourite/{hadith}', [FavouriteController::class, 'store'])
        ->missing(fn() => response()->json(["errors" => "Page not found", "status" => 404], 404));


//    Feedback
    Route::post('/user-feedback', [FeedbackController::class, 'store']);


});
