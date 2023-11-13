<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HadisController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TellerController;
use Illuminate\Support\Facades\Route;

Route::get('/question/show', [QuestionController::class, 'index'])->middleware('json'); // TODO: All Users

Route::get('/hadis/count', [HadisController::class, 'count']);
Route::post('/hadis/show', [HadisController::class, 'index']); // read | ?page=num_of_page => 3 per page for now TODO: ALL_USERS
Route::get('/hadis/show/{hadis}', [HadisController::class, 'show']); // read | UPDATE: Returns Single hadith with specified id | EDITED: NOT with limited number of characters ?chars=max_num_of_chars TODO: ALL_USERS
Route::get('/hadis/featured', [HadisController::class, 'showFeatures']); // read |  featured Hadises with limited number of characters ?chars=max_num_of_chars TODO: ALL_USERS
Route::get('/hadis/latest', [HadisController::class, 'latest']);

Route::get('/teller/show', [TellerController::class, 'show']); // Read

Route::get('/category/show', [CategoryController::class, 'index']); // read (returns all categories) TODO: ALL_USERS


Route::get('/book/show', [BookController::class, 'index']); // read


Route::get('/chapter/show', [ChapterController::class, 'index']); // read

