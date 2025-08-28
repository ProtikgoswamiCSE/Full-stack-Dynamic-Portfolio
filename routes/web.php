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
    Route::get('/', [AdminController::class, 'editHome'])->name('admin.home');
    Route::get('/edit-home', [AdminController::class, 'editHome'])->name('admin.edit-home');
    Route::post('/update-home', [AdminController::class, 'updateHome'])->name('admin.update-home');
    
    // Achievement Management Routes
    Route::post('/achievement/add', [AdminController::class, 'addAchievement'])->name('admin.achievement.add');
    Route::post('/achievement/{id}/update', [AdminController::class, 'updateAchievement'])->name('admin.achievement.update');
    Route::post('/achievement/{id}/delete', [AdminController::class, 'deleteAchievement'])->name('admin.achievement.delete');
    Route::post('/achievement/{id}/toggle', [AdminController::class, 'toggleAchievement'])->name('admin.achievement.toggle');
    
    // Other admin routes...
    Route::get('/edit-about', [AdminController::class, 'editAbout'])->name('admin.edit-about');
    Route::get('/edit-achivement', [AdminController::class, 'editAchivement'])->name('admin.edit-achivement');
    Route::get('/edit-academic', [AdminController::class, 'editAcademic'])->name('admin.edit-academic');
    Route::get('/edit-work', [AdminController::class, 'editWork'])->name('admin.edit-work');
    Route::get('/edit-image', [AdminController::class, 'editImage'])->name('admin.edit-image');
    Route::get('/edit-contact', [AdminController::class, 'editContact'])->name('admin.edit-contact');
    Route::get('/edit-footer', [AdminController::class, 'editFooter'])->name('admin.edit-footer');
    Route::post('/update-footer', [AdminController::class, 'updateFooter'])->name('admin.footer.update');
    
    // Footer Social Links Management
    Route::post('/footer/social/add', [AdminController::class, 'addFooterSocialLink'])->name('admin.footer.social.add');
    Route::post('/footer/social/{id}/update', [AdminController::class, 'updateFooterSocialLink'])->name('admin.footer.social.update');
    Route::post('/footer/social/{id}/delete', [AdminController::class, 'deleteFooterSocialLink'])->name('admin.footer.social.delete');
    Route::post('/footer/social/{id}/toggle', [AdminController::class, 'toggleFooterSocialLink'])->name('admin.footer.social.toggle');
    
    // Social Media Links Management
    Route::post('/social/add', [AdminController::class, 'addSocialLink'])->name('admin.social.add');
    Route::post('/social/{id}/update', [AdminController::class, 'updateSocialLink'])->name('admin.social.update');
    Route::post('/social/{id}/delete', [AdminController::class, 'deleteSocialLink'])->name('admin.social.delete');
    Route::post('/social/{id}/toggle', [AdminController::class, 'toggleSocialLink'])->name('admin.social.toggle');
    
    // Skills Management
    Route::post('/skills/add', [AdminController::class, 'addSkill'])->name('admin.skills.add');
    Route::post('/skills/{id}/update', [AdminController::class, 'updateSkill'])->name('admin.skills.update');
    Route::post('/skills/{id}/delete', [AdminController::class, 'deleteSkill'])->name('admin.skills.delete');
    Route::post('/skills/{id}/toggle', [AdminController::class, 'toggleSkill'])->name('admin.skills.toggle');
});
