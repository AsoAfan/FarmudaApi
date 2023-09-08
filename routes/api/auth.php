<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\QuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {

    // Auth
    Route::post('auth/logout', [AuthController::class, 'logout']);


    // User
    Route::get('/user', function (Request $request) {


        return $request->user();
    });


    // Question
    Route::post('question/store', [QuestionController::class, 'store']); // TODO: Auth
    Route::put('question/update/{question}', [QuestionController::class, 'update'])
        ->missing(fn() => response()->json(["errors" => "Question not found"], 404)); // TODO: Auth

    Route::delete('question/destroy/{question}', [QuestionController::class, 'destroy'])
        ->missing(fn() => response()->json(["errors" => "Question not found"], 404)); // TODO: Auth
});
