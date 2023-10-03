<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HadisController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TellerController;
use Illuminate\Support\Facades\Route;


Route::get('/test', function () {
    return ['test' => \route('testssss')];
})->name('testssss');

Route::get('question/show', [QuestionController::class, 'index']); // TODO: All Users

Route::post('/hadis/show', [HadisController::class, 'index']); // read | ?page=num_of_page => 3 per page for now TODO: ALL_USERS
Route::get('/hadis/show/{hadis}', [HadisController::class, 'show']); // read | UPDATE: Returns Single hadith with specified id | EDITED: NOT with limited number of characters ?chars=max_num_of_chars TODO: ALL_USERS
Route::get('/hadis/featured', [HadisController::class, 'showFeatures']); // read |  featured Hadises with limited number of characters ?chars=max_num_of_chars TODO: ALL_USERS
Route::get('/hadis/latest', [HadisController::class, 'latest']); // read | 2 latest Hadises TODO: ALL_USERS

Route::get('/teller/show', [TellerController::class, 'show']); // Read TODO: All_USERS

Route::get('/category/show', [CategoryController::class, 'index']); // read (returns all categories) TODO: ALL_USERS


Route::get('/book/show', [BookController::class, 'index']); // read TODO: ALL_USERS


Route::get('/chapter/show', [\App\Http\Controllers\ChapterController::class, 'index']); // read TODO: ALL_USERS

