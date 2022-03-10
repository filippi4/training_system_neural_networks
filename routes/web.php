<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'Стартовая страница';
});

Route::get('/hello', function () {
    return 'Hello World!';
});