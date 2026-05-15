<?php

use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebsiteController::class, 'index'])->name('home');
Route::get('/umkm', [WebsiteController::class, 'umkm'])->name('umkm');
Route::get('/wisata', [WebsiteController::class, 'wisata'])->name('wisata');
Route::get('/gallery', [WebsiteController::class, 'gallery'])->name('gallery');
Route::get('/berita', [WebsiteController::class, 'news'])->name('news');
Route::get('/potensi', [WebsiteController::class, 'potency'])->name('potency');
Route::get('/tentang', [WebsiteController::class, 'about'])->name('about');
Route::post('/contact', [WebsiteController::class, 'contact'])->name('contact.send');
