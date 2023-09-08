<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['admin', 'editor'])->group(function () {

// Hadis
    Route::post('hadis/store', [\App\Http\Controllers\HadisController::class, 'store']); // create(Add new hadis) TODO: ADMINS, EDITOR
    Route::put('hadis/update/{hadis}', [\App\Http\Controllers\HadisController::class, "update"])
        ->missing(fn() => response()->json(['errors' => "Hadis not found"], 404)); // update TODO:  Admins, EDITOR

// Teller
    Route::post('teller/store', [TellerController::class, 'store']); // Create(Add new teller) TODO: Admins, EDITOR

    Route::put('teller/update/{teller}', [TellerController::class, 'update'])
        ->missing(fn() => response()->json(["errors" => "Category not found"], 404)); // Update TODO: Admins, EDITOR

// Category
    Route::post('category/store', [CategoryController::class, 'store']); // create(Add new category) TODO: Admins, EDITOR
    Route::put('category/update/{category}', [CategoryController::class, 'update'])
        ->missing(fn() => response()->json(["errors" => "Category not found"], 404)); // Update TODO: Admins, EDITOR


// Book
    Route::post('book/store', [\App\Http\Controllers\BookController::class, 'store']); // create TODO: Admins, EDITOR

    Route::put('book/update/{book}', [\App\Http\Controllers\BookController::class, 'update'])
        ->missing(fn() => response()->json(['errors' => 'Book not found'], 404)); // update TODO: Admins, EDITOR


// Chapter
    Route::post('/chapter/store', [\App\Http\Controllers\ChapterController::class, 'store']); // create(Add new chapter)  TODO: Admins, EDITOR

    Route::put('/chapter/update/{chapter}', [\App\Http\Controllers\ChapterController::class, 'update'])
        ->missing(fn() => response()->json(["errors" => "Chapter not found"], 404)); // update TODO: Admins, EDITOR
});
