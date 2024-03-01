<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\HadithController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TellerController;
use Illuminate\Support\Facades\Route;

Route::get('/hadith/show', [HadithController::class, 'index']); // read | ?page=num_of_page => 3 per page for now
Route::get('/hadith/search', [HadithController::class, 'search']); // read | ?page=num_of_page => 3 per page for now
Route::get('/hadith/{id}', [HadithController::class, 'show'])->missing(fn() => response(['message' => "Hadith not found", 'code' => 404], 404)); // read | UPDATE: Returns Single hadith with specified id | EDITED: NOT with limited number of characters ?chars=max_num_of_chars TODO: ALL_USERS
Route::get('/hadith/latest', [HadithController::class, 'latest']);
Route::get('/hadith/featured', [HadithController::class, 'showFeatures']); // read |  featured hadithes with limited number of characters ?chars=max_num_of_chars TODO: ALL_USERS

// move this to admin_editor
Route::get('/hadith/count', [HadithController::class, 'count']);


Route::get('/question/show', [QuestionController::class, 'index']); // TODO: All Users


// TODO:
// ALL_USERS

Route::get('/teller/show', [TellerController::class, 'show']); // Read

Route::get('/category/show', [CategoryController::class, 'index']); // read (returns all categories) TODO: ALL_USERS


Route::get('/book/show', [BookController::class, 'index']); // read


Route::get('/chapter/show', [ChapterController::class, 'index']); // read

Route::get('/feedback/show', [\App\Http\Controllers\FeedbackController::class, 'index']);

