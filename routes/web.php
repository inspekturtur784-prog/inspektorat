<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('beranda');
});

Route::get('/profile', function () {
    return view('profile');
});

Route::get('/buletin/{slug?}', function ($slug = null) {
    return view('buletin');
})->name('buletin');