<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\NewsController;
use App\Models\News;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;

// Route::get('/search', [SearchController::class, 'search'])->name('search');


// Route::get('/',[LandingController::class,'index'])->name('landing');

// Route::get('/{slug}', [NewsController::class,'category'])->name('news.category');
// Route::get('/news/{slug}', [NewsController::class,'show'])->name('news.show');

// Route::get('/author/{username}', [AuthorController::class,'show'])->name('author.show');

// 1. Search route
Route::get('/search', [SearchController::class, 'search'])->name('search');

// 2. Homepage
Route::get('/', [LandingController::class, 'index'])->name('landing');

// 3. Author (lebih spesifik, letakkan sebelum catch-all slug)
Route::get('/author/{username}', [AuthorController::class, 'show'])->name('author.show');

// 4. Detail berita
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

// 5. Kategori berita (catch-all di paling bawah)
Route::get('/{slug}', [NewsController::class, 'category'])->name('news.category');
