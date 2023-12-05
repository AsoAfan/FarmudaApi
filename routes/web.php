<?php

use App\Http\Controllers\Auth\SocialController;
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
Route::get('/sanctum/csrf-cookie', function () {
    return ['message' => "csrf header set successfully"];
});

Route::get('/', function () {
    return redirect("https://farmudaa.com");
});
Route::post('/auth/google', [SocialController::class, 'google']);

Route::get('/auth/google/callback', [SocialController::class, 'callback']);

//Route::get('/category/show', [CategoryController::class, 'index']); // read (returns all categories) TODO: ALL_USERS


