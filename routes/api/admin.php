<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HadisController;
use App\Http\Controllers\TellerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

    // User
    Route::get('/users', [UserController::class, 'index']); // returns all users
    Route::get('/admins', [AdminController::class, 'index']);

    Route::get('/warn/{user}', [UserController::class, 'warn']); // send warning notification to user => {user} -> id

    // TODO: ADD URL TO UPDATE USER ROLE - DONE
    Route::post('/user/role/update/{user}', [AdminController::class, 'promoteRequest']);
    Route::put('/user/role/{user}', [UserController::class, 'updateRole']);


// Hadises


    Route::delete('/hadis/destroy-related/{hadis}', [HadisController::class, 'destroyRelated'])
        ->missing(fn() => response(['errors' => "Hadis not found"], 400)); // Delete


    Route::delete('/teller/destroy/{teller}', [TellerController::class, 'destroy'])
        ->missing(fn() => response(["errors" => ["Teller not found"]], 400)); // Delete


    Route::delete('/category/destroy/{category}', [CategoryController::class, 'destroy'])
        ->missing(fn() => response()->json(["errors" => ["Category not found"]], 400)); // Delete


    Route::delete('/book/destroy/{book}', [BookController::class, 'destroy'])
        ->missing(fn() => response()->json(["errors" => "book not found"], 400)); // delete


    Route::delete('/chapter/destroy/{chapter}', [ChapterController::class, 'destroy'])
        ->missing(fn() => response()->json(["errors" => ["Chapter not found"]], 400)); // delete

    Route::delete('/feedback/complete/{feedback}', [FeedbackController::class, 'delete']);
    Route::delete('/feedback/delete/{feedback}', [FeedbackController::class, 'destroy']);

});
