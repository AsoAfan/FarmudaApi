<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HadisController;
use App\Http\Controllers\TellerController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'admin'])->group(function () {



    Route::get('/testt', function (){
//        dd(request()->route()->middleware());
       return \request()->user();
    });

// User
    Route::get('/users', [UserController::class, 'index']); // TODO: Admins


// Hadises
    Route::get('/hadis/toggle-feature/{hadis}', [HadisController::class, 'toggleFeature'])
        ->missing(fn() => response()->json(["errors" => "Hadis not found", 'status' => 404], 404)); // update toggle statues toFALSE if True and to TRUE if False



    Route::delete('/hadis/destroy/{hadis}', [HadisController::class, 'destroy'])
        ->missing(fn() => response()->json(['errors' => "Hadis not found", 'status' => 404], 404)); // Delete  TODO: Admins

    Route::delete('/hadis/destroy-related/{hadis}', [HadisController::class, 'destroySet'])
        ->missing(fn() => response()->json(['errors' => "Hadis not found", 'status' => 404], 404)); // Delete  TODO: Admins



    Route::delete('teller/destroy/{teller}', [TellerController::class, 'destroy'])
        ->missing(fn() => response()->json(["errors" => "Teller not found", 'status' => 404], 404)); // Delete TODO: Admins



    Route::delete('category/destroy/{category}', [CategoryController::class, 'destroy'])
        ->missing(fn() => response()->json(["errors" => "Category not found", 'status' => 404], 404)); // Delete TODO: Admins


    Route::delete('book/destroy/{book}', [\App\Http\Controllers\BookController::class, 'destroy'])
        ->missing(fn() => response()->json(["errors" => "book not found", 'status' => 404], 404)); // delete TODO: Admins


    Route::delete('/chapter/destroy/{chapter}', [\App\Http\Controllers\ChapterController::class, 'destroy'])
        ->missing(fn() => response()->json(["errors" => "Chapter not found", 'status' => 404], 404)); // delete TODO: Admins

});
