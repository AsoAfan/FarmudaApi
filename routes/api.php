<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\HadisController;
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


Route::middleware('admin')->group(function () {

//    Route::post('hadis/store', [HadisController::class, 'store'])->middleware('json');
//    Route::get('book/show',[BookController::class,'show']);
//    Route::post('chapter/store', [ChapterController::class, 'store']);
});

Route::post('hadis/store', [HadisController::class, 'store'])->middleware('json');
Route::get('hadis/show', [HadisController::class, 'show']);


Route::get('book/show', [BookController::class, 'show']);
Route::post('book/store', [BookController::class, 'store']);

Route::get('chapter/show', [ChapterController::class, 'show']);
Route::post('chapter/store', [ChapterController::class, 'store']);

