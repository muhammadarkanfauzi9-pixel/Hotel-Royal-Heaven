<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminMemberController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\ReviewController;

// Public landing page (controller-driven to fetch featured rooms)
Route::get('/', [KamarController::class, 'landing'])->name('landing');

use App\Http\Controllers\Member\KamarController as MemberKamarController;
use Illuminate\Support\Facades\Auth;

Route::get('/home', function () {
    return view('home');
})->name('home');

// Daftar kamar route accessible publicly for both guests and members
// Daftar kamar route accessible publicly for both guests and members
Route::get('/daftarkamar', [KamarController::class, 'index'])->name('daftarkamar');

// About page
Route::get('/about', function () {
    return view('about');
})->name('about');

// Admin dashboard - protected by IsAdmin middleware
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('admin', [AdminMemberController::class, 'index'])->name('admin.index');
    
    Route::resource('kamar', KamarController::class)->except(['show']);
    Route::get('pemesanan', [PemesananController::class, 'index'])->name('pemesanan.index');
    Route::post('pemesanan/{pemesanan}/status', [PemesananController::class, 'updateStatus'])->name('pemesanan.updateStatus');

    // Management Member routes for admin
    Route::get('admin/members', [App\Http\Controllers\AdminMemberController::class, 'index'])->name('admin.members.index');
    Route::get('admin/members/create', [App\Http\Controllers\AdminMemberController::class, 'create'])->name('admin.members.create');
    Route::post('admin/members', [App\Http\Controllers\AdminMemberController::class, 'store'])->name('admin.members.store');
    Route::get('admin/members/{member}/edit', [App\Http\Controllers\AdminMemberController::class, 'edit'])->name('admin.members.edit');
    Route::put('admin/members/{member}', [App\Http\Controllers\AdminMemberController::class, 'update'])->name('admin.members.update');
    Route::delete('admin/members/{member}', [App\Http\Controllers\AdminMemberController::class, 'destroy'])->name('admin.members.destroy');
});

// Auth
// Override register routes to prevent admin from registering
Route::get('register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('register', [AuthController::class, 'register'])->middleware('guest');
Route::get('login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'login'])->middleware('guest');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Password reset
Route::get('password/forgot', [AuthController::class, 'showForgot'])->name('password.request');
Route::post('password/email', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [AuthController::class, 'reset'])->name('password.update');

use App\Http\Controllers\ProfileController;

// Member routes - protected by auth middleware
Route::middleware(['auth'])->group(function(){
    Route::get('pemesanan/create', [PemesananController::class, 'create'])->name('pemesanan.create');
    Route::post('pemesanan', [PemesananController::class, 'store'])->name('pemesanan.store');
    Route::get('pemesanan/my', [PemesananController::class, 'myBookings'])->name('pemesanan.my');
    Route::get('pemesanan/{pemesanan}', [PemesananController::class, 'show'])->name('pemesanan.show');
    Route::delete('pemesanan/{pemesanan}/cancel', [PemesananController::class, 'cancelBooking'])->name('pemesanan.cancel');

    // Review
    Route::post('reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Member Profile routes
    Route::get('profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Midtrans payment notification webhook endpoint (public)
Route::post('/midtrans/notification', [PemesananController::class, 'midtransNotification'])->name('midtrans.notification');
