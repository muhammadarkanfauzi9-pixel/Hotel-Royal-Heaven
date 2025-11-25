<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KamarController as AdminKamarController;
use App\Http\Controllers\Admin\PemesananController as AdminPemesananController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use App\Http\Controllers\Member\KamarController as MemberKamarController;
use App\Http\Controllers\Member\PemesananController as MemberPemesananController;
use App\Http\Controllers\Member\ProfileController as MemberProfileController;

// Public landing page (controller-driven to fetch featured rooms)
Route::get('/', [KamarController::class, 'landing'])->name('landing');

// Public daftar kamar
Route::get('/kamar', [KamarController::class, 'index'])->name('kamar.index');

// About page
Route::get('/about', function () {
    return view('about');
})->name('about');

// Auth
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Password reset
Route::get('password/forgot', [AuthController::class, 'showForgot'])->name('password.request');
Route::post('password/email', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [AuthController::class, 'reset'])->name('password.update');

// Admin routes - protected by auth and EnsureAdmin middleware
Route::middleware(['auth', \App\Http\Middleware\EnsureAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('index');
    
    // Admin kamar management
    Route::resource('kamar', AdminKamarController::class)->except(['show']);
    
    // Admin pemesanan management
    Route::get('pemesanan', [AdminPemesananController::class, 'index'])->name('pemesanan.index');
    Route::get('pemesanan/{pemesanan}', [AdminPemesananController::class, 'show'])->name('pemesanan.show');
    Route::post('pemesanan/{pemesanan}/status', [AdminPemesananController::class, 'updateStatus'])->name('pemesanan.updateStatus');
    
    // Admin user management
    Route::resource('user', AdminUserController::class)->except(['create', 'store']);
    
    // Admin profile
    Route::get('profile', [AdminProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [AdminProfileController::class, 'update'])->name('profile.update');
});

// Member routes - protected by auth and EnsureMember middleware
Route::middleware(['auth', \App\Http\Middleware\EnsureMember::class])->prefix('member')->name('member.')->group(function () {
    Route::get('/', [MemberDashboardController::class, 'index'])->name('index');
    
    // Member daftar kamar
    Route::get('kamar', [MemberKamarController::class, 'index'])->name('kamar.index');
    Route::get('kamar/{kamar}', [MemberKamarController::class, 'show'])->name('kamar.show');
    
    // Member pemesanan
    Route::get('pemesanan', [MemberPemesananController::class, 'index'])->name('pemesanan.index');
    Route::get('pemesanan/create', [MemberPemesananController::class, 'create'])->name('pemesanan.create');
    Route::post('pemesanan', [MemberPemesananController::class, 'store'])->name('pemesanan.store');
    Route::get('pemesanan/{pemesanan}', [MemberPemesananController::class, 'show'])->name('pemesanan.show');
    
    // Member profile
    Route::get('profile', [MemberProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [MemberProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [MemberProfileController::class, 'update'])->name('profile.update');
});

