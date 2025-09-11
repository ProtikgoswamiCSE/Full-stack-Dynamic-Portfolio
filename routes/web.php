<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdminAuthController;


Route::get('/', function () {
    return view('home');
})->name('home');

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

// API route to get current profile settings (for frontend refresh)
Route::get('/api/profile-settings', function () {
    $settings = \App\Models\ProfileImageSetting::getSettings();
    return response()->json([
        'background_color' => $settings->background_color,
        'border_color' => $settings->border_color,
        'shadow_color' => $settings->shadow_color,
        'shadow_opacity' => $settings->shadow_opacity,
        'profile_image' => $settings->profile_image,
        'updated_at' => $settings->updated_at
    ]);
});

// Admin Authentication Routes
Route::prefix('admin')->group(function () {
    // Auth routes (accessible without login)
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::get('/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
    Route::post('/register', [AdminAuthController::class, 'register']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    
    // Redirect admin root to login if not authenticated
    Route::get('/', function () {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.login');
    });
});

// Protected Admin Routes (require authentication)
Route::prefix('admin')->middleware(['auth', 'web'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/edit-home', [AdminController::class, 'editHome'])->name('admin.edit-home');
    Route::post('/update-home', [AdminController::class, 'updateHome'])->name('admin.update-home');
    Route::post('/update-profile-image', [AdminController::class, 'updateProfileImage'])->name('admin.update-profile-image');
    
    // Achievement Management Routes
    Route::get('/achievement/{id}', [AdminController::class, 'getAchievement'])->name('admin.achievement.get');
    Route::post('/achievement/add', [AdminController::class, 'addAchievement'])->name('admin.achievement.add');
    Route::post('/achievement/{id}/update', [AdminController::class, 'updateAchievement'])->name('admin.achievement.update');
    Route::post('/achievement/{id}/delete', [AdminController::class, 'deleteAchievement'])->name('admin.achievement.delete');
    Route::post('/achievement/{id}/toggle', [AdminController::class, 'toggleAchievement'])->name('admin.achievement.toggle');
    
    // Academic Management Routes
    Route::get('/academic/{id}', [AdminController::class, 'getAcademic'])->name('admin.academic.get');
    Route::post('/academic/add', [AdminController::class, 'addAcademic'])->name('admin.academic.add');
    Route::post('/academic/{id}/update', [AdminController::class, 'updateAcademic'])->name('admin.academic.update');
    Route::post('/academic/{id}/delete', [AdminController::class, 'deleteAcademic'])->name('admin.academic.delete');
    Route::post('/academic/{id}/toggle', [AdminController::class, 'toggleAcademic'])->name('admin.academic.toggle');
    
    // Other admin routes...
    Route::get('/edit-about', [AdminController::class, 'editAbout'])->name('admin.edit-about');
    
    // About Content Management
    Route::get('/about/{id}', [AdminController::class, 'getAboutContent'])->name('admin.about.get');
    Route::post('/about/add', [AdminController::class, 'addAboutContent'])->name('admin.about.add');
    Route::post('/about/{id}/update', [AdminController::class, 'updateAboutContent'])->name('admin.about.update');
    Route::post('/about/{id}/delete', [AdminController::class, 'deleteAboutContent'])->name('admin.about.delete');
    Route::post('/about/{id}/toggle', [AdminController::class, 'toggleAboutContent'])->name('admin.about.toggle');
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
    
    // Data Management Routes
    Route::get('/data-management', [AdminController::class, 'dataManagement'])->name('admin.data-management');
    Route::post('/data/reload', [AdminController::class, 'reloadData'])->name('admin.data.reload');
    Route::post('/data/clear', [AdminController::class, 'clearData'])->name('admin.data.clear');
    Route::post('/data/backup', [AdminController::class, 'createBackup'])->name('admin.data.backup');
    Route::post('/data/restore', [AdminController::class, 'restoreData'])->name('admin.data.restore');
    Route::get('/data/backups', [AdminController::class, 'listBackups'])->name('admin.data.backups');
});
