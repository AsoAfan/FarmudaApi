<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['admin'])->group(function () {

// User
    Route::get('/users', [UserController::class, 'index']); // TODO: Admins

// Hadises
    Route::get('/hadis/toggle-feature/{hadis}', [\App\Http\Controllers\HadisController::class, 'toggleFeature'])
        ->missing(fn() => response()->json(["errors" => "Hadis not found", 'status' => 404], 404)); // update toggle statues toFALSE if True and to TRUE if False

    Route::delete('/hadis/destroy/{hadis}', [\App\Http\Controllers\HadisController::class, 'destroy'])
        ->missing(fn() => response()->json(['errors' => "Hadis not found", 'status' => 404], 404)); // Delete  TODO: Admins

    Route::delete('/hadis/destroy-related/{hadis}', [\App\Http\Controllers\HadisController::class, 'destroySet'])
        ->missing(fn() => response()->json(['errors' => "Hadis not found"], 404)); // Delete  TODO: Admins


});
