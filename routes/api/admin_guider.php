<?php


use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'role:guider,admin'])->group(function () {


});
