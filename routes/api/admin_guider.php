<?php


use App\Http\Controllers\AnswerController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'role:guider,admin'])->group(function () {


    Route::post('/answer/store', [AnswerController::class, 'store']);


});
