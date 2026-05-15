<?php

use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebsiteController::class, 'index'])->name('home');
Route::get('/umkm', [WebsiteController::class, 'umkm'])->name('umkm');
Route::get('/wisata', [WebsiteController::class, 'wisata'])->name('wisata');
Route::get('/gallery', [WebsiteController::class, 'gallery'])->name('gallery');
Route::get('/berita', [WebsiteController::class, 'news'])->name('news');
Route::get('/potensi', [WebsiteController::class, 'potency'])->name('potency');
Route::get('/potensi/{slug}', [WebsiteController::class, 'potencyDetail'])->name('potency.detail');
Route::get('/tentang', [WebsiteController::class, 'about'])->name('about');
Route::post('/contact', [WebsiteController::class, 'contact'])->name('contact.send');

// Admin Auth Routes
use App\Http\Controllers\AuthController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Admin CMS Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });

        Route::get('/dashboard', function () {
            return inertia('Admin/Dashboard');
        })->name('dashboard');

        // Konten Halaman (Hero, About, dll)
        Route::resource('pages', \App\Http\Controllers\Admin\PageContentController::class)->only(['index', 'update']);

        // Berita & Pengumuman
        Route::resource('news', \App\Http\Controllers\Admin\NewsController::class)->except(['create', 'edit', 'show']);

        // Potensi Desa
        Route::resource('potency', \App\Http\Controllers\Admin\PotencyController::class)->except(['create', 'edit', 'show']);

        // UMKM
        Route::resource('umkm', \App\Http\Controllers\Admin\UmkmController::class)->except(['create', 'edit', 'show']);

        // Wisata
        Route::resource('wisata', \App\Http\Controllers\Admin\WisataController::class)
            ->parameters(['wisata' => 'wisata'])
            ->except(['create', 'edit', 'show']);

        // Gallery
        Route::resource('gallery', \App\Http\Controllers\Admin\GalleryController::class)->except(['create', 'edit', 'show']);

        // Settings
        Route::get('settings', [\App\Http\Controllers\Admin\VillageSettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [\App\Http\Controllers\Admin\VillageSettingController::class, 'update'])->name('settings.update');
    });
});
