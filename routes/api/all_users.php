<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HadithController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TellerController;
use Illuminate\Support\Facades\Route;

Route::get('/question/show', [QuestionController::class, 'index'])->middleware('json'); // TODO: All Users

Route::get('/hadith/count', [HadithController::class, 'count']);
Route::get('/hadith/show', [HadithController::class, 'index']); // read | ?page=num_of_page => 3 per page for now TODO:
// ALL_USERS
Route::get('/hadith/show/{hadith}', [HadithController::class, 'show']); // read | UPDATE: Returns Single hadith with specified id | EDITED: NOT with limited number of characters ?chars=max_num_of_chars TODO: ALL_USERS
Route::get('/hadith/featured', [HadithController::class, 'showFeatures']); // read |  featured hadithes with limited number of characters ?chars=max_num_of_chars TODO: ALL_USERS
Route::get('/hadith/latest', [HadithController::class, 'latest']);

Route::get('/teller/show', [TellerController::class, 'show']); // Read

Route::get('/category/show', [CategoryController::class, 'index']); // read (returns all categories) TODO: ALL_USERS


Route::get('/book/show', [BookController::class, 'index']); // read


Route::get('/chapter/show', [ChapterController::class, 'index']); // read

