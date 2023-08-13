<?php

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

Route::post('hadis/store', [\App\Http\Controllers\HadisController::class, 'store'])->middleware('json');
Route::post('hadis/show', [\App\Http\Controllers\HadisController::class, 'filter'])->middleware('json');
Route::get('hadis/show', [\App\Http\Controllers\HadisController::class, 'show']);

