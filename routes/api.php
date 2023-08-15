<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TellerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*
 *
 * User roles
 * 1. Admins
 * 2. Instructors
 * 3. Auth users
 * 4. All users
 *
 * 5. Guest only (Login, Signup, ...)
 *
 * */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('json')->group(function () {

// Hadis (read, store, delete,
    Route::post('hadis/show', [\App\Http\Controllers\HadisController::class, 'index']); // read | ?page=num_of_page => 3 per page for now TODO: ALL_USERS

    Route::get('hadis/show/{num}', [\App\Http\Controllers\HadisController::class, 'show']); // read | with limited number of characters ?chars=max_num_of_chars TODO: ALL_USERS
    Route::get('hadis/latest', [\App\Http\Controllers\HadisController::class, 'latest']); // read | 2 latest Hadises TODO: ALL_USERS

    Route::post('hadis/store', [\App\Http\Controllers\HadisController::class, 'store']); // create(Add new hadis) TODO: ADMINS

    Route::put('hadis/update/{hadis}', [\App\Http\Controllers\HadisController::class, "update"])
        ->missing(fn() => response()->json(['errors' => "Hadis not found"], 404)); // TODO: not implemented |  Admins

    Route::delete('hadis/destroy/{hadis}', [\App\Http\Controllers\HadisController::class, 'destroy'])
        ->missing(fn() => response()->json(['errors' => "Hadis not found"], 404)); // Delete  TODO: Admins

// Teller (create, read, update, delete)
    Route::get('teller/show', [TellerController::class, 'show']); // Read TODO: All_USERS
    Route::post('teller/store', [TellerController::class, 'store']); // Create(Add new teller) TODO: Admins

    Route::put('teller/update/{teller}', [TellerController::class, 'update'])
        ->missing(fn() => response()->json(["errors" => "Category not found"], 404)); // Update TODO: Admins

    Route::delete('teller/destroy/{teller}', [TellerController::class, 'destroy'])
        ->missing(fn() => response()->json(["errors" => "Teller not found"], 404)); // Delete TODO: Admins
    // Delete

// Category (create, read, update, delete)
    Route::get('category/show', [CategoryController::class, 'index']); // read (returns all categories) TODO: ALL_USERS
    Route::post('category/store', [CategoryController::class, 'store']); // create(Add new category) TODO: Admins
    Route::put('category/update/{category}', [CategoryController::class, 'update'])
        ->missing(fn() => response()->json(["errors" => "Category not found"], 404)); // Update TODO: Admins

    Route::delete('category/destroy/{category}', [CategoryController::class, 'destroy'])
        ->missing(fn() => response()->json(["errors" => "Category not found"], 404)); // Delete TODO: Admins


    // Book (create, read, update and delete)
    Route::get('book/show', [\App\Http\Controllers\BookController::class, 'index']); // read TODO: ALL_USERS
    Route::post('book/store', [\App\Http\Controllers\BookController::class, 'store']); // create TODO: Admins

    Route::put('book/update/{book}', [\App\Http\Controllers\BookController::class, 'update'])
        ->missing(fn() => response()->json(['errors' => 'Book not found'], 404)); // update TODO: Admins

    Route::delete('book/delete/{book}', [\App\Http\Controllers\BookController::class, 'destroy'])
        ->missing(fn() => response()->json(["errors" => "book not found"], 404)); // delete TODO: Admins


// Chapter (create, read, update and delete)
    Route::get('/chapter/show', [\App\Http\Controllers\ChapterController::class, 'index']); // read TODO: ALL_USERS
    Route::post('/chapter/store', [\App\Http\Controllers\ChapterController::class, 'store']); // create(Add new chapter)  TODO: Admins

    Route::put('/chapter/update/{chapter}', [\App\Http\Controllers\ChapterController::class, 'update'])
        ->missing(fn() => response()->json(["errors" => "Chapter not found"], 404)); // update TODO: Admins
    Route::delete('/chapter/delete/{chapter}', [\App\Http\Controllers\ChapterController::class, 'destroy'])
        ->missing(fn() => response()->json(["errors" => "Chapter not found"], 404)); // delete TODO: Admins



    // features hadis

    Route::get('feature/hadis', [\App\Http\Controllers\FeaturedHadisController::class, 'index']);
    Route::get('feature/hadis/toggle/{hadis}', [\App\Http\Controllers\HadisController::class, 'toggleFeature'])->missing(fn() => response()->json(["errors" => "Hadis not found"], 404));
});
