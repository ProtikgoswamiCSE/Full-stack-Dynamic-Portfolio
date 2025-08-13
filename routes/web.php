<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;


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

Route::get('/work', function () {
    return view('work');
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

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/edit-home', [AdminController::class, 'editHome'])->name('admin.edit-home');
    Route::post('/update-home', [AdminController::class, 'updateHome'])->name('admin.update-home');
    Route::get('/initialize-content', [AdminController::class, 'initializeContent'])->name('admin.initialize-content');
    
    // Social Media Management
    Route::post('/social-links/add', [AdminController::class, 'addSocialLink'])->name('admin.social-links.add');
    Route::put('/social-links/{id}/update', [AdminController::class, 'updateSocialLink'])->name('admin.social-links.update');
    Route::delete('/social-links/{id}/delete', [AdminController::class, 'deleteSocialLink'])->name('admin.social-links.delete');
    Route::patch('/social-links/{id}/toggle', [AdminController::class, 'toggleSocialLink'])->name('admin.social-links.toggle');
});
