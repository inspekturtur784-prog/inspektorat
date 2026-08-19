<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('beranda');
});

Route::get('/profile', function () {
    return view('profile');
});

Route::get('/buletin', function () {
    return view('buletin.index');
})->name('buletin.index');

Route::get('/buletin/{slug}', function ($slug) {
    return view('buletin.show', ['slug' => $slug]);
})->name('buletin.show');