<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('sanctum/csrf-cookie');

Route::get('/', function (){
    return redirect("https://farmudaa.com");
});

Route::get('/auth/google', [\App\Http\Controllers\Auth\SocialController::class, 'google']);

Route::get('/auth/google/callback', [\App\Http\Controllers\Auth\SocialController::class, 'callback']);


