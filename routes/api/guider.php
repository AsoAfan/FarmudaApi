<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'role:guider'])->group(function () {

});