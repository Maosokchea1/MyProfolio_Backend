<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', fn () => redirect()->route(auth()->check() ? 'admin.dashboard' : 'admin.login'));

// Route សម្រាប់ទាញយក ឬបង្ហាញ CV ដោយសុវត្ថិភាព មិនឱ្យប៉ះបញ្ហា 403 Forbidden លើ Render
Route::get('/view-cv/{filename}', function ($filename) {
    $path = 'profiles/cv/' . $filename;

    if (!Storage::disk('public')->exists($path)) {
        abort(404, 'CV file not found.');
    }

    return Storage::disk('public')->response($path);
})->where('filename', '.*');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
    Route::get('/admin/register', [AuthController::class, 'showRegister'])->name('admin.register');
    Route::post('/admin/register', [AuthController::class, 'register'])->name('admin.register.submit');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/about', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/about', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::patch('/contacts/{contact}', [AdminContactController::class, 'update'])->name('contacts.update');
    Route::delete('/contacts/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');
    Route::get('/content/{type}', [ContentController::class, 'index'])->name('content.index');
    Route::post('/content/{type}', [ContentController::class, 'store'])->name('content.store');
    Route::put('/content/{type}/{id}', [ContentController::class, 'update'])->name('content.update');
    Route::delete('/content/{type}/{id}', [ContentController::class, 'destroy'])->name('content.destroy');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});