<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminMemberController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KamarController;
<<<<<<< HEAD
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KamarController as AdminKamarController;
use App\Http\Controllers\Admin\PemesananController as AdminPemesananController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use App\Http\Controllers\Member\KamarController as MemberKamarController;
use App\Http\Controllers\Member\PemesananController as MemberPemesananController;
use App\Http\Controllers\Member\ProfileController as MemberProfileController;
=======
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\ReviewController;
>>>>>>> origin/main

// Public landing page (controller-driven to fetch featured rooms)
Route::get('/', [KamarController::class, 'landing'])->name('landing');

<<<<<<< HEAD
// Public daftar kamar
Route::get('/kamar', [KamarController::class, 'index'])->name('kamar.index');
=======
use App\Http\Controllers\Member\KamarController as MemberKamarController;
use Illuminate\Support\Facades\Auth;

Route::get('/home', function () {
    return view('home');
})->name('home');

// Daftar kamar route accessible publicly for both guests and members
// Daftar kamar route accessible publicly for both guests and members
Route::get('/daftarkamar', [KamarController::class, 'index'])->name('daftarkamar');
>>>>>>> origin/main

// About page
Route::get('/about', function () {
    return view('about');
})->name('about');

<<<<<<< HEAD
=======
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

>>>>>>> origin/main
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

<<<<<<< HEAD
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
=======
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
>>>>>>> origin/main
});

// Midtrans payment notification webhook endpoint (public)
Route::post('/midtrans/notification', [PemesananController::class, 'midtransNotification'])->name('midtrans.notification');
