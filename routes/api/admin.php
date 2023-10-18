<?php


\Illuminate\Support\Facades\Route::get('file-test', function () {
    return ['path' => __DIR__];
});