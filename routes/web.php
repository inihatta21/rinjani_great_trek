<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PaketController;
use App\Models\Artikel;
use App\Models\Gallery;
use App\Models\Paket;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

Route::get('/language/{locale}', function (string $locale) {
    if (! in_array($locale, ['id', 'en'], true)) {
        $locale = 'id';
    }

    session(['locale' => $locale]);

    return redirect()->back();
})->name('language.switch');

Route::get('/storage/{path}', function (string $path) {
    $normalizedPath = ltrim($path, '/');

    if (str_contains($normalizedPath, '..')) {
        abort(404);
    }

    $filePath = public_path('storage/'.$normalizedPath);

    if (! is_file($filePath)) {
        abort(404);
    }

    $mimeType = File::mimeType($filePath) ?: 'application/octet-stream';

    return response()->file($filePath, [
        'Content-Type' => $mimeType,
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->where('path', '.*');

Route::get('/media/gallery/{filename}', function (string $filename) {
    $safeFileName = basename(str_replace('\\', '/', trim($filename)));

    if ($safeFileName === '' || $safeFileName === '.' || $safeFileName === '..') {
        abort(404);
    }

    $filePath = public_path('storage/uploads/gallery/'.$safeFileName);
    if (! is_file($filePath)) {
        abort(404);
    }

    $mimeType = File::mimeType($filePath) ?: 'application/octet-stream';

    return response()->file($filePath, [
        'Content-Type' => $mimeType,
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->name('gallery.media');

Route::get('/maintenance/clear-cache', function () {
    $key = request()->query('key');
    $expectedKey = (string) env('MAINTENANCE_KEY', '');

    if ($expectedKey === '' || ! hash_equals($expectedKey, (string) $key)) {
        abort(403);
    }

    Artisan::call('optimize:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('cache:clear');

    return response()->json([
        'ok' => true,
        'message' => 'Cache berhasil dibersihkan.',
    ]);
});

Route::get('/', function () {
    $paketList = Paket::orderBy('kategori')->orderByDesc('id_paket')->get();
    $featuredPaketList = Paket::inRandomOrder()->take(3)->get();
    $artikelList = Artikel::orderByDesc('id_artikel')->take(3)->get();
    $galleryList = Gallery::orderByDesc('id_foto')->take(4)->get();

    return view('welcome', [
        'paketList' => $paketList,
        'featuredPaketList' => $featuredPaketList,
        'artikelList' => $artikelList,
        'galleryList' => $galleryList,
    ]);
});
Route::get('/paket/kategori/{id}', [PaketController::class, 'publicByKategori'])
    ->whereNumber('id')
    ->name('paket.kategori');
Route::get('/paket/{id_paket}', [PaketController::class, 'publicDetail'])->name('paket.show');
Route::get('/artikel', [ArtikelController::class, 'publicIndex'])->name('artikel.index');
Route::get('/artikel/{id_artikel}', [ArtikelController::class, 'publicDetail'])->name('artikel.show');
Route::get('/gallery', [GalleryController::class, 'publicIndex'])->name('gallery.index');
Route::get('/about', [AboutController::class, 'index'])->name('about.index');

Route::get('/admin-login', function () {
    if (session()->has('admin_token')) {
        return redirect()->route('admin.dashboard');
    }

    return view('auth.login');
})->name('admin.login');
Route::post('/admin-login', [AuthController::class, 'adminLogin'])
    ->middleware('throttle:admin-login')
    ->name('admin.login.submit');
Route::get('/admin-forgot-password', [AuthController::class, 'showAdminForgotPasswordForm'])->name('admin.password.request');
Route::post('/admin-forgot-password', [AuthController::class, 'adminForgotPassword'])
    ->middleware('throttle:admin-forgot-password')
    ->name('admin.password.forgot');
Route::get('/admin-reset-password/{token}', [AuthController::class, 'showAdminResetPasswordForm'])->name('admin.password.reset');
Route::post('/admin-reset-password', [AuthController::class, 'resetAdminPassword'])
    ->middleware('throttle:admin-reset-password')
    ->name('admin.password.update');
Route::post('/admin-logout', [AuthController::class, 'adminLogout'])->middleware('admin.auth')->name('admin.logout');
Route::get('/admin-dashboard', function () {
    return view('admin.dashboard');
})->middleware('admin.auth')->name('admin.dashboard');
Route::get('/admin-paket', [PaketController::class, 'managePage'])->middleware('admin.auth')->name('admin.paket.index');
Route::get('/admin-paket/create', [PaketController::class, 'createPage'])->middleware('admin.auth')->name('admin.paket.create');
Route::post('/admin-paket', [PaketController::class, 'store'])->middleware('admin.auth')->name('admin.paket.store');
Route::get('/admin-paket/{id_paket}/edit', [PaketController::class, 'editPage'])->middleware('admin.auth')->name('admin.paket.edit');
Route::put('/admin-paket/{id_paket}', [PaketController::class, 'update'])->middleware('admin.auth')->name('admin.paket.update');
Route::delete('/admin-paket/{id_paket}', [PaketController::class, 'destroy'])->middleware('admin.auth')->name('admin.paket.destroy');
Route::get('/admin-kategori', [KategoriController::class, 'managePage'])->middleware('admin.auth')->name('admin.kategori.index');
Route::post('/admin-kategori', [KategoriController::class, 'store'])->middleware('admin.auth')->name('admin.kategori.store');
Route::get('/admin-kategori/{id}/edit', [KategoriController::class, 'editPage'])->middleware('admin.auth')->name('admin.kategori.edit');
Route::put('/admin-kategori/{id}', [KategoriController::class, 'update'])->middleware('admin.auth')->name('admin.kategori.update');
Route::delete('/admin-kategori/{id}', [KategoriController::class, 'destroy'])->middleware('admin.auth')->name('admin.kategori.destroy');
Route::get('/admin-artikel', [ArtikelController::class, 'managePage'])->middleware('admin.auth')->name('admin.artikel.index');
Route::get('/admin-artikel/create', [ArtikelController::class, 'createPage'])->middleware('admin.auth')->name('admin.artikel.create');
Route::post('/admin-artikel', [ArtikelController::class, 'store'])->middleware('admin.auth')->name('admin.artikel.store');
Route::get('/admin-artikel/{id_artikel}/edit', [ArtikelController::class, 'editPage'])->middleware('admin.auth')->name('admin.artikel.edit');
Route::put('/admin-artikel/{id_artikel}', [ArtikelController::class, 'update'])->middleware('admin.auth')->name('admin.artikel.update');
Route::delete('/admin-artikel/{id_artikel}', [ArtikelController::class, 'destroy'])->middleware('admin.auth')->name('admin.artikel.destroy');
Route::get('/admin-gallery', [GalleryController::class, 'managePage'])->middleware('admin.auth')->name('admin.gallery.index');
Route::post('/admin-gallery', [GalleryController::class, 'store'])->middleware('admin.auth')->name('admin.gallery.store');
Route::delete('/admin-gallery/{id_foto}', [GalleryController::class, 'destroy'])->middleware('admin.auth')->name('admin.gallery.destroy');
Route::get('/admin-account', [AuthController::class, 'adminAccountEdit'])->middleware('admin.auth')->name('admin.account.edit');
Route::post('/update-account', [AuthController::class, 'adminAccountUpdate'])->middleware('admin.auth')->name('admin.account.update');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
