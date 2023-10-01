<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\HadisController;
use App\Http\Controllers\TellerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'admin'])->group(function () {

    Route::get('/a/test', function () {
//        dd(request()->route()->middleware());
        return \request()->user();
    });

// User
    // TODO: ADD URL TO UPDATE USER ROLE
    Route::get('/users', [UserController::class, 'index']); // TODO: Admins

    Route::get('/user/warn/{user}', [UserController::class, 'warn']);

    Route::put('/user/role/{user}', [UserController::class, 'updateRole']);


// Hadises


    Route::delete('/hadis/destroy-related/{hadis}', [HadisController::class, 'destroyRelated'])
        ->missing(fn() => response()->json(['errors' => "Hadis not found", 'status' => 404], 404)); // Delete  TODO: Admins


    Route::delete('/teller/destroy/{teller}', [TellerController::class, 'destroy'])
        ->missing(fn() => response()->json(["errors" => "Teller not found", 'status' => 404], 404)); // Delete TODO: Admins


    Route::delete('/category/destroy/{category}', [CategoryController::class, 'destroy'])
        ->missing(fn() => response()->json(["errors" => "Category not found", 'status' => 404], 404)); // Delete TODO: Admins


    Route::delete('/book/destroy/{book}', [BookController::class, 'destroy'])
        ->missing(fn() => response()->json(["errors" => "book not found", 'status' => 404], 404)); // delete TODO: Admins


    Route::delete('/chapter/destroy/{chapter}', [ChapterController::class, 'destroy'])
        ->missing(fn() => response()->json(["errors" => "Chapter not found", 'status' => 404], 404)); // delete TODO: Admins

});
