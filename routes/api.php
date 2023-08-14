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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('json')->group(function () {

// Hadis (
    Route::post('hadis/store', [\App\Http\Controllers\HadisController::class, 'store']);
    Route::get('hadis/show', [\App\Http\Controllers\HadisController::class, 'show']);
    Route::post('hadis/show', [\App\Http\Controllers\HadisController::class, 'filter']);

// Teller (create, read, update, delete)
    Route::get('teller/show', [TellerController::class, 'show']); // Read
    Route::post('teller/store', [TellerController::class, 'store']); // Create(Add new teller)
    Route::put('teller/update/{slug}', [TellerController::class, 'update']); // Update
    Route::delete('teller/destroy/{slug}', [TellerController::class, 'destroy']); // Delete

// Category
    Route::get('category/show', [CategoryController::class, 'index']);
    Route::post('category/store', [CategoryController::class, 'store']);
    Route::put('category/update/{slug}', [CategoryController::class, 'update']);
    Route::delete('category/destroy/{slug}', [CategoryController::class, 'destroy']);


});
