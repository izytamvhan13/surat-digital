<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValidasiSuratController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\SuratMasuk;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    $total_surat = SuratMasuk::count();
    $surat_menunggu = SuratMasuk::where('status', 'menunggu')->count();
    $surat_disetujui = SuratMasuk::where('status', 'disetujui')->count();
    $persentase = $total_surat > 0 ? ($surat_disetujui / $total_surat) * 100 : 0;

    return view('welcome', compact('total_surat', 'surat_menunggu', 'persentase'));
});

// Authentication Routes
Route::get('login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'login'])->middleware('guest');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('register.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', \App\Http\Controllers\DashboardController::class)->name('dashboard');

    Route::resource('surat', SuratMasukController::class)->except(['show']);

            Route::middleware(['can:is_admin'])->group(function () {
                Route::get('users', [UserController::class, 'index'])->name('users.index');
                Route::get('users/create', [UserController::class, 'create'])->name('users.create');
                Route::post('users', [UserController::class, 'store'])->name('users.store');
                Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
                Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
                Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
                Route::resource('kategori-surat', \App\Http\Controllers\KategoriSuratController::class)->except(['show']);
                Route::get('surat/export', [SuratMasukController::class, 'export'])->name('surat.export');
                Route::get('surat/validasi', [SuratMasukController::class, 'validasi'])->name('surat.validasi');
                Route::put('surat/{surat}/status', [SuratMasukController::class, 'updateStatus'])->name('surat.updateStatus');
            });});
