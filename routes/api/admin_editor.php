<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\HadithController;
use App\Http\Controllers\TellerController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'role:admin,editor'])->group(function () {
//    Route::get('/ae/test', fn() => auth()->user());

// hadith
    Route::post('/hadith/store', [HadithController::class, 'store']); // create(Add new hadith) TODO: ADMINS, EDITOR

    Route::get('/hadith/toggle-feature/{hadith}', [HadithController::class, 'toggleFeature'])
        ->missing(fn() => response()->json(["errors" => ["hadith not found"]], 400)); // update toggle statues toFALSE if True and to TRUE if False


    Route::put('/hadith/featured/update', [HadithController::class, "updateFeaturedLength"]);

    Route::put('hadith/update/{hadith}', [HadithController::class, "update"])
        ->missing(fn() => response()->json(['errors' => ["hadith not found"]], 400)); // update TODO:  Admins, EDITOR

    Route::delete('/hadith/delete/{hadith}', [HadithController::class, 'destroy'])
        ->missing(fn() => response()->json(['errors' => ["hadith not found"]], 400)); // Delete  TODO: Admins

    Route::delete('/hadith/destroy/{hadith}', [HadithController::class, 'forceDestroy'])
        ->missing(fn() => response()->json(['errors' => ["hadith not found"]], 400)); // Delete  TODO: Admins


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

