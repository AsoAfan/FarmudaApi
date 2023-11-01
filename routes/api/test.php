<?php


use Illuminate\Support\Facades\Route;

Route::get('/a/test', function () {
//        dd(request()->route()->middleware());
    return ["test" => "This is a test"];
})->middleware('json');