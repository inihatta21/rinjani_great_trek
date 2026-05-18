<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PaketController;
use Illuminate\Support\Facades\Route;

Route::post('/admin-login', [AuthController::class, 'adminLogin'])->middleware('throttle:admin-login');
Route::post('/admin-logout', [AuthController::class, 'adminLogout']);
Route::post('/update-account', [AuthController::class, 'adminAccountUpdate']);
Route::get('/paket', [PaketController::class, 'index']);
Route::post('/paket', [PaketController::class, 'store']);
Route::get('/paket/{id_paket}', [PaketController::class, 'show']);
Route::put('/paket/{id_paket}', [PaketController::class, 'update']);
Route::patch('/paket/{id_paket}', [PaketController::class, 'update']);
Route::delete('/paket/{id_paket}', [PaketController::class, 'destroy']);
Route::get('/artikel', [ArtikelController::class, 'index']);
Route::post('/artikel', [ArtikelController::class, 'store']);
Route::get('/artikel/{id_artikel}', [ArtikelController::class, 'show']);
Route::put('/artikel/{id_artikel}', [ArtikelController::class, 'update']);
Route::patch('/artikel/{id_artikel}', [ArtikelController::class, 'update']);
Route::delete('/artikel/{id_artikel}', [ArtikelController::class, 'destroy']);
Route::get('/gallery', [GalleryController::class, 'index']);
Route::post('/gallery', [GalleryController::class, 'store']);
Route::delete('/gallery/{id_foto}', [GalleryController::class, 'destroy']);
