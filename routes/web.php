<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/achivement', function () {
    return view('Achivement');
});
Route::get('/skills', function () {
    return view('skills');
});

Route::get('/Work', function () {
    return view('Work');
});
Route::get('/Image', function () {
    return view('Image');
});
Route::get('/academic', function () {
    return view('academic');
});
Route::get('/contact', function () {
    return view('contact');
});
