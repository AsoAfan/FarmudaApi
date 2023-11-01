<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\HadisController;
use App\Http\Controllers\TellerController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'role:admin,editor'])->group(function () {
    Route::get('/ae/test', fn() => auth()->user());

// Hadis
    Route::post('/hadis/store', [HadisController::class, 'store']); // create(Add new hadis) TODO: ADMINS, EDITOR

    Route::get('/hadis/toggle-feature/{hadis}', [HadisController::class, 'toggleFeature'])
        ->missing(fn() => response()->json(["errors" => ["Hadis not found"]], 400)); // update toggle statues toFALSE if True and to TRUE if False


    Route::put('/hadis/featured/update', [HadisController::class, "updateFeaturedLength"]);

    Route::put('hadis/update/{hadis}', [HadisController::class, "update"])
        ->missing(fn() => response()->json(['errors' => ["Hadis not found"]], 400)); // update TODO:  Admins, EDITOR

    Route::delete('/hadis/destroy/{hadis}', [HadisController::class, 'destroy'])
        ->missing(fn() => response()->json(['errors' => ["Hadis not found"]], 400)); // Delete  TODO: Admins


// Teller
    Route::post('teller/store', [TellerController::class, 'store']); // Create(Add new teller) TODO: Admins, EDITOR

    Route::put('teller/update/{teller}', [TellerController::class, 'update'])
        ->missing(fn() => response()->json(["errors" => ["Teller not found"]], 400)); // Update TODO: Admins, EDITOR

// Category
    Route::post('category/store', [CategoryController::class, 'store']); // create(Add new category) TODO: Admins, EDITOR
    Route::put('category/update/{category}', [CategoryController::class, 'update'])
        ->missing(fn() => response()->json(["errors" => ["Category not found"]], 400)); // Update TODO: Admins, EDITOR


// Book
    Route::post('book/store', [BookController::class, 'store']); // create TODO: Admins, EDITOR

    Route::put('book/update/{book}', [BookController::class, 'update'])
        ->missing(fn() => response()->json(['errors' => ['Book not found']], 400)); // update TODO: Admins, EDITOR


// Chapter
    Route::post('/chapter/store', [ChapterController::class, 'store']); // create(Add new chapter)  TODO: Admins, EDITOR

    Route::put('/chapter/update/{chapter}', [ChapterController::class, 'update'])
        ->missing(fn() => response()->json(["errors" => ["Chapter not found"]], 400)); // update TODO: Admins, EDITOR
});

