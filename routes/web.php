<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/eek_ahh', function () {
    return view('eek_ahh');
});
