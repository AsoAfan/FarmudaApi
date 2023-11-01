<?php

use App\Http\Controllers\HadisController;
use Illuminate\Support\Facades\Route;

Route::get('/hadis/latest', [HadisController::class, 'latest']); // read | 2 latest Hadises TODO: ALL_USERS
